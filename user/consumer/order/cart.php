<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/cart_item.php";
include_once "../../../objects/product.php";
include_once "../../../objects/order.php";
include_once "../../../objects/user.php";
include_once "../../../objects/order_status_history.php";


$database = new Database();
$db = $database->getConnection();

$cart_item = new CartItem($db);
$product = new Product($db);
$order = new Order($db);
$user = new User($db);
$order_history = new OrderHistory($db);

$cart_item->user_id = $_SESSION['user_id'];

$stmt = $cart_item->countCartItem();
$num = $stmt->rowCount();

// check the user address details
$user->id = $_SESSION['user_id'];
$row = $user->checkUserAddress();
$complete_address = trim(
    $row['address'] .
    $row['barangay'] .
    $row['municipality'] .
    $row['province']
);


$page_title = "Order";
include_once "../layout/layout_head.php";

if (empty(trim($complete_address))) {
  include_once "../layout/notice.php";
}

$require_login=true;
include_once "../../../login_checker.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['product_id'])) {
  $user_id = $_SESSION['user_id'] ?? 1;
  // $invoice_no = 'INV-' . strtoupper(uniqid());
  $date = date("Y-m-d H:i:s");

  $user_id = $_SESSION['user_id'] ?? null;

  if (!$user_id) {
    die ("User not logged in.");
  }

  foreach($_POST['product_id'] as $pid){

    $invoice_no = 'INV-' . strtoupper(uniqid());
    $order->product_id = $pid;
    $order->invoice_number = $invoice_no;
    $order->customer_id = $user_id;
    $order->mode_of_payment = $_POST['payment_method'];
    $order->quantity = isset($_POST['quantity'][$pid]) ? (int)$_POST['quantity'][$pid] : 1;
    $order->farmer_id = isset($_POST['farmer_id'][$pid]) ? (int)$_POST['farmer_id'][$pid] : 1;
    $order->status = "order placed";
    $order->created_at = $date;
    $order->product_type = isset($_POST['product_type'][$pid]) 
    ? strip_tags($_POST['product_type'][$pid]) // sanitize the string
    : 'unknown'; // fallback if not set

    $order->placeOrder();
    // record order history
    $order_history->product_id = $pid;
    $order_history->invoice_number = $invoice_no;
    $order_history->status = "order placed";
    $order_history->timestamp = $date;
    $order_history->recordStatus();

    // Update the products to ORDERED
    $cart_item->product_id = $pid;
    $cart_item->status = "ordered";
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
          $stocks = $product->available_stocks;
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
                data-stocks="<?php echo $stocks; ?>"
                name="product_id[]"
                value="<?php echo $row['product_id']; ?>">
            </div>  

            <?php
              $raw_image = $product->product_image;
              $image_path = '';
              if ($product_type == "harvest") {
                $image_path = "{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}";
              }else{
                $image_path = "{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}";
              }
            ?>

            <!-- ✅ Product Image -->
            <div class="me-3">
              <img 
                src="<?php echo $image_path; ?>" 
                alt="Product Image" 
                class="border rounded"
                style="width:80px; height:80px; object-fit:cover;">
            </div>

            <!-- ✅ Product Details -->
            <div class="flex-grow-1 p-3 shadow-sm rounded-3 
                <?php echo ($product_type=='harvest') ? 'border border-success' : 'border border-warning'; ?>">

                <h5 class="fw-bold mb-2 text-capitalize d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($product->product_name); ?>
                    <?php if ($product_type == "harvest"): ?>
                        <span class="badge bg-success">Harvest</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Pre-Order</span>
                    <?php endif; ?>
                </h5>

                <div class="mt-2 mb-2">
                    <label class="fw-semibold small text-muted mb-1 d-block">Quantity:</label>
                    <div class="input-group input-group-sm" style="max-width: 140px;">
                        <button type="button" class="btn btn-outline-secondary btn-sm decrease-qty rounded-start">−</button>
                        <input 
                              type="number" 
                              class="form-control text-center quantity-input border-start-0 border-end-0" 
                              name="quantity[<?php echo $row['product_id']; ?>]" 
                              value="<?php echo $row['quantity']; ?>" 
                              min="1"
                              max="<?php echo $stocks; ?>"
                              data-id="<?php echo $row['product_id']; ?>">
                        <button type="button" class="btn btn-outline-secondary btn-sm increase-qty rounded-end">+</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>Unit Price: <span class="fw-bold">₱<?php echo number_format($unit_price, 2); ?></span></div>
                    <div>Total: <span class="fw-bold text-success">₱<?php echo number_format($total_price, 2); ?></span></div>
                </div>
            </div>
              <div>
                <button class="btn btn-danger ms-2 delete_cart_item" data-id="<?php echo $row['id']; ?>">
                    <i class="bi bi-x-lg"></i>
                </button>
              </div>
          </div>

          <!-- ✅ Hidde xn Inputs -->
          <input type="hidden" name="farmer_id[<?php echo $row['product_id']; ?>]" value="<?php echo $product->user_id; ?>">
          <input type="hidden" name="quantity[<?php echo $row['product_id']; ?>]" value="<?php echo $row['quantity']; ?>">
          <input type="hidden" name="unit_price[<?php echo $row['product_id']; ?>]" value="<?php echo $unit_price; ?>">
          <input type="hidden" name="product_type[<?php echo $row['product_id']; ?>]" value="<?php echo $product_type; ?>">
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

          <!-- Cash on Pick-Up -->
          <input type="radio" class="btn-check" name="payment_method" id="COP" value="COP" autocomplete="off" required>
          <label class="btn btn-outline-success w-100 mb-2" for="COP">
            <i class="bi bi-box-seam"></i> Cash on Pick-Up
          </label>

          <!-- Cash on Delivery -->
          <input type="radio" class="btn-check" name="payment_method" id="COD" value="COD" autocomplete="off" >
          <label class="btn btn-outline-warning w-100 mb-2" for="COD">
            <i class="bi bi-truck"></i> Cash on Delivery
          </label>

          </div>

          <!-- ✅ Submit Button -->
           <!-- check if the consumer address is set -->
          <?php
            if (empty($complete_address)) {
              echo "<button type='' id='placeorderbtn' class='btn btn-success w-100 mt-3' disabled>Place Order</button>";
            }else{
              echo "<button type='submit' id='placeorderbtn' class='btn btn-success w-100 mt-3' >Place Order</button>";
            }
            
          ?>
          
        </div>
      </div>

    </div>
  </div>

  <!-- ✅ Hidden container for dynamic JS data -->
  <div id="selectedProductsContainer"></div>
</form>




<?php 
include_once "../layout/layout_foot.php"; ?>

<script>
document.addEventListener("click", function(e) {
    if (e.target.closest(".delete-cart-item")) {
        const btn = e.target.closest(".delete-cart-item");
        const id = btn.dataset.id;
        const card = btn.closest(".card");

        fetch("delete_cart_item.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`
        })
        .then(res => res.text())
        .then(res => {
            if (res.trim() === "success") {
                card.remove();
            } else {
                alert("Failed to delete");
            }
        })
        .catch(err => console.error(err));
    }
});



</script>