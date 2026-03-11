<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/product.php";

$page_title = "My Orders";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 20; 
$from_record_num = ($records_per_page * $page) - $records_per_page;

$order->customer_id = $_SESSION['user_id'];
$stmt = $order->readAllOrder($from_record_num, $records_per_page);
$num = $stmt->rowCount();
?>

<style>
    :root { --harvest-green: #10b981; --harvest-dark: #1e293b; --bg-soft: #f8fafc; }
    body { background-color: var(--bg-soft); font-family: 'Inter', sans-serif; }
    
    .filter-pills { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none; }
    .filter-pills::-webkit-scrollbar { display: none; }
    
    .filter-btn {
        border: 1px solid #e2e8f0; background: white; color: #64748b;
        padding: 8px 18px; border-radius: 50px; font-size: 0.85rem; font-weight: 600;
        transition: 0.2s; white-space: nowrap; cursor: pointer;
    }
    .filter-btn.active { background: var(--harvest-green); color: white; border-color: var(--harvest-green); box-shadow: 0 4px 10px rgba(16,185,129,0.2); }

    .order-card { background: white; border: 1px solid #eef2f6; border-radius: 15px; overflow: hidden; margin-bottom: 20px; transition: 0.3s; }
    .invoice-header { background: #fcfdfd; padding: 12px 20px; border-bottom: 1px solid #f1f5f9; }
    .product-img-sm { width: 65px; height: 65px; object-fit: cover; border-radius: 10px; }
    
    /* Button Styles */
    .btn-sm-custom { border-radius: 8px; font-weight: 700; padding: 7px 16px; font-size: 0.8rem; text-decoration: none !important; display: inline-block; transition: 0.2s; }
    .btn-rate { background-color: #f59e0b; color: white; border: none; }
    .btn-rate:hover { background-color: #d97706; color: white; }
    .btn-details { border: 1px solid var(--harvest-green); color: var(--harvest-green); background: transparent; }
    .btn-details:hover { background-color: var(--harvest-green); color: white; }
</style>

<div class="container py-4">
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">My Orders</h4>
        <p class="text-muted small">Track your farm-to-table purchases.</p>
    </div>

    <div class="filter-pills mb-4">
        <button class="filter-btn active" data-status="all">All</button>
        <button class="filter-btn" data-status="in-progress">In Progress</button>
        <button class="filter-btn" data-status="delivered">Delivered</button>
        <button class="filter-btn" data-status="complete">Complete</button>
        <button class="filter-btn" data-status="cancelled">Cancelled</button>
    </div>

    <div id="ordersContainer">
    <?php
    if ($num > 0) {
        $groupedOrders = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $groupedOrders[$row['invoice_number']][] = $row;
        }

        foreach ($groupedOrders as $invoice => $orders) {
            $first = $orders[0];
            $rawStatus = strtolower($first['status']);
            
            // Logic for filtering Categories
            $category = "in-progress";
            if($rawStatus == "complete") $category = "complete";
            elseif($rawStatus == "delivered" || $rawStatus == "in transit") $category = "delivered";
            elseif($rawStatus == "cancelled" || $rawStatus == "decline") $category = "cancelled";

            // UI Status Badges
            $statusLabel = $rawStatus; $statusClass = "bg-light text-dark";
            switch($rawStatus) {
                case "order placed": $statusLabel = "Order Placed"; $statusClass = "bg-info text-white"; break;
                case "accept": $statusLabel = "Preparing"; $statusClass = "bg-warning text-dark"; break;
                case "complete": $statusLabel = "Complete"; $statusClass = "bg-success text-white"; break;
                case "in transit": $statusLabel = "In Transit"; $statusClass = "bg-primary text-white"; break;
                case "delivered": $statusLabel = "Delivered"; $statusClass = "bg-success text-white"; break;
                case "decline": $statusLabel = "Declined"; $statusClass = "bg-danger text-white"; break;
                case "cancelled": $statusLabel = "Cancelled"; $statusClass = "bg-secondary text-white"; break;
                case "accept pre-order": $statusLabel = "Pre-Order Accepted"; $statusClass = "bg-info text-white"; break;
            }
    ?>
            <div class="order-card shadow-sm" data-category="<?php echo $category; ?>">
                <div class="invoice-header d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">Invoice #<?php echo $invoice; ?></h6>
                        <small class="text-muted"><?php echo date('M d, Y | h:i A', strtotime($first['created_at'])); ?></small>
                    </div>
                    <span class="badge <?php echo $statusClass; ?> rounded-pill px-3 py-2 text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                        <?php echo $statusLabel; ?>
                    </span>
                </div>

                <div class="p-3">
                    <?php 
                    $grandTotal = 0;
                    foreach ($orders as $row) {
                        $product->product_id = $row['product_id'];
                        $product->readProductName();
                        
                        $qty = $row['quantity'];
                        $unit = strtolower($row['unit']);
                        $qty_in_kg = ($unit === 'kg') ? $qty : $qty / 1000;
                        $itemTotal = $product->price_per_unit * $qty_in_kg;
                        $grandTotal += $itemTotal;

                        $img_path = ($product->product_type == "preorder") 
                                    ? "{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}"
                                    : "{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}";
                    ?>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="<?php echo $img_path; ?>" class="product-img-sm border shadow-sm">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($product->product_name); ?></h6>
                                <small class="text-muted"><?php echo $qty . $unit; ?> • ₱<?php echo number_format($product->price_per_unit, 2); ?>/kg</small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-dark">₱<?php echo number_format($itemTotal, 2); ?></span>
                            </div>
                        </div>
                    <?php } ?>

                    <hr class="my-3 opacity-25">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-0">Total Amount</p>
                            <h5 class="text-success fw-bold mb-0">₱<?php echo number_format($grandTotal, 2); ?></h5>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if ($rawStatus === "complete" && $first['review_status'] == 0): ?>
                                <a href="<?php echo $base_url; ?>user/consumer/order/feedback.php?vod=<?php echo $first['id']; ?>" class="btn-sm-custom btn-rate">
                                    <i class="bi bi-star-fill me-1"></i> Rate
                                </a>
                            <?php endif; ?>

                            <a href="order_details.php?vod=<?php echo $first['id']; ?>" class="btn-sm-custom btn-details">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<div class='text-center py-5'><i class='bi bi-basket text-muted fs-1'></i><p class='text-muted mt-2'>No orders yet.</p></div>";
    }
    ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.order-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-status');
            cards.forEach(card => {
                const cat = card.getAttribute('data-category');
                card.style.display = (filter === 'all' || cat === filter) ? 'block' : 'none';
            });
        });
    });
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>