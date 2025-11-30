<?php 
$farmer_shop_id = isset($_GET['fid']) ? $_GET['fid'] : die('ERROR: missing ID.');
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/farm.php";

$database = new Database();
$db = $database->getConnection();

$farm_shop = new Farm($db);

$farm_shop->user_id = $farmer_shop_id;
$farm_shop->getFarmInfo();

$page_title = "HarvestHUB";
include_once "layout_head.php";

$require_login=true;
include_once "../login_checker.php";

$page_title = "Profile";
include_once "layout_head.php";

//get the details of farmer page

$raw_image = $farm_shop->farm_image;
$farmer_id = $farm_shop->user_id;
$logo_path = "{$base_url}user/uploads/{$farmer_id}/farm_logo/{$raw_image}";
$default_logo = "{$base_url}user/uploads/logo.png";

if (empty($raw_image) || !file_exists($img_path)) {
    $logo = $default_logo;
} else {
    $logo = $logo_path;
}

$created = new DateTime($farm_shop->created_at);
$now = new DateTime();

$diff = $now->diff($created);

$years = $diff->y;
$months = $diff->m;

$joined_duration = ($years > 0) 
    ? $years . " Year" . ($years > 1 ? "s" : "") . " " .
      $months . " Month" . ($months > 1 ? "s" : "")
    : $months . " Month" . ($months > 1 ? "s" : "");


//convert the follower count
$farm_shop->follower_count;

// Format it directly
if ($farm_shop->follower_count >= 1000000000) {
    $farm_shop->follower_count = round($farm_shop->follower_count / 1000000000, 1) . 'B';
} elseif ($farm_shop->follower_count >= 1000000) {
    $farm_shop->follower_count = round($farm_shop->follower_count / 1000000, 1) . 'M';
} elseif ($farm_shop->follower_count >= 1000) {
    $farm_shop->follower_count = round($farm_shop->follower_count / 1000, 1) . 'K';
}


?>

<!-- Seller Profile Wrapper -->
<div class="container my-5">
  <?php include_once "../layout/navigation.php" ; ?>
    <div class="card shadow-sm p-3 border-0">

        <!-- TOP ROW -->
        <div class="row align-items-center">
            <!-- Avatar + Name + Buttons -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <!-- Avatar -->
                        <div class="me-3 position-relative">
                            <img src="<?php echo $logo; ?>"
                                class="rounded-circle"
                                style="width:85px;height:85px;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.3);">
                        </div>
                        <div>
                            <h4 class="mb-0"><?php echo $farm_shop->farm_name; ?></h4>
                            <div class=" small">Active 49 minutes ago</div>

                            <!-- Preferred Badge -->
                            <span class="badge bg-danger mt-2">Preferred</span>
                        </div>
                    </div>
                        <div class="d-flex mt-3">
                            <button class="btn btn-outline-dark flex-grow-1 mb-3 m-3">
                                <i class="bi bi-plus me-1"></i> Follow
                            </button>

                            <button class="btn btn-outline-dark flex-grow-1 mb-3 m-3">
                                <i class="bi bi-chat-dots me-1"></i> Chat
                            </button>
                        </div>
                </div>
            </div>

            <!-- RIGHT SIDE STATS -->
            <div class="col-md-6">
                <div class="row text-md-end mt-3 mt-md-0">

                    <div class="col-6 col-md-4 mb-2">
                        <strong>Products:</strong> 592
                    </div>

                    <div class="col-6 col-md-4 mb-2">
                        <strong>Followers:</strong> <?php echo $farm_shop->follower_count;?>
                    </div>

                    <div class="col-6 col-md-4 mb-2">
                        <strong>Following:</strong> <?php echo $farm_shop->following_count;?>
                    </div>

                    <div class="col-6 col-md-4 mb-2">
                        <strong>Rating:</strong> 4.8 (434.8K)
                    </div>

                    <div class="col-6 col-md-4 mb-2">
                        <strong>Chat Performance:</strong> 100%
                    </div>

                    <div class="col-6 col-md-4 mb-2">
                        <strong>Joined:</strong> 6 Years Ago
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mt-4" id="myTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" >Home</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab">All Products</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" >On Sale</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab">New Arrival</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="homeTab">
            <p>This is the Home tab content.</p>
        </div>
        <div class="tab-pane fade" id="allTab">
            <p>All Products content.</p>
        </div>
        <div class="tab-pane fade" id="saleTab">
            <p>On Sale items.</p>
        </div>
        <div class="tab-pane fade" id="newTab">
            <p>New Arrival content.</p>
        </div>
    </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include_once "layout_foot.php"; ?>
