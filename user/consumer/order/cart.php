<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/cart_item.php";
include_once "../../../objects/product.php";


$database = new Database();
$db = $database->getConnection();

$cart_item = new CartItem($db);
$product = new Product($db);

$cart_item->user_id = $_SESSION['user_id'];

$stmt = $cart_item->countCartItem();
$num = $stmt->rowCount();


$page_title = "Order";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";




?>

<form action="checkout.php" method="POST" id="checkoutForm">
  <div class="row mt-4">
    <!-- Left side: Cart Items -->
    <div class="col-md-8">
      <?php 
      if ($num > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $product->id = $row['product_id'];
          $product->readProductName();        

          $unit_price = $row['amount'] ?? 0; 
      ?>
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <!-- ✅ Checkbox with data -->
            <input type="checkbox" 
                   class="form-check-input mb-3 product-checkbox"
                   data-id="<?php echo $row['product_id']; ?>"
                   data-qty="<?php echo $row['quantity']; ?>"
                   data-price="<?php echo $unit_price * $row['quantity']; ?>"> 
            
            <div class="border p-3 rounded mb-3">
              <h6 class="fw-bold"><?php echo htmlspecialchars($product->product_name); ?></h6>
              <h6 class="fw-bold">Qty: <?php echo $row['quantity']; ?></h6>
              <h6 class="fw-bold">Unit Price: ₱<?php echo number_format($unit_price, 2); ?></h6>

              <div class="border p-3 rounded" id="order_details_img">
                <div class="d-flex align-items-center">
                  <img src="<?php echo $base_url; ?>user/uploads/<?php echo $product->user_id; ?>/products/<?php echo $product->product_image; ?>" 
                       alt="Product" 
                       style="width:60px; height:60px; object-fit:cover;">
                  <div class="bg-light border rounded d-flex justify-content-center align-items-center ms-2" 
                       style="width:60px; height:60px;">+12</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
        }
      }
      ?>
    </div>

    <!-- Right side: Order Summary -->
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
        </div>
      </div>

      <!-- ✅ Submit Button -->
      <button type="submit" class='btn btn-success w-100 mt-3'>Checkout</button>
    </div>
  </div>

  <!-- ✅ Hidden container for dynamic inputs -->
  <div id="selectedProductsContainer"></div>
</form>




</div>

<?php include_once "../layout/layout_foot.php"; ?>