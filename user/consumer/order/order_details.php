<?php

$order_id = isset($_GET['vod']) ? $_GET['vod'] : die('ERROR: missing ID.');
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/user.php";
include_once "../../../objects/product.php";
include_once "../../../objects/order_status_history.php";

$page_title = "Order";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);
$user = new User($db);
$farmer = new User($db);
$order_status = new OrderHistory($db);


$order->id = $order_id;
$order->readOrderDetails();

// get the user address info base on id
$user->id = $order->customer_id;
$user->getShippingAddress();
$shipping_address = "{$user->address},{$user->barangay},{$user->municipality}";




//get the product total price
$product->product_id = $order->product_id;
$product->getProductInfo();

// compute the product Price
$quanitity = $order->quantity;
$price = $product->price_per_unit;
$total = $price * $quanitity;
$shipping_fee = $total * 0.0225;
$grand_total = $total + $shipping_fee;

// get the farmer info for Consumer
$farmer->id = $product->user_id;
$farmer->getFarmerInfo();

//get order history
$order_status->invoice_number = $order->invoice_number;
$order_status->product_id = $order->product_id;
$stmt = $order_status->getOrderStatus();
$num = $stmt->rowCount();

$date = date('Y-m-d');

$farmer_address = "{$farmer->address}, {$farmer->barangay}, {$farmer->municipality}, {$farmer->province}";
$farmer_contact = $farmer->contact_number;
?>
  
    <div class="row mt-4">
      <div class="col-md-8">
          <?php include_once "modal/cancel_order_modal.php"; ?>
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title fw-bold">Order Details</h5>
            <p class="text-muted small mb-2"><i class="bi bi-calendar"></i> <?php echo $order->created_at; ?></p>

            <!-- Delivery Info -->
            <div class="border p-3 rounded mb-3">
              <h6 class="fw-bold">Delivery info</h6>
              <p class="mb-0"><i class="bi bi-geo-alt text-success"></i> <?php echo $shipping_address;?></p>
              <p class="mb-0"><i class="bi bi-cash-coin text-success"></i> <?php echo $order->mode_of_payment; ?> </p>
              <p class="mb-9"><i class="bi bi-phone"> <?php echo $user->contact_number; ?></i></p>
            </div>

            <!-- Farmer Info -->
            <div class="border p-3 rounded mb-3">
              <h6 class="fw-bold">Farmer info</h6>
              <p class="mb-0"><i class="bi bi-geo-alt text-success"></i> <?php echo $farmer_address;?>  </p>
              <p class="mb-0"><i class="bi bi-phone"> </i> <?php echo $farmer_contact;?></p>
            </div>

            <!-- Payment Method -->

            <!-- Review Order -->
            <div class="border p-3 rounded" id='order_details_img'>
              <h6 class="fw-bold">Review Order</h6>
                <p class="mb-1">
                  <i class="bi bi-receipt text-success"></i>
                  Invoice #: <strong><?php echo htmlspecialchars($order->invoice_number ?? 'Not set'); ?></strong>
                </p>
              <div class="d-flex align-items-center">
                <img src="<?php echo $base_url;?>libs/images/logo.png" alt="Product">
                <div class="bg-light border rounded d-flex justify-content-center align-items-center" style="width:60px; height:60px;">+12</div>
              </div>
              <?php include_once "tracking_status.php"; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Right side: Order Summary -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold">Order Summary</h5>
            <div class="d-flex justify-content-between">
              <span>Service Fee (2.25%)</span>
              <span>₱<?php echo number_format($shipping_fee,2)?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Items total</span>
              <span>₱<?php echo number_format($total,2)?></span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
              <span>Total</span>
              <span>₱<?php echo number_format($grand_total,2)?></span>
            </div>
            <button type="submit" class="btn btn-outline-danger w-100 mt-3" data-bs-toggle="modal" data-bs-target="#cancel-order-modal"><i class="bi bi-x-lg"></i> Cancel Order</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once "../layout/layout_foot.php"; ?>