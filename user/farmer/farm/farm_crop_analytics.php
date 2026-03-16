<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/farm.php";
include_once "../../../objects/seasonal_crop_log.php";
include_once "../../../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$farm = new Farm($db);
$order = new Order($db);
$product = new product($db);
$seasonal_crop_log = new SeasonalCropLog($db);

$page_title = "Farmer Dashboard";
$require_login = true;
include_once "../../../login_checker.php";
include_once "../layout/layout_head.php";

// Get Farmer Info
$farm->user_id = $_SESSION['user_id'];
$farm->getFarmerLocation();
$location = $farm->baranggay . ', ' . $farm->municipality . ', ' . $farm->province;

// Weather Caching Logic
$user_cache_dir = __DIR__ . '/cache/' . $_SESSION['user_id'] . '/forecast/';
if (!is_dir($user_cache_dir)) {
    mkdir($user_cache_dir, 0777, true);
}
$cache_file = $user_cache_dir . '_weather_' . md5($location) . '.json';
$cache_time = 12400; // ~3.4 hours

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    $weather = json_decode(file_get_contents($cache_file), true);
} else {
    $today = date('Y-m-d');
    $start = date('Y-m-d', strtotime('-15 days'));
    $end = date('Y-m-d', strtotime('+15 days'));
    $apiKey = 'VTZE7BHR7XAT9XD3GGS4VL3HU';
    $url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/" . urlencode($location) . "/{$start}/{$end}?unitGroup=metric&key={$apiKey}";

    $response = @file_get_contents($url);
    if($response) {
        $weather = json_decode($response, true);
        file_put_contents($cache_file, json_encode($weather));
    }
}

// Season Determination
$past = []; $future = []; $rainyDays = 0; $totalDaysCount = 0;
if (isset($weather['days'])) {
    $today_ts = strtotime(date('Y-m-d'));
    foreach ($weather['days'] as $day) {
        $totalDaysCount++;
        $isRainy = false;
        if (isset($day['precip']) && $day['precip'] >= 1) $isRainy = true;
        elseif (isset($day['precipprob']) && $day['precipprob'] >= 50) $isRainy = true;
        if ($isRainy) $rainyDays++;
    }
}
$season = ($totalDaysCount > 0 && ($rainyDays / $totalDaysCount >= 0.4)) ? "Rainy Season" : "Dry Season";
$seasonal_crop_log->current_season = $season;
$SC_stmt = $seasonal_crop_log->getSeasonalCrops();
?>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    }

    body { background-color: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; }

    /* Summary Card Styling */
    .summary-card {
        border: none;
        border-radius: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }
    .icon-box {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
    }

    /* Weather Specific Card */
    .season-card-rainy { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; }
    .season-card-dry { background: linear-gradient(135deg, #ea580c 0%, #fbbf24 100%); color: white; }

    /* Tabs Styling */
    .nav-pills .nav-link {
        border-radius: 12px;
        color: #64748b;
        font-weight: 600;
        padding: 10px 24px;
        border: 1px solid transparent;
    }
    .nav-pills .nav-link.active {
        background: var(--primary-gradient) !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        border-color: rgba(255,255,255,0.2);
    }

    .analytics-container {
        background: white;
        border-radius: 28px;
        border: 1px solid #e2e8f0;
    }
    
    .two-d-border { border: 1px solid #e2e8f0 !important; }
</style>

<div class="container-fluid py-4 px-lg-5">
    
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark mb-1">Mabuhay, Farmer! 👩‍🌾</h2>
            <p class="text-muted mb-0">Overview for your farm in <span class="fw-bold text-primary"><?= htmlspecialchars($location) ?></span></p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge bg-white text-dark border p-2 px-3 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 me-2 text-primary"></i> <?= date('F d, Y') ?>
            </span>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card summary-card <?= ($season === "Rainy Season") ? "season-card-rainy" : "season-card-dry" ?> h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-uppercase small fw-bold opacity-75 mb-1">Current Climate</h6>
                            <h3 class="fw-bold mb-0"><?= $season ?></h3>
                        </div>
                        <div class="icon-box bg-white bg-opacity-25">
                            <i class="bi <?= ($season === "Rainy Season") ? "bi-cloud-rain-heavy" : "bi-sun" ?> fs-3 text-white"></i>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex align-items-center small opacity-90">
                            <i class="bi bi-info-circle me-2"></i>
                            <span><?= $rainyDays ?> rainy days in the 30-day window</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card summary-card bg-white h-100 shadow-sm border border-light">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small fw-bold text-muted mb-1">Pending Orders</h6>
                        <h3 class="fw-bold mb-1 text-dark">--</h3> <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill small">Action Required</span>
                    </div>
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card summary-card bg-white h-100 shadow-sm border border-light">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small fw-bold text-muted mb-1">Total Sales</h6>
                        <h3 class="fw-bold mb-1 text-dark">₱ 0.00</h3> <span class="badge bg-success bg-opacity-10 text-success rounded-pill small">+0% from last week</span>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-graph-up-arrow fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="analytics-container p-4 shadow-sm bg-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Analytics Overview</h4>
                        <p class="text-muted small mb-0">Performance insights across products and sales</p>
                    </div>
                    
                    <ul class="nav nav-pills gap-2 bg-light p-1 rounded-3" id="analyticsTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#daily" type="button">
                                <i class="bi bi-grid-1x2 me-2"></i>Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products_tab" type="button">
                                <i class="bi bi-seedling me-2"></i>Products
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="sales-tab" data-bs-toggle="tab" data-bs-target="#annually" type="button">
                                <i class="bi bi-cash-stack me-2"></i>Sales
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="analyticsTabContent">
                    <div class="tab-pane fade show active" id="daily" role="tabpanel">
                        <div class="p-2" style="position: relative; height:350px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="products_tab" role="tabpanel">
                        <div class="p-2">
                             <?php include_once "analytics/product_analytics.php"; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="annually" role="tabpanel">
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-file-earmark-bar-graph display-4 text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted">No Annual Data Yet</h5>
                            <p class="small text-muted">Complete more orders to see your yearly growth.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample Chart Initialization
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales Velocity',
                data: [12, 19, 3, 5, 2, 3, 7],
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

<?php include_once "../layout/layout_foot.php"; ?>