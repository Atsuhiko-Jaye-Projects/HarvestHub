<?php
ob_start();
$order_id = isset($_GET['vod']) ? $_GET['vod'] : die('ERROR: missing ID.');

include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/product.php";
include_once "../../../objects/review.php";
include_once "../../../objects/review_upload.php";
include_once "../../../objects/seller_review.php";

$page_title = "Feedback Form";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$review = new Review($db);
$review_upload = new ReviewUpload($db);
$seller_review = new SellerReview($db);

$order->id = $order_id;
$order->orderReviewStatus();

$productid = $order->product_id;
$farmerid = $order->farmer_id;

// --- POST LOGIC REMAINS THE SAME BUT CLEANED ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == "product_review") {
        $review->rating      = (int) $_POST['rating'];
        $review->product_id  = (int) $_POST['product_id'];
        $review->farmer_id   = (int) $_POST['farmer_id'];
        $review->customer_id = (int) $_POST['customer_id'];
        $review->review_text = trim($_POST['feedback']);

        if ($review->createReview()) {
            if (isset($_FILES['review_image']) && !empty($_FILES['review_image']['name'][0])) {
                $result = $review_upload->uploadPhoto($_FILES['review_image'], $farmerid, $productid, $_SESSION['user_id']);
                if ($result['success']) {
                    foreach ($result['files'] as $filename) {
                        $review_upload->customer_id = $_SESSION['user_id'];
                        $review_upload->farmer_id   = $farmerid;
                        $review_upload->product_id  = $productid;
                        $review_upload->image       = $filename;
                        $review_upload->saveReviewImages();
                    }
                }
            }
            $order->id = $order_id;
            $order->review_status = 1;
            $order->markReviewStatus();
            header("Location: feedback.php?vod={$order_id}&success");
            exit;
        }
    }

    if ($_POST['action'] == "seller_review") {
        $review_tags = isset($_POST['tags']) ? json_decode($_POST['tags'], true) : [];
        $seller_review->farmer_id = $_POST['farmer_id'];
        $seller_review->product_id = $_POST['product_id'];
        $seller_review->customer_id = $_POST['customer_id'];
        $seller_review->order_id = $_POST['order_id'];
        $seller_review->rating = $_POST['seller_rating'];
        $seller_review->review_text = $_POST['feedback'];
        $seller_review->message_rating = $_POST['message_rating'];
        $seller_review->review_tags = json_encode($review_tags);
        
        if ($seller_review->createSellerReview()) {
            $order->id = $order_id;
            $order->farmer_rated = 1;
            $order->markFarmReviewStatus();
            header("Location: feedback.php?vod={$order_id}&success");
            exit;
        }
    }
}
?>

