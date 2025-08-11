<?php
$product_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID');

include_once "../../config/core.php";
include_once "../../config/database.php";
include_once "../../objects/review.php";


$database = new Database();
$db = $database->getConnection();

$review = new Review($db);

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Reviews";
include_once "layout_head.php";

$review->product_id = $product_id;
$review->user_id = $_SESSION['user_id'];
$stmt = $review->readAllReview();
$num = $stmt->rowCount();

// include the stats cards
include_once "stats.php";
?>

<div class="container">
<?php
    if ($num > 0) {
?>
<div class="table-responsive mt-2">
    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th>Customer</th>
                <th>Review</th>
                <th>Rating</th>
                <th>Date</th>
                <th>Reply</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row); // will give $customer_name, $review_text, $rating, etc.

                echo "<tr>";
                    // Customer name
                    echo "<td>{$customer_id}</td>";

                    // Review text
                    echo "<td>{$review_text}</td>";

                    // Rating stars
                    echo "<td>";
                        for ($i = 0; $i < $rate; $i++) {
                            echo "⭐";
                        }
                    echo "</td>";

                    // Date
                    echo "<td>{$created_at}</td>";

                    // Reply form
                    echo "<td>";
                        echo "<form method='post' action='send_reply.php'>";
                            echo "<textarea name='reply' class='form-control mb-2' placeholder='Write a reply...'>" . htmlspecialchars($reply) . "</textarea>";
                            echo "<input type='hidden' name='review_id' value='{$id}'>";
                            echo "<button type='submit' class='btn btn-success btn-sm'>Send Reply</button>";
                        echo "</form>";
                    echo "</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>
<?php
    } else {
        echo "<div class='alert alert-danger'>No Reviews Found</div>";
    }
?>
</div>

</div>


