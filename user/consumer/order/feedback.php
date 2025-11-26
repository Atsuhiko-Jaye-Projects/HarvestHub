<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/product.php";

$page_title = "My Orders";
include_once "../layout/layout_head.php";

// always make the page required is enabled
$require_login = true;
include_once "../../../login_checker.php";

$page_title = "Feedback Form";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <!-- Feedback Form -->
        <div class="col-md-8">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 text-center">We'd Love Your Feedback!</h5>
                    <form action="submit_feedback.php" method="POST" id="feedbackForm">
                        <!-- Rating Section (Star Rating) -->
                        <div class="mb-4">
                            <label for="rating" class="form-label">How would you rate your experience?</label>
                            <div class="stars">
                                <input type="radio" id="star5" name="rating" value="5" class="star-input"><label for="star5" class="star">&#9733;</label>
                                <input type="radio" id="star4" name="rating" value="4" class="star-input"><label for="star4" class="star">&#9733;</label>
                                <input type="radio" id="star3" name="rating" value="3" class="star-input"><label for="star3" class="star">&#9733;</label>
                                <input type="radio" id="star2" name="rating" value="2" class="star-input"><label for="star2" class="star">&#9733;</label>
                                <input type="radio" id="star1" name="rating" value="1" class="star-input"><label for="star1" class="star">&#9733;</label>
                            </div>
                            <div class="invalid-feedback d-block" id="ratingError"></div>
                        </div>

                        <!-- Feedback Section -->
                        <div class="mb-4">
                            <label for="feedback" class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="5" placeholder="Tell us what you think..." required></textarea>
                            <div class="invalid-feedback d-block" id="feedbackError"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Star Rating -->
<style>
    .stars {
        display: flex;
        justify-content: space-evenly;
        padding: 5px 0;
    }

    /* Hide radio buttons but keep them functional */
    .star-input {
        display: none; /* Hide the actual radio buttons */
    }

    /* Style for the stars */
    .star {
        font-size: 2rem;
        color: #e0e0e0;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    /* Hover effect and checked state for stars */
    .star:hover,
    .star:checked ~ .star {
        color: #ffbf00;
    }

    .star:checked {
        color: #ffbf00;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        color: #dc3545;
    }
</style>

<!-- JavaScript for Validation -->
<script>
    document.getElementById('feedbackForm').addEventListener('submit', function(event) {
        let valid = true;

        // Rating validation
        const rating = document.querySelector('input[name="rating"]:checked');
        if (!rating) {
            valid = false;
            document.getElementById('ratingError').textContent = "Please select a rating.";
        } else {
            document.getElementById('ratingError').textContent = "";
        }

        // Feedback validation
        const feedback = document.getElementById('feedback').value.trim();
        if (feedback === "") {
            valid = false;
            document.getElementById('feedbackError').textContent = "Feedback cannot be empty.";
        } else {
            document.getElementById('feedbackError').textContent = "";
        }

        if (!valid) {
            event.preventDefault();
        }
    });
</script>

<?php include_once "../layout/layout_foot.php"; ?>