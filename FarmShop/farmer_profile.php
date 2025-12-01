<?php 
$farmer_shop_id = isset($_GET['fid']) ? $_GET['fid'] : die('ERROR: missing ID.');
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/farm.php";
include_once "../objects/product.php";

$page_title = "HarvestHUB";
include_once "layout_head.php";

$require_login=true;
include_once "../login_checker.php";

// initialize the database connection
$database = new Database();
$db = $database->getConnection();

// initialize the classes object
$farm_shop = new Farm($db);
$farm_product = new Product($db);


// get the farm info
$farm_shop->user_id = $farmer_shop_id;
$farm_shop->getFarmInfo();


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

// get the farmers products
$farm_product->user_id = $farm_shop->user_id;
$show_farm_product = $farm_product->getFarmProduct();
$num = $show_farm_product->rowCount();



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
                        <strong>Joined:</strong> <?php echo $joined_duration;?>
                    </div>

                </div>
            </div>

        </div>

    </div>

   <!-- Navigation Tabs -->
<ul class="nav nav-tabs mt-4" id="products" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#allproduct">All Products</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#harvestproducts">Harvest Products</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#preorderproducts">Pre-Order Products</a>
    </li>
</ul>

<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="allproduct">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
                if ($num>0) {
                    while ($row=$show_farm_product->fetch(PDO::FETCH_ASSOC)) {
                        extract($row); ?>
                        
                        <div class="col product-item mb-4" data-type="<?= $product_type ?>">
                            <div class="card product-card h-100 shadow-sm">
                                
                                <!-- Image with Pre-Order badge if needed -->
                                <div class="position-relative">
                                    <?php
                                    $path = "../user/uploads/{$user_id}/products/{$product_image}";
                                    $crops_path = "../user/uploads/{$user_id}/posted_crops/{$product_image}";
                                    $default = "../libs/images/logo.png";

                                    if (!empty($product_image) && file_exists($path)) {
                                        $image = $path;
                                    } elseif (!empty($product_image) && file_exists($crops_path)) {
                                        $image = $crops_path;
                                    } else {
                                        $image = $default;
                                    }
                                    ?>
                                    
                                    <img src="<?= $image ?>" 
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($product_name) ?>" 
                                        style="object-fit: cover; height: 180px;">

                                    <?php 
                                        $discount = ($row['discount'] * 100) * 100;
                                        if (!empty($row['discount'])): 
                                    ?>
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                            <?= $discount ?>% OFF
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($product_type != "harvest") : ?>
                                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">Pre-Order</span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-truncate"><?= htmlspecialchars($product_name) ?></h5>
                                    <p class="card-text text-success fw-bold">₱ <?= number_format($price_per_unit, 2) ?> per KG</p>
                                    <p class="small text-muted mb-1">Available: <?= number_format($row['total_stocks']); ?> KG</p>

                                    <?php if (empty($_SESSION['logged_in'])): ?>
                                        <a href="<?= $home_url ?>signin.php?action=add_to_cart" class="btn btn-info w-100 mt-auto">
                                            Sign in to Order
                                        </a>
                                    <?php else: ?>
                                        <?php if ($product_type == "harvest"): ?>
                                            <a class="btn btn-success w-100 mt-auto" href="<?= $home_url ?>product/product_detail.php?pid=<?= $product_id ?>&page=1">
                                                Add to Cart
                                            </a>
                                        <?php else: ?>
                                            <a class="btn btn-warning w-100 mt-2 mt-auto" href="<?= $home_url ?>product/preorder.php?pid=<?= $product_id ?>&page=1">
                                                Pre-Order
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>

    <div class="tab-pane fade" id="harvestproducts">
        <p>On Sale items.</p>
    </div>

    <div class="tab-pane fade" id="preorderproducts">
        <p>New Arrival content.</p>
    </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include_once "layout_foot.php"; ?>
