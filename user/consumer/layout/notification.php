<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/config/core.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/config/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/objects/order_status_history.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/objects/order.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$order_status_history = new OrderHistory($db);

$order->customer_id = $_SESSION['user_id'];
$notification_stmt = $order->getOrder();
$notification_num = $notification_stmt->rowCount();

$badgeCount = $order_status_history->getLatestUnseenCount();


?>

<div class="position-relative d-inline-block me-3">
    <button
        class="btn p-0 border-0 bg-transparent position-relative"
        type="button"
        id="notificationDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="bi bi-bell fs-4"></i>
        <?php // Badge example ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?php echo $badgeCount; ?>
        </span>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow p-0"
        aria-labelledby="notificationDropdown"
        style="max-width: 90vw; width: 500px; max-height: 400px; overflow-y: auto; border-radius: 10px;">
        
        <!-- Header -->
        <li class="dropdown-header fw-bold text-center py-2 border-bottom">Notifications</li>

        <?php
            if ($notification_num > 0) {
                while ($row = $notification_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $invoice_no = $row['invoice_number'];
                    $order_id = $row['id'];

                    // Get the latest update for this invoice
                    $order_status_history->invoice_number = $invoice_no;
                    $order_status = $order_status_history->getOrderUpdate();

                    // Make sure the result exists
                    if ($order_status) {
                        $status = $order_status['status'];
                        $notif_viewed = $order_status['notif_viewed'];
                        $notif_id = $order_status['id'];

                        // Only show if not viewed
                        if ($notif_viewed != '1') {
                            ?>
                            <li>
                                <a class="dropdown-item small text-dark py-2 px-3 d-flex justify-content-between align-items-center mark-seen" 
                                data-invoice="<?= $invoice_no ?>" 
                                data-notif="<?= $notif_id ?>"
                                href="/HarvestHub/user/consumer/order/order_details.php?vod=<?= $order_id ?>">
                                    <span class="text-truncate" style="max-width: 100%">
                                        Your Order <strong><?= $invoice_no ?></strong> has an update <strong>(<?= strtoupper($status) ?>)</strong>
                                    </span>
                                    <i class="bi bi-arrow-right text-muted small"></i>
                                </a>
                            </li>
                            <?php
                        }
                    }
                }
            } else {
                ?>
                <li>
                    <a class="dropdown-item small text-muted text-center py-3" href="#">No Update yet</a>
                </li>
                <?php
            }

        ?>
    </ul>
</div>
