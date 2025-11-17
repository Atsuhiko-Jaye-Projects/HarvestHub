<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/cart_item.php";
include_once "../../../objects/product.php";
include_once "../../../objects/order.php";


$database = new Database();
$db = $database->getConnection();

$cart_item = new CartItem($db);
$product = new Product($db);
$order = new Order($db);

$cart_item->user_id = $_SESSION['user_id'];

$stmt = $cart_item->countCartItem();
$num = $stmt->rowCount();


$page_title = "Order";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['product_id'])) {
  $user_id = $_SESSION['user_id'] ?? 1;
  $invoice_no = 'INV-' . strtoupper(uniqid());
  $date = date("Y-m-d H:i:s");

  $user_id = $_SESSION['user_id'] ?? null;

  if (!$user_id) {
    die ("User not logged in.");
  }

  foreach($_POST['product_id'] as $pid){

    $order->product_id = $pid;
    
    $order->invoice_number = $invoice_no;
    $order->customer_id = $user_id;
    $order->mode_of_payment = $_POST['payment_method'];
    $order->quantity = isset($_POST['quantity'][$pid]) ? (int)$_POST['quantity'][$pid] : 1;
    $order->farmer_id = isset($_POST['farmer_id'][$pid]) ? (int)$_POST['farmer_id'][$pid] : 1;
    $order->status = "Order Placed";
    $order->created_at = $date;
    $order->placeOrder();
    // Update the products to ORDERED
    $cart_item->product_id = $pid;
    $cart_item->status = "Ordered";
    $cart_item->markCartItemsAsOrdered();
  }
  header("Location: checkout.php?invoice=$invoice_no");
  exit;
}


?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="checkoutForm">
  <div class="row mt-4">
    
    <!-- ✅ Left side: Cart Items -->
    <div class="col-md-8">
      <?php 
      if ($num > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $product->product_id = $row['product_id'];
          $product->readProductName();        

          $unit_price = $row['amount'] ?? 0; 
          $total_price = $unit_price * $row['quantity'];
      ?>
        <div class="card shadow-sm mb-3 p-3">
          <div class="d-flex align-items-start">
            
            <!-- ✅ Checkbox -->
            <div class="me-3">
              <input 
                type="checkbox"
                class="form-check-input product-checkbox"
                data-id="<?php echo $row['product_id']; ?>"
                data-qty="<?php echo $row['quantity']; ?>"
                data-price="<?php echo $total_price; ?>"
                name="product_id[]"
                value="<?php echo $row['product_id']; ?>">
            </div>

            <!-- ✅ Product Image -->
            <div class="me-3">
              <img 
                src="<?php echo $base_url; ?>user/uploads/<?php echo $product->user_id; ?>/products/<?php echo $product->product_image; ?>" 
                alt="Product Image" 
                class="border rounded"
                style="width:80px; height:80px; object-fit:cover;">
            </div>

            <!-- ✅ Product Details -->
            <div class="flex-grow-1">
              <h5 class="fw-bold mb-1 text-capitalize"><?php echo htmlspecialchars($product->product_name); ?></h5>
              <div class="mt-2">
                <label class="fw-semibold small text-muted">Quantity:</label>
                <div class="input-group input-group-sm" style="max-width: 120px;">
                  <button type="button" class="btn btn-outline-secondary btn-sm decrease-qty">−</button>
                  <input 
                    type="number" 
                    class="form-control text-center quantity-input" 
                    name="quantity[<?php echo $row['product_id']; ?>]" 
                    value="<?php echo $row['quantity']; ?>" 
                    min="1"
                    data-id="<?php echo $row['product_id']; ?>">
                  <button type="button" class="btn btn-outline-secondary btn-sm increase-qty">+</button>
                </div>
              </div>
              <div>Unit Price: <span class="fw-bold">₱<?php echo number_format($unit_price, 2); ?></span></div>
              <div>Total: <span class="fw-bold text-success">₱<?php echo number_format($total_price, 2); ?></span></div>
            </div>
          </div>

          <!-- ✅ Hidde xn Inputs -->
          <input type="hidden" name="farmer_id[<?php echo $row['product_id']; ?>]" value="<?php echo $product->user_id; ?>">
          <input type="hidden" name="quantity[<?php echo $row['product_id']; ?>]" value="<?php echo $row['quantity']; ?>">
          <input type="hidden" name="unit_price[<?php echo $row['product_id']; ?>]" value="<?php echo $unit_price; ?>">
        </div>
      <?php
        }
      } else {
        echo "<div class='alert alert-warning'>No items found in your cart.</div>";
      }
      ?>
    </div>

    <!-- ✅ Right side: Order Summary -->
    <div class="col-md-4">
      <div class="card shadow-sm position-sticky" style="top: 20px;">
        <div class="card-body">
          <h5 class="fw-bold">Order Summary</h5>

          <div class="d-flex justify-content-between">
            <span>Items Selected</span>
            <span id="items-count">0</span>
          </div>

          <div class="d-flex justify-content-between">
            <span>Shipping Fee</span>
            <span id="shipping-fee">₱50.00</span>
          </div>

          <div class="d-flex justify-content-between">
            <span>Total Price</span>
            <span id="total-price">₱0.00</span>
          </div>

          <hr>

          <div class="d-flex justify-content-between fw-bold">
            <span>Grand Total</span>
            <span id="grand-total">₱0.00</span>
          </div>

          <!-- ✅ Submit Button -->
        </div>
      </div>

      <!-- payment Method -->
      <div class="card shadow-sm position-sticky mt-3" style="top: 20px;">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Select Payment Method</h5>

          <div class="btn-group w-100" role="group" aria-label="Payment methods">
            <input type="radio" class="btn-check" disabled name="payment_method" id="gcash" value="GCash" autocomplete="off" required>
            <label class="btn btn-outline-primary w-100" for="gcash">
              <i class="bi bi-phone"></i> GCash
            </label>

            <input type="radio" class="btn-check" disabled  name="payment_method" id="maya" value="Maya" autocomplete="off">
            <label class="btn btn-outline-success w-100" for="maya">
              <i class="bi bi-wallet2"></i> Maya
            </label>

            <input type="radio" class="btn-check" name="payment_method" id="cod" value="COD" autocomplete="off" checked>
            <label class="btn btn-outline-secondary w-100" for="cod">
              <i class="bi bi-truck"></i> Cash on Delivery
            </label>

          </div>

          <!-- ✅ Submit Button -->
          <button type="submit" class="btn btn-success w-100 mt-3">Checkout</button>
        </div>
      </div>

    </div>
  </div>

  <!-- ✅ Hidden container for dynamic JS data -->
  <div id="selectedProductsContainer"></div>
</form>




<?php 
include_once "../layout/layout_foot.php"; ?>