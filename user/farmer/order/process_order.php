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



if (isset($_POST['action'])) {

    $order->id = $_POST['order_id'];
    $order->status = $_POST['action']; // accept OR decline

    if ($order->processOrder($_POST['action'])) {
        
        echo "<div class='alert alert-success'>
                Order " . ucfirst($_POST['action']) . "
              </div>";

    } else {

        echo "<div class='alert alert-danger'>
                Failed to update order
              </div>";
    }
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

          <h6 class="fw-bold text-muted mb-3">Confirm This Order?</h6>

          <button type="submit" name="action" value="Accept"class="btn btn-success w-100 mb-2">Accept Order</button>
          <button type="submit" name="action" value="Decline" class="btn btn-outline-danger w-100">Decline Order</button>

        </div>
      </div>


    </div>
  </div>

  <!-- ✅ Hidden container for dynamic JS data -->
  <div id="selectedProductsContainer"></div>
</form>

<?php include_once "../layout/layout_foot.php"; ?>