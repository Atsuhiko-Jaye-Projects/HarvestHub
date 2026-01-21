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

// DB connection
$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$review = new Review($db);
$review_upload = new ReviewUpload($db);
$seller_review = new SellerReview($db);

// Get order info
$order->id = $order_id;
$order->orderReviewStatus();

$productid = $order->product_id;
$farmerid = $order->farmer_id;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {


    // 1️⃣ Save the review first
    if ($_POST['action'] == "product_review") {
        $review->rating      = (int) $_POST['rating'];
        $review->product_id  = (int) $_POST['product_id'];
        $review->farmer_id   = (int) $_POST['farmer_id'];
        $review->customer_id = (int) $_POST['customer_id'];
        $review->review_text = trim($_POST['feedback']);

        if ($review->createReview()) {

            // bind the values to insert method
            $farmerid = $_POST['farmer_id'];
            $product_id = $_POST['product_id'];
            $customer_id = $_POST['customer_id'];

                if (!isset($_FILES['review_image'])) {
                    die('No images uploaded');
                }

                // Upload images
                $result = $review_upload->uploadPhoto($_FILES['review_image'], $farmerid, $product_id, $customer_id);

                if (!$result['success']) {
                    die($result['error']);
                }

                // Save each image to DB
                foreach ($result['files'] as $filename) {

                    $review_upload->customer_id = $_POST['customer_id'];
                    $review_upload->farmer_id   = $_POST['farmer_id'];
                    $review_upload->product_id  = $_POST['product_id'];

                    // ✅ Correct image path or filename
                    $review_upload->image = $filename;

                    $review_upload->saveReviewImages();
                }


            // 2️⃣ Mark order as reviewed
            $order->id = $order_id;
            $order->review_status = 1;
            $order->markReviewStatus();

            header("Location: {$base_url}user/consumer/order/feedback.php?vod={$order_id}&success");
            exit;

        } else {
            header("Location: {$base_url}user/consumer/order/feedback.php?vod={$order_id}&failed");
            exit;
        }
    }

    if ($_POST['action'] == "seller_review") {
        
        $review_tags = json_decode($_POST['tags'], true);

        $seller_review->farmer_id = $_POST['farmer_id'];
        $seller_review->product_id = $_POST['product_id'];
        $seller_review->customer_id = $_POST['customer_id'];
        $seller_review->order_id = $_POST['order_id'];
        $seller_review->rating = $_POST['seller_rating'];
        $seller_review->review_text= $_POST['feedback'];
        $seller_review->message_rating = $_POST['message_rating'];
        $seller_review->review_tags = json_encode($review_tags);
        
        if ($seller_review->createSellerReview()) {
            $order->id = $order_id;
            $order->farmer_rated = 1;
            $order->markFarmReviewStatus();
            header("Location: {$base_url}user/consumer/order/feedback.php?vod={$order_id}&success");
            exit;
        }
    }
}

?>

<?php if ($order->review_status == 0): ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 text-center">We'd Love Your Feedback!</h5>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?vod={$order_id}");?>" method="POST" id="feedbackForm" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="<?php echo $productid; ?>">
                        <input type="hidden" name="farmer_id" value="<?php echo $farmerid; ?>">
                        <input type="hidden" name="customer_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                        <input type="hidden" name="action" value="product_review">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label">How would you rate your experience?</label>
                            <div class="stars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" class="star-input">
                                    <label for="star<?= $i ?>" class="star">&#9733;</label>
                                <?php endfor; ?>
                            </div>
                            <div class="invalid-feedback d-block" id="ratingError"></div>
                        </div>

                        <!-- Feedback -->
                        <div class="mb-4">
                            <label class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="5" placeholder="Tell us what you think..." required></textarea>
                            <div class="invalid-feedback d-block" id="feedbackError"></div>
                        </div>

                        <!-- Upload Images -->
                        <div class="mb-4">
                            <div class="upload-grid">
                                <input type="file" id="imageInput" name="review_image[]" accept="image/*" multiple hidden>
                                <?php for($i=0; $i<5; $i++): ?>
                                    <div class="upload-box" onclick="openPicker(<?= $i ?>)"><span>+</span></div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2">Submit Feedback</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php elseif($order->farmer_rated == 0): ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Seller Feedback Card (Color-coded) -->
            <div class="card shadow-sm border-light" style="border-left: 6px solid #198754;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 text-center">
                        Seller Feedback 
                    </h5>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?vod={$order_id}"); ?>" method="POST" id="feedbackForm">
                        <input type="hidden" name="product_id" value="<?php echo $productid; ?>">
                        <input type="hidden" name="farmer_id" value="<?php echo $farmerid; ?>">
                        <input type="hidden" name="customer_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <input type="hidden" name="action" value="seller_review">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label">Rate your experience with the seller</label>

                            <div class="stars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input 
                                        type="radio"
                                        id="seller_star<?= $i ?>"
                                        name="seller_rating"
                                        value="<?= $i ?>"
                                        class="star-input"
                                    >
                                    <label for="seller_star<?= $i ?>" class="star">&#9733;</label>
                                <?php endfor; ?>
                            </div>

                            <div class="invalid-feedback d-block" id="ratingError"></div>
                        </div>


                        <!-- Messaging Rating -->
                        <div class="mb-4">
                            <label class="form-label">Messaging / Communication</label>
                            <div class="stars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input
                                        type="radio"
                                        id="message_star<?= $i ?>"
                                        name="message_rating"
                                        value="<?= $i ?>"
                                        class="star-input"
                                    >
                                    <label for="message_star<?= $i ?>" class="star">&#9733;</label>
                                <?php endfor; ?>
                            </div>
                        </div>


                        <!-- Quick Review Tags -->
                        <div class="mb-4">
                            <label class="form-label">What stood out?</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Fast Response</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Fresh Products</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Good Packaging</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm tagBtn">Friendly Seller</button>
                            </div>
                            <input type="hidden" name="tags" id="tags">
                        </div>

                        <!-- Feedback -->
                        <div class="mb-4">
                            <label class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="5" placeholder="Tell us what you think..." required></textarea>
                            <div class="invalid-feedback d-block" id="feedbackError"></div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-lg px-4 py-2">
                                Submit Feedback
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JS for tags -->
<script>
    const tagButtons = document.querySelectorAll(".tagBtn");
    const tagsInput = document.getElementById("tags");

    tagButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            btn.classList.toggle("btn-outline-secondary");
            btn.classList.toggle("btn-secondary");

            const selected = Array.from(tagButtons)
                .filter(b => b.classList.contains("btn-secondary"))
                .map(b => b.textContent.trim());

            tagsInput.value = JSON.stringify(selected);
        });
    });
