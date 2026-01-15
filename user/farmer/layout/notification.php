<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/config/core.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/config/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/objects/order.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/objects/review.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$review = new Review($db);

$review->farmer_id = $_SESSION['user_id'];
$review_count_notification = $review->reviewCountNotification();

$order->farmer_id = $_SESSION['user_id'];
$order_count_notification = $order->countPendingOrder();

$review_count_notification = (int)$review_count_notification;
$order_count_notification = (int)$order_count_notification;
$over_count_notification = $review_count_notification + $order_count_notification;



?>

<div class="position-relative d-inline-block me-3">
    <button
        class="btn p-0 border-0 bg-transparent"
        type="button"
        id="notificationDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="bi bi-bell fs-4"></i>
        <?php if ($over_count_notification > 0) {?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $over_count_notification; ?>
            </span>
        <?php } ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow"
    aria-labelledby="notificationDropdown"
    style="width: 280px;">

        <li class="dropdown-header fw-bold">Notifications</li>

        <li>
            <?php if($review_count_notification > 0){ ?>
                <a class="dropdown-item small" href="/HarvestHub/user/farmer/review/feedback.php">
                    💬 You have <strong><?= $review_count_notification ?></strong> new review<?= $review_count_notification > 1 ? 's' : '' ?>
                </a>
            <?php }else{ ?>
                <a class="dropdown-item small" href="">
                    ✅ No new reviews
                </a>
            <?php } ?>
        </li>

        <li>
            <?php if($order_count_notification > 0): ?>
                <a class="dropdown-item small d-flex justify-content-between align-items-center" href="/HarvestHub/user/farmer/order/order.php">
                    🛒 You have <?= $order_count_notification ?> new order<?= $order_count_notification > 1 ? 's' : '' ?>
                </a>
            <?php else: ?>
                <a class="dropdown-item small text-muted" href="/HarvestHub/user/farmer/orders.php">
                    ✅ No new orders
                </a>
            <?php endif; ?>
        </li>
    </ul>
</div>