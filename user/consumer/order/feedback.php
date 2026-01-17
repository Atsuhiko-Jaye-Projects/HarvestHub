<?php
ob_start();
$order_id = isset($_GET['vod']) ? $_GET['vod'] : die('ERROR: missing ID.');

include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/product.php";
include_once "../../../objects/review.php";
include_once "../../../objects/review_upload.php";

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

// Get order info
$order->id = $order_id;
$order->orderReviewStatus();

$productid = $order->product_id;
$farmerid = $order->farmer_id;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1️⃣ Save the review first
    $review->rating      = (int) $_POST['rating'];
    $review->product_id  = (int) $_POST['product_id'];
    $review->farmer_id   = (int) $_POST['farmer_id'];
    $review->customer_id = (int) $_POST['customer_id'];
    $review->review_text = trim($_POST['feedback']);

    if ($review->createReview()) {

    $image_array = $_FILES['review_images'];
    $files_count = count($image_array['name']);

    for ($i = 0; $i < $files_count; $i++) {

        $file = [
            'name'     => $image_array['name'][$i],
            'type'     => $image_array['type'][$i],
            'tmp_name' => $image_array['tmp_name'][$i],
            'error'    => $image_array['error'][$i],
            'size'     => $image_array['size'][$i]
        ];

        $upload_result = $review_upload->uploadPhoto($file, $farmerid);

        if ($upload_result['success']) {
            // Save to database
            $review_upload->farmer_id = $_POST['farmer_id'];
            $review_upload->customer_id = $_POST['customer_id'];
            $review_upload->product_id = $_POST['product_id'];
            $review_upload->image = $upload_result['filename'];
            $review_upload->saveReviewImages();

            echo "Uploaded successfully: " . $upload_result['filename'] . "<br>";
        } else {
            // Show the reason for failure
            echo "Upload failed: " . $upload_result['error'] . "<br>";
        }
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
                                <input type="file" id="imageInput" name="review_images[]" accept="image/*" multiple hidden>
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
// Form validation
document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    let valid = true;
    const rating = document.querySelector('input[name="rating"]:checked');
    if (!rating) { valid = false; document.getElementById('ratingError').textContent = "Please select a rating."; } 
    else { document.getElementById('ratingError').textContent = ""; }
    const feedback = document.getElementById('feedback').value.trim();
    if (feedback === "") { valid = false; document.getElementById('feedbackError').textContent = "Feedback cannot be empty."; } 
    else { document.getElementById('feedbackError').textContent = ""; }
    if (!valid) event.preventDefault();
});

// Image upload preview
let selectedFiles = [];
const input = document.getElementById("imageInput");
const boxes = document.querySelectorAll(".upload-box");

function openPicker(index) {
    if (selectedFiles.length >= 5) return;
    input.click();
    input.onchange = () => {
        const file = input.files[0];
        if (!file) return;
        if (!file.type.startsWith("image/")) { alert("Only images allowed"); return; }
        if (selectedFiles.length < 5) { selectedFiles.push(file); updateBoxes(); }
        input.value = "";
    };
}

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
    syncInputFiles();
}

function syncInputFiles() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
}
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
