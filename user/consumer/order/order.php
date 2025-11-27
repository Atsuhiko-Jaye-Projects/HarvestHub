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

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);

$page = "order.php";

$page_url = "{$home_url}user/farmer/management/manage_harvest.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// get the userId to get the order details
$order->customer_id = $_SESSION['user_id'];

$stmt = $order->readAllOrder($from_record_num, $records_per_page);
$num = $stmt->rowCount();



?>


<div class="container py-3">

  <!-- Filter Buttons -->
  <div class="d-flex flex-wrap gap-2 mb-3">
    <button class="btn btn-outline-success btn-sm">All</button>
    <button class="btn btn-outline-success btn-sm">In Progress</button>
    <button class="btn btn-outline-success btn-sm">Delivered</button>
    <button class="btn btn-outline-success btn-sm">Complete</button>
  </div>

  <!-- Page Header -->
  <div class="bg-success text-white p-3 rounded mb-3">
    <h5 class="mb-0"><i class="bi bi-basket-fill me-2"></i><?php echo $page_title; ?></h5>
    <small class="text-light">Track and manage your recent orders.</small>
  </div>

  <!-- Order Card Example -->
  <?php
if ($num > 0) {

    // GROUP BY INVOICE
    $groupedOrders = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $groupedOrders[$row['invoice_number']][] = $row;
    }

    // LOOP THROUGH EACH INVOICE GROUP
    foreach ($groupedOrders as $invoice => $orders) {

        $first = $orders[0];
        $invoiceID = "invoice_" . $invoice; // unique collapse ID
?>
        <div class="order-card p-3 border mb-3">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    
                    <h6 class="mb-0 fw-semibold">Invoice NO. <?php echo $invoice; ?></h6>
                    <small class="text-muted"><?php echo $first['created_at']; ?></small>
                </div>

                <!-- STATUS BADGE -->
                <?php
                $status = $first['status'];
                switch ($status) {
                    case "order placed": $displayStatus = "Order Placed"; $class = "bg-info text-white"; break;
                    case "accept": $displayStatus = "Preparing"; $class = "bg-warning text-dark"; break;
                    case "decline": $displayStatus = "Declined"; $class = "bg-danger text-white"; break;
                    case "complete": $displayStatus = "Complete"; $class = "bg-success text-white"; break;
                    case "in Transit": $displayStatus = "In Transit"; $class = "bg-primary text-white"; break;
                    case "cancelled": $displayStatus = "Cancelled"; $class = "bg-secondary text-white"; break;
                    default: $displayStatus = $status; $class = "bg-light text-dark"; break;
                }
                ?>
                <span class="badge <?php echo $class; ?>"><?php echo $displayStatus; ?></span>
            </div>

            <hr>

            <!-- COLLAPSIBLE PRODUCTS LIST -->
            <div id="<?php echo $invoiceID; ?>" class="collapse">
                <?php foreach ($orders as $row) {

                    $product->product_id = $row['product_id'];
                    $product->readProductName();

                    $raw_img = $product->product_image;
                    $img_owner = $product->user_id;
                    $img_path = "{$base_url}user/uploads/{$img_owner}/products/{$raw_img}";

                    $price = $product->price_per_unit;
                    $qty = $row['quantity'];
                    $total = $price * $qty;
                ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <img src="<?php echo $img_path; ?>" class="img-fluid rounded">
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-success">₱<?php echo number_format($total, 2); ?></h6>
                            <small class="text-muted"><?php echo $row['mode_of_payment']; ?></small>
                            <h6>Variation: <strong><?php echo $qty; ?> KG</strong></h6>
                            <small class="text-muted fw-bold"><?php echo $product->product_name; ?></small>
                        </div>
                    </div>
                  <hr>
                <?php 
              } 
              ?>
            </div>
            <!-- SEE MORE / SEE LESS BUTTON -->
            <button class="btn btn-primary btn-sm toggle-btn"
                    data-bs-toggle="collapse"
                    data-bs-target="#<?php echo $invoiceID; ?>">
                See More
            </button>


            <!-- FOOTER BUTTON -->
            <div class="text-end mt-3">
                <!-- Order Total -->
                <div class="mb-3 d-flex justify-content-end align-items-baseline gap-2">
                    <h6 class="text-primary mb-0">Order Total</h6>
                    <h4 class="text-success mb-0">₱<?php echo number_format($total, 2); ?></h4>
                </div>

                <!-- Buttons -->
                <?php 
                if ($first['status'] == "complete" && $first['review_status'] != 1) {
                    // Complete but not yet reviewed
                ?>
                    <a href="<?php echo $base_url; ?>user/consumer/order/feedback.php?vod=<?php echo $first['id']; ?>" class="btn btn-warning btn-sm">Rate this order</a>
                <?php 
                } elseif ($first['status'] != "complete") { 
                    // Not complete yet
                ?>
                    <a href="order_details.php?vod=<?php echo $first['id']; ?>" class="btn btn-outline-success btn-sm">View Order Details</a>
                <?php 
                } 
                // If complete and review_status == 1, no button is shown
                ?>
            </div>
        </div>

<?php
    }
} else {
    echo "<div class='alert alert-danger'>No Order found</div>";
}
?>

</div>

<script>
document.querySelectorAll('.toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        setTimeout(() => {
            if (this.textContent === "See More") {
                this.textContent = "See Less";
            } else {
                this.textContent = "See More";
            }
        }, 200);
    });
});
</script>


<?php include_once "../layout/layout_foot.php"; ?>
