<?php
ob_start();
$order_id = isset($_GET['vod']) ? $_GET['vod'] : die('ERROR: missing ID.');
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/product.php";
include_once "../../../objects/review.php";


$page_title = "Feedback Form";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

// verifiy the order if no review yet.
$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$review = new Review($db);

// pass the value of what order review will check
$order->id = $order_id;
$order->orderReviewStatus();

// pass the value to the variable to look clean
$productid = $order->product_id;
$farmerid = $order->farmer_id;
$customerId = $order->customer_id;


if ($_POST) {

    $review->rating = $_POST['rating'];
    $review->product_id = $productid;
    $review->farmer_id = $farmerid;
    $review->customer_id = $customerId;
    $review->review_text = $_POST['feedback'];

    if ($review->createReview()) {
        $order->review_status = "1";
        $order->id = $order_id;
        $order->markReviewStatus();
        header("Location:{$base_url}user/consumer/order/feedback.php?vod={$order_id}&success");
        exit;
    }else{
        header("Location:{$base_url}user/consumer/order/feedback.php?vod={$order_id}&failed");
    }
}




if ($order->review_status == 0) {

?>

<div class="container mt-5">
    <div class="row justify-content-center">

        <!-- SUCCESS MESSAGE -->


        <!-- Feedback Form -->
        <div class="col-md-8">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 text-center">We'd Love Your Feedback!</h5>
                    <input type="text" value="<?php echo $order->customer_id; ?>">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?vod={$order_id}");?>" method="POST" id="feedbackForm">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label">How would you rate your experience?</label>
                            

                            <div class="stars">
                                <input type="radio" id="star5" name="rating" value="5" class="star-input">
                                <label for="star5" class="star">&#9733;</label>

                                <input type="radio" id="star4" name="rating" value="4" class="star-input">
                                <label for="star4" class="star">&#9733;</label>

                                <input type="radio" id="star3" name="rating" value="3" class="star-input">
                                <label for="star3" class="star">&#9733;</label>

                                <input type="radio" id="star2" name="rating" value="2" class="star-input">
                                <label for="star2" class="star">&#9733;</label>

                                <input type="radio" id="star1" name="rating" value="1" class="star-input">
                                <label for="star1" class="star">&#9733;</label>
                            </div>

                            <div class="invalid-feedback d-block" id="ratingError"></div>
                        </div>

                        <!-- Feedback -->
                        <div class="mb-4">
                            <label class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="5" placeholder="Tell us what you think..." required></textarea>
                            <div class="invalid-feedback d-block" id="feedbackError"></div>
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
<?php
}else{
?>
    <div class="container mt-5">
        <div class="row justify-content-center">

            <!-- Feedback Form -->
            <div class="col-md-8">
                <div class="card shadow-sm border-light">
                    <div class="card-body text-center">

                        <div class="mb-3">
                            <i class="bi bi-emoji-smile-fill text-warning" style="font-size: 3rem;"></i>
                        </div>

                        <h5 class="card-title fw-bold mb-3">
                            You Already Rated This Product
                        </h5>

                        <p class="text-muted mb-4">
                            <i class="bi bi-info-circle"></i> Thank you for your feedback!
                        </p>

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
<?php
}
ob_end_flush();
?>

<!-- Star CSS -->
<style>
.stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 10px;
}
.star-input { display: none; }
.star {
    font-size: 2rem;
    color: #e0e0e0;
    cursor: pointer;
    transition: color 0.2s;
}
.star:hover,
.star:hover ~ .star {
    color: #ffbf00;
}
.star-input:checked + label,
.star-input:checked + label ~ label {
    color: #ffbf00;
}
</style>

<!-- Validation -->
<script>
document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    let valid = true;

    const rating = document.querySelector('input[name="rating"]:checked');
    if (!rating) {
        valid = false;
        document.getElementById('ratingError').textContent = "Please select a rating.";
    } else {
        document.getElementById('ratingError').textContent = "";
    }

    const feedback = document.getElementById('feedback').value.trim();
    if (feedback === "") {
        valid = false;
        document.getElementById('feedbackError').textContent = "Feedback cannot be empty.";
    } else {
        document.getElementById('feedbackError').textContent = "";
    }

    if (!valid) event.preventDefault();
});
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const oid = "<?php echo $order_id; ?>";
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        Swal.fire({
            imageUrl: '../../../libs/images/rate.png',
            title: 'Thank you!',
            text: 'Your feedback has been submitted.',
            imageWidth: 80,
            imageHeight: 80,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Okay'
        });

        // Remove ?success=1 from URL without reloading
        window.history.replaceState({}, document.title, `feedback.php?vod=${oid}`);
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('failed')) {
        Swal.fire({
            icon: 'error',
            title: 'Oh Snap!',
            text: 'Something went wrong, Please try again later.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Okay'
        });

        // Remove ?success=1 from URL without reloading
        window.history.replaceState({}, document.title, `feedback.php?vod=${oid}`);
    }
});
</script>



<?php include_once "../layout/layout_foot.php"; ?>
