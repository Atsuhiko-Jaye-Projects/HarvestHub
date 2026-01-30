<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/farm.php";
include_once "../../../objects/order.php";
include_once "../../../objects/seasonal_crop_log.php";


$database = new Database();
$db = $database->getConnection();

$farm = new Farm($db);
$order = new Order($db);
$seasonal_crop_log = new SeasonalCropLog($db);

$page_title = "Index";
$require_login = true;
include_once "../../../login_checker.php";
include_once "../layout/layout_head.php";

$farm->user_id = $_SESSION['user_id'];
$farm->getFarmerLocation();

// get the farmer location
$location = $farm->baranggay . ', ' . $farm->municipality . ', ' . $farm->province;

$user_cache_dir = __DIR__ . '/cache/' . $_SESSION['user_id'] . '/forecast/' ;
if (!is_dir($user_cache_dir)) {
    mkdir($user_cache_dir);
}
$cache_file = $user_cache_dir . '_weather_' . md5($location) . '.json';
$cache_time = 12400;

$today = date('Y-m-d');
$start = date('Y-m-d', strtotime('-15 days'));
$end = date('Y-m-d', strtotime('+15 days'));

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    // Use cached data
    $weather = json_decode(file_get_contents($cache_file), true);
} else {
    // Call Visual Crossing 
    $today = date('Y-m-d');
    $start = date('Y-m-d', strtotime('-15 days'));
    $end = date('Y-m-d', strtotime('+15 days'));

    //$apiKey = 'S5P837UKDVDE8B2BJ93SSW8KT';
    $apiKey = 'VTZE7BHR7XAT9XD3GGS4VL3HU';
    $url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/" . urlencode($location) . "/{$start}/{$end}?unitGroup=metric&key={$apiKey}";

    $response = file_get_contents($url);
    $weather = json_decode($response, true);

    // Save cache
    file_put_contents($cache_file, json_encode($weather));
}


$past = [];
$future = [];
foreach ($weather['days'] as $day) {
    if ($day['datetime'] < $today) $past[] = $day;
    else $future[] = $day;
}

$totalDays = array_merge($past, $future);
$rainyDays = 0;

foreach ($totalDays as $day) {
    $isRainy = false;
    if (isset($day['precip']) && $day['precip'] >= 1) $isRainy = true;
    elseif (isset($day['precipprob']) && $day['precipprob'] >= 50) $isRainy = true;
    if ($isRainy) $rainyDays++;
}

// Determine season
$season = ($rainyDays / count($totalDays) >= 0.4) ? "Rainy Season" : "Dry Season";

$seasonal_crop_log->current_season = $season;
$SC_stmt = $seasonal_crop_log->getSeasonalCrops();


?>


<div class="container-fluid mt-3">
  <!-- Summary Cards -->
  <div class="row g-3 bg-light p-3 rounded-4">

    <!-- Total Sales -->
    <div class="col-md-4 col-sm-6">
      <div class="card summary-card bg-info text-white h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-semibold text-uppercase small opacity-75">Current Season</h6>
                <h3 class="fw-bold mb-0">
                <?php
                    // Determine icon and color based on season
                    $iconClass = ($season === "Rainy Season") ? "bi-cloud-rain-fill text-primary" : "bi-sun text-warning";
                    echo '<i class="bi '.$iconClass.' me-2"></i> '.$season;
                ?>
                </h3>
                <small class="text-muted">
                <?php echo $rainyDays . " rainy days out of " . count($totalDays); ?>
                </small>
            </div>
            <div class="icon-box bg-white <?php echo ($season === "Rainy Season") ? "text-primary" : "text-warning"; ?>">
                <i class="bi <?php echo ($season === "Rainy Season") ? "bi-cloud-rain-fill" : "bi-sun"; ?> fs-3"></i>
            </div>
            </div>
        <div class="card-footer border-0 bg-transparent text-white-50 small">
        </div>
      </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-md-4 col-sm-6">
      <div class="card summary-card h-100 border-0 bg-white">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fw-semibold text-uppercase small text-muted">Pending Orders</h6>
            <h3 class="fw-bold mb-0 text-dark"><?php ?></h3>
          </div>
          <div class="icon-box bg-warning text-white">
            <i class="bi bi-hourglass-split fs-3"></i>
          </div>
        </div>
        <div class="card-footer border-0 bg-transparent text-success small">
        </div>
      </div>
    </div>

    <!-- Completed Orders -->
    <div class="col-md-4 col-sm-6">
      <div class="card summary-card h-100 border-0 bg-white">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fw-semibold text-uppercase small text-muted">Completed Orders</h6>
            <h3 class="fw-bold mb-0 text-dark"><?php ?></h3>
          </div>
          <div class="icon-box bg-primary text-white">
            <i class="bi bi-check-circle fs-3"></i>
          </div>
        </div>
        <div class="card-footer border-0 bg-transparent text-success small">
        </div>
      </div>
    </div>

  </div>


  <div class="row g-3 bg-light p-3 rounded-4">

    <!-- Total Sales -->
    <div class="col-md-12 col-sm-12">
      <?php //include_once "layout/farm_ratings.php"; ?>
    </div>
    
    <div class="col-md-12 col-sm-12">
      <?php //include_once "layout/daily_log_stats.php"; ?>
    </div>
  </div>


  <!-- Charts -->
<!-- main tab -->
<div class="row mt-4 g-3 bg-light p-3 rounded-4">
  <div class="col-lg-12 col-sm-12">
    <div class="card shadow-sm p-3 h-100 two-d-border">
      
      <!-- main tab header -->
      <h5 class="fw-bold mb-1">Analytics Overview</h5>
      <small class="text-muted">Performance insights across products and sales</small>

      <!-- Nav Tabs -->
      <ul class="nav nav-pills gap-2 mt-4" id="analyticsTabs" role="tablist">

        <li class="nav-item" role="presentation">
          <button class="nav-link active px-4"
                  id="overview-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#daily"
                  type="button"
                  role="tab">
            📊 Overview
          </button>
        </li>

        <li class="nav-item" role="presentation">
          <button class="nav-link px-4"
                  id="products-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#products_tab"
                  type="button"
                  role="tab">
            🌱 Products
          </button>
        </li>

        <li class="nav-item" role="presentation">
          <button class="nav-link px-4"
                  id="sales-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#annually"
                  type="button"
                  role="tab">
            💰 Sales
          </button>
        </li>

      </ul>


      <!-- Tab Content -->
      <div class="tab-content mt-3">
          
        <div class="tab-pane fade show active" id="daily" role="tabpanel">
          <canvas id="salesChart" height="150"></canvas>
        </div>
        <div class="tab-pane fade" id="products_tab" role="tabpanel">
          <div class="row mt-4 g-3 bg-light p-3 rounded-4">
            <?php include_once "analytics/product_analytics.php"; ?>
          </div>
        </div>
        <div class="tab-pane fade" id="annually" role="tabpanel">
          
        </div>

      </div>


    </div>
  </div>
</div>

<?php include_once "../layout/layout_foot.php";