</script>



<?php else: ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-light text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-emoji-smile-fill text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3">You Already Rated This Product</h5>
                    <p class="text-muted mb-4"><i class="bi bi-info-circle"></i> Thank you for your feedback!</p>
                    <div class="d-flex justify-content-center">
                        <a href="order.php" class="btn btn-primary btn-lg px-4 py-2">
                            <i class="bi bi-arrow-left-circle me-2"></i> Return
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
.stars { display: flex; flex-direction: row-reverse; justify-content: center; gap: 10px; }
.star-input { display: none; }
.star { font-size: 2rem; color: #e0e0e0; cursor: pointer; transition: color 0.2s; }
.star:hover, .star:hover ~ .star { color: #ffbf00; }
.star-input:checked + label, .star-input:checked + label ~ label { color: #ffbf00; }
.upload-grid { display: flex; gap: 10px; }
.upload-box { width: 60px; height: 60px; border: 2px dashed #ccc; display: flex; align-items: center; justify-content: center; cursor: pointer; }
.upload-box.filled { border: 2px solid #007bff; }
.upload-box img { max-width: 100%; max-height: 100%; }
</style>

<script>
let selectedFiles = [];
const input = document.getElementById("imageInput");
const boxes = document.querySelectorAll(".upload-box");
const MAX_FILES = 5;

// Open picker
function openPicker() {
    if (selectedFiles.length >= MAX_FILES) return;
    input.click();
}

// Handle file selection
input.addEventListener("change", () => {
    for (const file of input.files) {

        if (!file.type.startsWith("image/")) {
            alert("Only images allowed");
            continue;
        }

        if (selectedFiles.length < MAX_FILES) {
            selectedFiles.push(file);
        }
    }

    updateBoxes();
    syncInputFiles();
});

// Update previews
function updateBoxes() {
    boxes.forEach((box, index) => {
        box.innerHTML = "<span>+</span>";
        box.classList.remove("filled");

        if (selectedFiles[index]) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(selectedFiles[index]);
            box.innerHTML = "";
            box.appendChild(img);
            box.classList.add("filled");
        }
    });
}

// Sync files back to input (THIS IS CRITICAL)
function syncInputFiles() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
}

// Prevent empty submit
document.getElementById("feedbackForm").addEventListener("submit", function (e) {
    if (input.files.length === 0) {
        e.preventDefault();
        alert("Please select at least one image");
    }
});
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const oid = "<?php echo $order_id; ?>";
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        Swal.fire({ imageUrl: '../../../libs/images/rate.png', title: 'Thank you!', text: 'Your feedback has been submitted.', imageWidth: 80, imageHeight: 80, confirmButtonColor: '#3085d6', confirmButtonText: 'Okay' });
        window.history.replaceState({}, document.title, `feedback.php?vod=${oid}`);
    }
    if (urlParams.has('failed')) {
        Swal.fire({ icon: 'error', title: 'Oh Snap!', text: 'Something went wrong, Please try again later.', confirmButtonColor: '#3085d6', confirmButtonText: 'Okay' });
        window.history.replaceState({}, document.title, `feedback.php?vod=${oid}`);
    }
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>