<style>
    :root { --harvest-green: #10b981; --bg-soft: #f8fafc; }
    body { background-color: var(--bg-soft); font-family: 'Inter', sans-serif; }
    
    .feedback-card { border: none; border-radius: 20px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    
    /* Stars UI */
    .stars { display: flex; flex-direction: row-reverse; justify-content: center; gap: 8px; }
    .star-input { display: none; }
    .star { font-size: 2.5rem; color: #e2e8f0; cursor: pointer; transition: 0.2s; }
    .star:hover, .star:hover ~ .star { color: #fbbf24; }
    .star-input:checked + label, .star-input:checked + label ~ label { color: #fbbf24; }

    /* Upload UI */
    .upload-grid { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
    .upload-box { 
        width: 80px; height: 80px; border: 2px dashed #cbd5e1; border-radius: 15px; 
        display: flex; align-items: center; justify-content: center; cursor: pointer; 
        overflow: hidden; position: relative; transition: 0.3s;
    }
    .upload-box:hover { border-color: var(--harvest-green); background: #f0fdf4; }
    .upload-box img { width: 100%; height: 100%; object-fit: cover; }
    .upload-box span { font-size: 1.5rem; color: #94a3b8; }

    /* Tags UI */
    .tagBtn { border-radius: 50px; font-weight: 600; padding: 6px 16px; transition: 0.3s; }
    .btn-secondary { background-color: var(--harvest-green) !important; border-color: var(--harvest-green) !important; }

    .btn-submit { background: var(--harvest-green); border: none; border-radius: 12px; font-weight: 700; padding: 12px 30px; }
    .btn-submit:hover { background: #059669; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <?php if ($order->review_status == 0): ?>
                <div class="card feedback-card shadow-lg p-3">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h4 class="fw-800">Rate the Product</h4>
                            <p class="text-muted small">Your feedback helps local farmers grow!</p>
                        </div>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?vod={$order_id}");?>" method="POST" id="productFeedbackForm" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?php echo $productid; ?>">
                            <input type="hidden" name="farmer_id" value="<?php echo $farmerid; ?>">
                            <input type="hidden" name="customer_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                            <input type="hidden" name="action" value="product_review">

                            <div class="mb-4 text-center">
                                <label class="form-label d-block fw-bold small text-uppercase">Quality Rating</label>
                                <div class="stars">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" class="star-input" required>
                                        <label for="star<?= $i ?>" class="star">&#9733;</label>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase">Comment</label>
                                <textarea class="form-control border-0 bg-light rounded-4 p-3" name="feedback" rows="4" placeholder="How was the product? Fresh ba?" required></textarea>
                            </div>

                            <div class="mb-4 text-center">
                                <label class="form-label d-block fw-bold small text-uppercase">Add Photos (Max 5)</label>
                                <div class="upload-grid">
                                    <input type="file" id="imageInput" name="review_image[]" accept="image/*" multiple hidden>
                                    <?php for($i=0; $i<5; $i++): ?>
                                        <div class="upload-box" onclick="document.getElementById('imageInput').click()">
                                            <span id="icon-<?= $i ?>">+</span>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-submit btn-primary w-100 shadow-sm">Submit Review</button>
                        </form>
                    </div>
                </div>

            <?php elseif($order->farmer_rated == 0): ?>
                <div class="card feedback-card shadow-lg p-3" style="border-top: 5px solid var(--harvest-green);">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h4 class="fw-800">Rate the Seller</h4>
                            <p class="text-muted small">How was your interaction with the farmer?</p>
                        </div>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?vod={$order_id}"); ?>" method="POST" id="sellerFeedbackForm">
                            <input type="hidden" name="product_id" value="<?php echo $productid; ?>">
                            <input type="hidden" name="farmer_id" value="<?php echo $farmerid; ?>">
                            <input type="hidden" name="customer_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <input type="hidden" name="action" value="seller_review">

                            <div class="mb-4">
                                <label class="form-label d-block fw-bold small text-uppercase text-center">Service Rating</label>
                                <div class="stars">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="seller_star<?= $i ?>" name="seller_rating" value="<?= $i ?>" class="star-input" required>
                                        <label for="seller_star<?= $i ?>" class="star">&#9733;</label>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label d-block fw-bold small text-uppercase text-center">Communication</label>
                                <div class="stars">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="msg_star<?= $i ?>" name="message_rating" value="<?= $i ?>" class="star-input" required>
                                        <label for="msg_star<?= $i ?>" class="star">&#9733;</label>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase">Quick Feedback</label>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Fast Response</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Polite</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Helpful</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Accurate Price</button>
                                </div>
                                <input type="hidden" name="tags" id="tags">
                            </div>

                            <textarea class="form-control border-0 bg-light rounded-4 p-3 mb-4" name="feedback" rows="3" placeholder="Any additional message for the farmer?" required></textarea>

                            <button type="submit" class="btn btn-submit btn-success w-100 shadow-sm">Submit Seller Feedback</button>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <div class="card feedback-card shadow-lg text-center p-5">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold">Feedback Submitted!</h4>
                    <p class="text-muted">Maraming salamat sa pagtangkilik sa ating lokal na magsasaka.</p>
                    <a href="order.php" class="btn btn-outline-success rounded-pill px-4 mt-3">Go Back to My Orders</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// --- MULTI-PHOTO UPLOAD LOGIC ---
const input = document.getElementById("imageInput");
const boxes = document.querySelectorAll(".upload-box");
let selectedFiles = [];

if(input) {
    input.addEventListener("change", () => {
        const files = Array.from(input.files);
        files.forEach(file => {
            if (selectedFiles.length < 5) selectedFiles.push(file);
        });
        updatePreviews();
    });
}

function updatePreviews() {
    boxes.forEach((box, i) => {
        box.innerHTML = "<span>+</span>";
        if (selectedFiles[i]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                box.innerHTML = `<img src="${e.target.result}">`;
            };
            reader.readAsDataURL(selectedFiles[i]);
        }
    });
    // Sync to input
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(f => dataTransfer.items.add(f));
    input.files = dataTransfer.files;
}

// --- TAGS SELECTION ---
const tagBtns = document.querySelectorAll(".tagBtn");
const tagsInput = document.getElementById("tags");
tagBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        btn.classList.toggle("btn-outline-secondary");
        btn.classList.toggle("btn-secondary");
        const selected = Array.from(tagBtns)
            .filter(b => b.classList.contains("btn-secondary"))
            .map(b => b.textContent.trim());
        if(tagsInput) tagsInput.value = JSON.stringify(selected);
    });
});

// --- SUCCESS/FAIL ALERTS ---
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    if(params.has('success')) {
        Swal.fire({ title: 'Submitted!', text: 'Salamat sa iyong feedback.', icon: 'success', confirmButtonColor: '#10b981' });
    }
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>