<?php 
$order_id = isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: missing ID.');
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/order.php'; 
include_once '../../../objects/product.php';
include_once '../../../objects/user.php';

$page_title = "Process Order";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);
$customer = new User($db);


// get order info to accept or decline
$order->id = $order_id;
$order->readOneOrder();

// get product details
$product->product_id = $order->product_id; 
$product->getProductInfo();

// get customer info
$customer->id = $order->customer_id;
$customer->getShippingAddress();


//arrange the product image path
$user_id = $product->user_id;
$raw_product_image = $product->product_image;
$product_image_path = "{$base_url}user/uploads/{$user_id}/products/{$raw_product_image}";

// compute service fee

$sub_total = ($order->quantity * $product->price_per_unit);
$service_fee = $sub_total * 0.0225;



if (!empty($_POST['action']) && in_array($_POST['action'], ['accept', 'decline', 'cancel', 'complete'])) {
    $order->id = $_POST['order_id'];
    $order->status = $_POST['action'];

    if ($order->processOrder($_POST['action'])) {
        echo "<div class='alert alert-success'>
                Order " . ucfirst($_POST['action']) . "
              </div>";
    } else {
        echo "<div class='alert alert-danger'>
                Failed to update order
              </div>";
    }
}elseif (!empty($_POST['action']) == 'complete') {
}


?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?pid={$order_id}"; ?>" method="POST" id="checkoutForm">
  <div class="row mt-4">
    
    <!-- ✅ Left side: Cart Items -->
  <div class="col-md-8">
    <div class="card shadow-sm position-sticky" style="top: 20px;">
        <div class="card-body">

          <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">

            <!-- PRODUCT SNAPSHOT -->
            <h5 class="fw-bold mb-3">Product Information</h5>
            <div class="d-flex align-items-start mb-3">
                <img src="<?php echo $product_image_path; ?>" 
                     alt="Product Image"
                     class="rounded border"
                     width="100" height="100">
                
                <div class="ms-3">
                    <h6 class="fw-bold mb-1"><?php echo $product->product_name; ?></h6>
                    <p class="mb-1 text-muted small">
                        Category: <span class="fw-semibold"><?php echo $product->category; ?></span>
                    </p>
                </div>
            </div>

            <!-- ORDER DETAILS -->
            <div class="d-flex justify-content-between">
                <span>Quantity Ordered</span>
                <span class="fw-semibold"><?php echo $order->quantity . '' . "KG"; ?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Unit Price</span>
                <span class="fw-semibold text-success">₱ <?php echo number_format($product->price_per_unit, 2); ?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Subtotal</span>
                <span class="fw-semibold">₱ <?php echo number_format($order->quantity * $product->price_per_unit, 2); ?></span>
            </div>

            <hr>

            <!-- BUYER INFO -->
            <h6 class="fw-bold">Buyer Information</h6>
            <div class="d-flex justify-content-between">
                <span>Name</span>
                <span><?php echo $customer->firstname ." ". $customer->lastname; ?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Contact</span>
                <span><?php echo $customer->contact_number; ?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Address</span>
                <span><?php echo $customer->address . " " . $customer->barangay . " " . $customer->municipality; ?></span>
            </div>

            <hr>

            <!-- DELIVERY & PAYMENT -->
            <div class="d-flex justify-content-between">
                <span>Delivery Method</span>
                <span><?php echo "N/A"; ?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Preferred Schedule</span>
                <span><?php echo 'Not specified'; ?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Mode of Payment</span>
                <span><?php echo $order->mode_of_payment; ?></span>
            </div>

            <!-- META -->
            <div class="d-flex justify-content-between">
                <span>Invoice No.</span>
                <span><?php echo $order->invoice_number; ?></span>
            </div>

            <hr>

        </div>
    </div>
