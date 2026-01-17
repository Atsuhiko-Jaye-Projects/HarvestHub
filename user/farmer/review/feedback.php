<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/product.php";

$page_title = "Product Feedback";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product->user_id = $_SESSION['user_id'];

$page_url = "{$home_url}user/farmer/review/feedback.php?";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 6;
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $product->getProductStats($from_record_num, $records_per_page);
$num  = $stmt->rowCount();
$total_rows = $product->countAll();

include_once "../statistics/stats.php";
?>

<div class="container mt-3">

    <div class="p-3 bg-light rounded mb-3">
        <h5 class="mb-0">
            <i class="bi bi-chat-dots text-success"></i> My Product Feedback
        </h5>
        <small class="text-muted">View customer reviews for each product</small>
    </div>

    <?php if ($num > 0) { ?>
        <div class="row g-3">
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
            ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        
                        <div class="card-body">

                        
                            <div class="d-flex align-items-start gap-3">    
                                <?php

                                    $raw_image = $row['product_image'];
                                    $image_path = "";

                                    if ($row['product_type'] == 'preorder') {
                                       $image_path = "{$base_url}user/uploads/{$user_id}/posted_crops/{$raw_image}";
                                    }else{
                                        $image_path = "{$base_url}user/uploads/{$user_id}/products/{$raw_image}";
                                    }
                                
                                ?>

                                <!-- Product Image -->
                                <img
                                    src="<?= $image_path ?>"
                                    alt="Product Image"
                                    class="rounded"
                                    style="width: 80px; height: 80px; object-fit: cover;"
                                >

                                <!-- Product Details -->
                                <div>
                                    <h6 class="card-title fw-bold mb-1">
                                        <?= ucwords(strtolower(htmlspecialchars($product_name))) ?>
                                    </h6>

                                    <p class="mb-1 text-muted small">
                                        <?= htmlspecialchars($category) ?>
                                    </p>

                                    <div class="small text-muted">

                                        <!-- Average Rating -->
                                        <div>
                                            ⭐ <strong><?= number_format($avg_rating, 1) ?></strong> / 5
                                        </div>

                                        <!-- Total Reviews -->
                                        <div>
                                            💬 <?= $total_reviews ?> Reviews
                                            
                                        </div>

                                        <div>
                                            🕒 Last review:
                                            <?= date("M d, Y", strtotime($last_review_date)) ?>
                                        </div>
                                        <!-- Unreplied Reviews -->
                                        <?php if ($recent_reviews_today > 0) { ?>
                                            <div class="text-danger fw-semibold">
                                                <span class="badge rounded-pill bg-success m-2">
                                                    <?= $recent_reviews_today ?> New Review
                                                </span>
                                            </div>
                                        <?php } else { ?>
                                            <div class="text-success">
                                                ✔ All replied
                                            </div>
                                        <?php } ?>

                                        <!-- Latest Review -->


                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="card-footer bg-white border-0">
                            <a href="<?= $base_url ?>user/farmer/review/review.php?pid=<?= $product_id ?>"
                               class="btn btn-outline-success w-100">
                                <i class="bi bi-eye"></i> View Reviews
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="mt-4">
            <?php include_once "../paging.php"; ?>
        </div>

    <?php } else { ?>
        <div class="alert alert-warning text-center">
            <i class="bi bi-info-circle"></i> No products found. Add products to receive feedback.
        </div>
    <?php } ?>

</div>

<?php include_once "../layout/layout_foot.php"; ?>
