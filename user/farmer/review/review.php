<?php
$product_id = isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: Missing ID');

include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/review.php";
include_once "../../../objects/review_upload.php";

$database = new Database();
$db = $database->getConnection();

$review = new Review($db);
$reviewImages = new ReviewUpload($db);

$page_title = "Product Reviews";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$review->product_id = $product_id;
$review->user_id = $_SESSION['user_id'];

$stmt = $review->getProductReview();
$num  = $stmt->rowCount();

include_once "../statistics/stats.php";
?>

<div class="container mt-3">

    <div class="p-3 bg-light rounded mb-3">
        <h5 class="mb-0">
            <i class="bi bi-star-fill text-warning"></i> Customer Reviews
        </h5>
        <small class="text-muted">See feedback and reply to your customers</small>
    </div>

    <?php if ($num > 0) { ?>
        <div class="row g-3">
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $reviewImages->customer_id = $row['customer_id'];
                $image_stmt = $reviewImages->getReviewImages();
                $image_num = $image_stmt->rowCount();
            ?>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>
                                    <i class="bi bi-person-circle"></i>
                                    Customer #<?= htmlspecialchars($customer_id) ?>
                                </strong>
                                <small class="text-muted">
                                    <?= date("M d, Y", strtotime($created_at)) ?>
                                </small>
                            </div>

                            <!-- Rating -->
                            <div class="mb-2">
                                <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $rating
                                            ? "<i class='bi bi-star-fill text-warning'></i>"
                                            : "<i class='bi bi-star text-muted'></i>";
                                    }
                                ?>
                            </div>

                            <!-- Images -->
                            <?php
                                if ($image_num > 0) {
                                    echo "<div class='d-inline-flex gap-2 flex-wrap'>";
                                    while ($img_row = $image_stmt->fetch(PDO::FETCH_ASSOC)) {

                                        $review_image = $img_row['image'];
                                        $review_img_owner = $img_row['customer_id'];
                                        $review_img_farmer = $img_row['farmer_id'];
                                        $review_img_product = $img_row['product_id'];

                                        $review_image_path = "{$base_url}user/uploads/reviews/{$review_img_farmer}/review_images/{$review_img_product}/{$review_img_owner}/{$review_image}";

                                        echo "
                                        <div class='media-card position-relative'
                                             data-bs-toggle='modal'
                                             data-bs-target='#imageModal'
                                             data-img='{$review_image_path}'>
                                             
                                            <img src='{$review_image_path}' loading='lazy'>
                                            <div class='media-label'>Review<br>photo</div>
                                        </div>";
                                    }
                                    echo "</div>";
                                }
                            ?>

                            <!-- Review -->
                            <p class="mb-3">
                                <?= nl2br(htmlspecialchars($review_text)) ?>
                            </p>

                            <!-- Reply -->
                            <div class="border-top pt-3">
                                <form method="post" action="">
                                    <label class="form-label small text-muted">
                                        Your Reply
                                    </label>
                                    <textarea
                                        name="reply"
                                        class="form-control mb-2"
                                        rows="2"
                                        placeholder="Thank the customer or address their concern..."
                                    ><?= htmlspecialchars($reply) ?></textarea>

                                    <input type="hidden" name="review_id" value="<?= $id ?>">

                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-send"></i> Send Reply
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning text-center mt-3">
            <i class="bi bi-info-circle"></i> No reviews yet for this product.
        </div>
    <?php } ?>
</div>


<?php include_once "../layout/layout_head.php"; ?>

<div class="modal fade" id="imageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0 text-center">
        <img id="modalImage" class="img-fluid rounded">
      </div>
    </div>
  </div>
</div>


<script>
const imageModal = document.getElementById('imageModal');
const modalImage = document.getElementById('modalImage');

imageModal.addEventListener('show.bs.modal', function (event) {
  const trigger = event.relatedTarget;
  modalImage.src = trigger.getAttribute('data-img');
});

imageModal.addEventListener('hidden.bs.modal', function () {
  modalImage.src = '';
});
</script>

