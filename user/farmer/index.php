<?php
ob_start();
include_once "../../config/core.php";
include_once "../../config/database.php";
$page_title = "Index";
$require_login = true;
include_once "../../login_checker.php";
include_once "layout/layout_head.php";

// Alert Section
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-modern alert-success mx-4 mt-3'><i class='bi bi-check2-circle me-2'></i> {$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-modern alert-danger mx-4 mt-3'><i class='bi bi-x-circle me-2'></i> {$_SESSION['error_message']}</div>";
    unset($_SESSION['error_message']);
}

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$review = new Review($db);

$review->farmer_id = $_SESSION['user_id'];
$ratingData = $review->getFarmerRating();
$seller_rating = $ratingData['seller_rating'];
$total_reviews = $ratingData['total_reviews'];

if ($_SESSION['is_farm_registered'] == 0) {
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once "../../config/database.php";
        include_once "../../objects/farm.php";
        include_once "../../objects/user.php";
        $database = new Database();
        $db = $database->getConnection();
        $farm = new Farm($db);
        $user = new User($db);
        $farm->user_id = $_SESSION['user_id'];
        $farm->province = $_POST['province_name'];
        $farm->municipality = $_POST['municipality_name'];
        $farm->baranggay = $_POST['barangay_name'];
        $farm->purok = $_POST['purok'];
        $farm->farm_ownership = $_POST['farm_ownership'];
        $farm->lot_size = $_POST['lot_size'];
        $farm->latitude = $_POST['latitude'];
        $farm->longitude = $_POST['longitude'];

        if ($farm->createFarmInfo()) {
            $user->farm_details_exists = 1;
            $user->id = $_SESSION['user_id'];
            if ($user->markFarmAsExists()) {
                $_SESSION['is_farm_registered'] = 1;
                $_SESSION['success_message'] = "Farm Details saved successfully!";
                header("Location: {$base_url}user/farmer/index.php");
                exit;
            }
        }
        $_SESSION['error_message'] = "Failed to save details.";
        header("Location: {$base_url}user/farmer/index.php");
        exit;
    }
    include_once "farm/farm_detail.php";
} else {
    $order->farmer_id = $_SESSION['user_id'];
    $pending_order_count = $order->countPendingOrder();
    $completed_order_count = $order->countCompletedOrder();
    $total = $order->totalSales();
?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
        --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
        --surface-color: #ffffff;
        --text-main: #0f172a;
    }

    body { background-color: #f1f5f9; color: var(--text-main); font-family: 'Plus Jakarta Sans', sans-serif; }

    /* Main Card Style */
    .glass-card {
        background: var(--surface-color);
        border: 1px solid rgba(255, 255, 255, 0.7);
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    /* KPI Cards */
    .kpi-card {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 20px;
        color: white;
    }

    .kpi-card.sales { background: var(--success-gradient); }
    .kpi-card.pending { background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%); }
    .kpi-card.completed { background: var(--primary-gradient); }

    .kpi-icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.2;
    }

    /* Chart Elements */
    .chart-container {
        position: relative;
        padding: 1rem;
    }

    .chart-header-element {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .dot-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #3b82f6;
    }

    /* Navigation */
    .nav-pills-rounded {
        background: #f8fafc;
        border-radius: 12px;
        padding: 5px;
    }

    .nav-pills-rounded .nav-link {
        border-radius: 10px;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 20px;
        border: none;
    }

    .nav-pills-rounded .nav-link.active {
        background: white;
        color: #1e293b;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }

    .alert-modern { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
</style>

<div class="container-fluid py-4 px-lg-5">

    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card kpi-card sales h-100 p-4 shadow">
                <i class="bi bi-cash-stack kpi-icon-bg"></i>
                <div class="d-flex flex-column h-100">
                    <span class="text-uppercase fw-bold small opacity-75">Revenue Overview</span>
                    <h2 class="display-6 fw-bold my-2">₱<?php echo number_format($total,2);?></h2>
                    <div class="mt-auto small"><i class="bi bi-arrow-up-right me-1"></i> Total Sales to date</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card kpi-card pending h-100 p-4 shadow">
                <i class="bi bi-clock-history kpi-icon-bg"></i>
                <div class="d-flex flex-column h-100">
                    <span class="text-uppercase fw-bold small opacity-75">Orders to Process</span>
                    <h2 class="display-6 fw-bold my-2"><?php echo $pending_order_count;?></h2>
                    <div class="mt-auto small"><i class="bi bi-exclamation-circle me-1"></i> Requires attention</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card kpi-card completed h-100 p-4 shadow">
                <i class="bi bi-check2-circle kpi-icon-bg"></i>
                <div class="d-flex flex-column h-100">
                    <span class="text-uppercase fw-bold small opacity-75">Successful Deals</span>
                    <h2 class="display-6 fw-bold my-2"><?php echo $completed_order_count;?></h2>
                    <div class="mt-auto small"><i class="bi bi-trophy me-1"></i> Total completed</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-12">
            <div class="glass-card p-4">
                <div class="row align-items-center">
                    <div class="col-md-6 border-end">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <h6 class="fw-bold mb-0">Seller Reputation</h6>
                        </div>
                        <?php include_once "layout/farm_ratings.php"; ?>
                    </div>
                    <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-activity text-primary"></i>
                            <h6 class="fw-bold mb-0">Daily Engagement</h6>
                        </div>
                        <?php include_once "layout/daily_log_stats.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="glass-card p-4 h-100">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                    <div class="chart-header-element">
                        <div class="dot-indicator"></div>
                        <h5 class="fw-bold mb-0">Sales Performance</h5>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill small">Real-time</span>
                    </div>
                    <nav class="nav nav-pills nav-pills-rounded" role="tablist">
                        <a class="nav-link active" data-bs-toggle="tab" href="#daily_graph">Daily</a>
                        <a class="nav-link" data-bs-toggle="tab" href="#monthly_graph">Monthly</a>
                        <a class="nav-link" data-bs-toggle="tab" href="#yearly_graph">Yearly</a>
                    </nav>
                </div>
                
                <div class="tab-content chart-container">
                    <div class="tab-pane fade show active" id="daily_graph">
                        <canvas id="salesChart" height="220"></canvas>
                    </div>
                    <div class="tab-pane fade" id="monthly_graph">
                        <canvas id="salesmonthChart" height="220"></canvas>
                    </div>
                    <div class="tab-pane fade" id="yearly_graph">
                        <canvas id="salesYearChart" height="220"></canvas>
                    </div>
                    <div class="d-flex justify-content-center gap-4 mt-3 small text-muted fw-medium">
                        <span><i class="bi bi-square-fill text-primary me-1"></i> Revenue Generated</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card h-100 overflow-hidden">
                <div class="p-4 border-bottom bg-light bg-opacity-25 d-flex justify-content-between">
                    <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Top Seling Products</h6>
                    <i class="bi bi-filter-right"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-uppercase text-muted">
                                <th class="ps-4">#</th>
                                <th>Crop</th>
                                <th class="text-end pe-4">Total</th>
                            </tr>
                        </thead>
                        <tbody id="mostPlantedCropTable">
                            <tr><td colspan="3" class="text-center py-5 text-muted">Syncing metrics...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="glass-card h-100">
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                    <span class="fw-bold small text-uppercase"><i class="bi bi-envelope-paper me-2 text-primary"></i>Orders</span>
                    <span class="badge bg-danger rounded-pill">Alerts</span>
                </div>
                <div class="list-group list-group-flush" id="orderNotification"></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="glass-card h-100">
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                    <span class="fw-bold small text-uppercase"><i class="bi bi-box-seam me-2 text-success"></i>Inventory</span>
                    <span class="badge bg-warning text-dark rounded-pill">Low Stock</span>
                </div>
                <div class="list-group list-group-flush" id="notificationList"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="glass-card h-100 p-4">
                <h6 class="fw-bold mb-4">Stock Distribution Analysis</h6>
                <canvas id="salesChart2" height="180"></canvas>
            </div>
        </div>
    </div>

</div>

<?php
}
ob_end_flush();
include_once "layout/layout_foot.php";
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function getLocation() {

    // 👉 Show loading popup
    Swal.fire({
        title: 'Saving farm details...',
        text: 'Please wait while we save your farm details...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {

            document.getElementById("latitude").value = pos.coords.latitude;
            document.getElementById("longitude").value = pos.coords.longitude;


            // 👉 Submit form
            setTimeout(() => {
                document.getElementById("farmForm").submit();
            }, 500);

        }, function(err) {
            Swal.fire({
                icon: 'error',
                title: 'Location Error',
                text: err.message
            });
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Not Supported',
            text: 'Geolocation is not supported by your browser.'
        });
    }
}
</script>