</div>


    <!-- ✅ Right side: Order Summary -->
    <div class="col-md-4">
      <div class="card shadow-sm position-sticky" style="top: 20px;">
        <div class="card-body">
          <h5 class="fw-bold">Order Summary</h5>



          <div class="d-flex justify-content-between">
            <span>Service Fee (2.25%)</span>
            <span id="shipping-fee">₱ <?php echo number_format($service_fee, 2); ?></span>
          </div>

          <div class="d-flex justify-content-between">
            <span>Total Price</span>
            <span id="total-price">₱<?php echo number_format($order->quantity * $product->price_per_unit, 2); ?></span>
          </div>

          <hr>

          <div class="d-flex justify-content-between fw-bold">
            <span>Grand Total</span>
            <span id="grand-total">₱<?php echo number_format($order->quantity * $product->price_per_unit - $service_fee, 2); ?></span>
          </div>

          <!-- ✅ Submit Button -->
        </div>
      </div>

      
      <div class="card shadow-sm position-sticky mt-3" style="top: 20px;">
        <div class="card-body text-center">

          <?php
            if ($order->status == "order placed" && $product->product_type == "preorder") {
          ?>
          <h6 class="fw-bold text-muted mb-3">Confirm This Pre-Order?</h6>
          <button type="submit" name="action" value="accept-pre-order"class="btn btn-success w-100 mb-2">Accept Pre-Order</button>
          <button type="submit" name="action" value="decline-pre-order" class="btn btn-outline-danger w-100">Decline Pre-Order</button>
          
          <?php
            } elseif ($order->status == "order placed"  && $product->product_type == "harvest") {
          ?>

          <h6 class="fw-bold text-muted mb-3 mt-3">Accept this Order?</h6>
          <button type="submit" name="action" value="accept" class="btn btn-success w-100 mb-2">Accept</button>
          <button type="submit" name="action" value="decline" class="btn btn-outline-danger w-100">Decline</button>

          <?php
            } elseif ($order->status == "complete") {
          ?>

          <h6 class="fw-bold text-muted mb-3 mt-3">This transaction is complete</h6>
          <a href="order.php" class="btn btn-outline-success w-100">Return</a>

          <?php } elseif ($order->status == "accept") { ?>

          <h6 class="fw-bold text-muted mb-3 mt-3">Complete this transaction?</h6>
          <button type="submit" name="action" value="complete" class="btn btn-success w-100 mb-2">Complete</button>
          <button type="submit" name="action" value="cancel" class="btn btn-outline-danger w-100">Cancel</button>

          <?php
          } else {
          ?>

          <h6 class="fw-bold text-muted mb-3 mt-3">This transaction is cancelled</h6>
          <a href="order.php" class="btn btn-outline-danger w-100 mb-3">Return</a>
          <button type="submit" name="action" value="accept" class="btn btn-success w-100 mb-2">Re-Open</button>

          <?php } ?>
        </div>
            <input type="hidden" name="action" id="actionInput">
      </div>


    </div>
  </div>

  <!-- ✅ Hidden container for dynamic JS data -->
  <div id="selectedProductsContainer"></div>
</form>

<script>
  document.querySelectorAll('.order-action').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.dataset.id;
        const action = this.dataset.action;

        fetch('process_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `order_id=${orderId}&action=${action}`
        })
        .then(res => res.text())
        .then(data => {
            // display response message
            document.getElementById('order-msg').innerHTML = data;

            // optionally, reload chart or totals
            // loadChart(); or updateDashboard();
        });
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Attach to ALL submit buttons inside this card-body
    const buttons = document.querySelectorAll('.card-body button[type="submit"]');

    buttons.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault(); // stop immediate submit

            let action = this.value;
            let form = this.closest("form");
            actionInput.value = action;
            let message = "";

            // Match your button values WITHOUT changing them
            if (action === "accept-pre-order") {
                message = "Accept this pre-order?";
            } else if (action === "decline-pre-order") {
                message = "Decline this pre-order?";
            } else if (action === "accept") {
                message = "Accept this order?";
            } else if (action === "decline") {
                message = "Decline this order?";
            } else if (action === "complete") {
                message = "Complete this transaction?";
            } else if (action === "cancel") {
                message = "Cancel this transaction?";
            } else if (action === "accept") {
                message = "Re-open this cancelled order?";
            } else {
                message = "Are you sure?";
            }

            Swal.fire({
                title: message,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>




<?php include_once "../layout/layout_foot.php"; ?>