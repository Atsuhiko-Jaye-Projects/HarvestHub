<?php 
$order_id = isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: missing ID.');
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/order.php'; 

$page_title = "Process Order";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);




?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="checkoutForm">
  <div class="row mt-4">
    
    <!-- ✅ Left side: Cart Items -->
    <div class="col-md-8">
        <div class="card shadow-sm position-sticky" style="top: 20px;">
            <div class="card-body">
            <h5 class="fw-bold">Process Order</h5>

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
              <i class="bi bi-phone"></i> ACCEPT
            </label>

            <input type="radio" class="btn-check" disabled  name="payment_method" id="maya" value="Maya" autocomplete="off">
            <label class="btn btn-outline-success w-100" for="maya">
              <i class="bi bi-wallet2"></i> DECLINE
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

<?php include_once "../layout/layout_foot.php"; ?>