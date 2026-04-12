<?php 

$product_id = isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: missing ID.');
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/product.php";
include_once "../objects/cart_item.php";

$page_title = "HarvestHUB";
include_once "layout_head.php";

$require_login=true;
include_once "../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$cart_item = new CartItem($db);


// ✅ User is logged in
$product->id = $product_id;
$product->readOne();

$cart_item->user_id = $_SESSION['user_id'];
$cart_item_count = $cart_item->countItem();


if ($_POST) {

    $cart_item->product_id = $_POST['product_id'];
    $cart_item->user_id = $_SESSION['user_id'];
    $cart_item->quantity = $_POST['quantity'];
    $cart_item->farmer_id = $_POST['farmer_id'];
    $cart_item->amount = $_POST['amount'];
    $cart_item->status = "Pending";
    $cart_item->unit = $_POST['unit'];
    $cart_item->product_type = "preorder";

  
  if ($cart_item->PreOrderitemExist()) {
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                  icon: 'warning',
                  title: 'Product already in the Cart',
                  text: 'This item is already in your cart.',
                  showConfirmButton: true,
                  confirmButtonText: 'OK'
              });
            </script>
            ";
  } else {
      if ($cart_item->addItem()) {
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Added to Cart',
                  text: 'Item has been added successfully!',
                  showConfirmButton: true,
                  confirmButtonText: 'OK'
              });
            </script>
            ";
      } else {
          echo "Failed to add product. Please try again later.";
      }
  }
}
?>

<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div id="loadingSpinner" class="modern-loader"></div>
      <div id="checkIcon" class="check-icon">
        <i class="bi bi-check-circle-fill"></i>
      </div>
      <p id="statusText" class="status-text">Adding to cart...</p>
    </div>
  </div>
</div>




<div class="container py-5">
  
  <?php include_once "../layout/navigation.php" ; ?>
  <!-- Product Section -->
  <div class="row g-5 align-items-start">
    <!-- Left: Image -->
    <div class="col-md-5">
    <?php echo "<img src='{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}' class='img-fluid rounded' alt='Petsay'>";?>

      <div class="d-flex gap-2 mt-3 thumbs">
        <?php
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}'>";
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}'>";
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}'>";
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/posted_crops/{$product->product_image}'>";
            // <img src="https://via.placeholder.com/100" alt="">
            // <img src="https://via.placeholder.com/100" alt="">
            // <img src="https://via.placeholder.com/100" alt="">
        ?>
      </div>
    </div>

    <!-- Right: Details -->
    <div class="col-md-7">
      <p class="text-muted mb-1"><?php echo $product->category; ?></p>
      <h2><?php echo $product->product_name; ?></h2>
      <p class="price-range"><?php echo "₱{$product->price_per_unit}";?></p>

      <div class="d-flex align-items-center mb-3">
        <span class="me-3 text-muted"><?php echo $product->sold_count; ?> Sold</span>
        <div class="rating">
            <?php
            $rating = $product->avg_rating; // example: 4.5

            $fullStars = floor($rating);
            $halfStar  = ($rating - $fullStars) >= 0.5 ? 1 : 0;
            $emptyStars = 5 - $fullStars - $halfStar;

            // full stars
            for ($i = 0; $i < $fullStars; $i++) {
                echo '<i class="bi bi-star-fill"></i>';
            }

            // half star
            if ($halfStar) {
                echo '<i class="bi bi-star-half"></i>';
            }

            // empty stars
            for ($i = 0; $i < $emptyStars; $i++) {
                echo '<i class="bi bi-star"></i>';
            }
            ?>
            <span class="ms-2"><?= number_format($rating, 1) ?></span>
        </div>
      </div>

      <h6>Description:</h6>
      <p class="text-secondary">
        <?php echo $product->product_description; ?>
      </p>
      <h6>EST Available Stocks (KG):</h6>
      <p class="text-primary fw-bold">
        <?php echo number_format($product->safe_harvest); ?> KG
      </p>

      <p style="font-size:0.85em; color:red; margin-top:4px;">
          *Disclaimer: Pre-order item. Price and availability may change.
      </p>

      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST' id="cartForm">
        <div class="mb-3">
          <label class="form-label">Select Kilos:</label><br>
          <div class="btn-group" role="group" aria-label="Select Kilos">
            <input type="text" name="product_id" hidden value="<?php echo $product->id; ?>">
            <input type="text" name="amount" hidden value="<?php echo $product->price_per_unit; ?>">
            <input type="text" id="available_stocks" hidden value="<?php echo $product->safe_harvest; ?>">

            <input type="radio" class="btn-check" name="unit" id="unitPiece" value="piece" checked>
            <!-- <label class="btn btn-outline-secondary" for="unitPiece">Per Piece</label> -->

            <input type="radio" class="btn-check" name="unit" id="unitGram" value="gram" checked>
            <label class="btn btn-outline-secondary" for="unitGram">Per Gram</label>

            <input type="radio" class="btn-check" name="unit" id="unitKg" value="kg">
            <label class="btn btn-outline-secondary" for="unitKg">Per KG</label>
          </div>
        </div>

        <div class="mt-3 col-md-4" id="quantityContainer">
            <label id="quantityLabel" class="form-label">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
            <small id="helperText" class="text-muted"></small>
        </div>

        <div class="d-flex gap-3">
          <button type="submit" id="addToCartBtn" class="btn btn-warning px-4">Pre-Order</button>
          <input type="hidden" class="btn-check" name="farmer_id" value="<?php echo $product->user_id;?>">
          <!-- <button class="btn btn-outline-dark px-4">Checkout Now</button> -->
        </div>
      </div>
    </form>
  </div>

  

  <!-- Related Products -->
  <div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Related Products</h4>
      <a href="#" class="text-success">View All</a>
    </div>

    <div class="row row-cols-2 row-cols-md-4 g-3">
      <div class="col">
        <div class="card h-100 product-card">
          <!-- <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Apple"> -->
          <div class="card-body">
            <h6 class="card-title mb-1">Apple</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 product-card">
          <!-- <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Potato"> -->
          <div class="card-body">
            <h6 class="card-title mb-1">Potato</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 product-card">
          <!-- <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Carrots"> -->
          <div class="card-body">
            <h6 class="card-title mb-1">Carrots</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 product-card">
          <!-- <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Petsay"> -->
          <div class="card-body">
            <h6 class="card-title mb-1">Petsay</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cartModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-5 border-0 shadow">
      <div id="loadingSpinner" class="modern-loader mx-auto mb-3"></div>
      <div id="checkIcon" class="check-icon text-success mb-3" style="display: none;">
        <i class="bi bi-check-circle-fill fs-1"></i>
      </div>
      <p id="statusText" class="status-text fw-semibold">Adding to cart...</p>
    </div>
  </div>
</div>

<?php include_once "layout_foot.php"; ?>

<script>
const AvailableStock = parseFloat(document.getElementById("available_stocks").value);
const MaxGrams = AvailableStock * 1000;
const radios = document.querySelectorAll('input[name="unit"]');
const input = document.getElementById("quantity");
const label = document.getElementById("quantityLabel");
const helper = document.getElementById("helperText");

function updateField(unit) {

    if(unit === "piece") {
        label.innerText = "Number of Pieces";
        input.min = 1;
        input.step = 1;
        input.placeholder = "Enter pieces";
        helper.innerText = "Minimum: 1 piece";

    } else if(unit === "gram") {
        label.innerText = "Grams";
        input.min = 50;
        input.step = 10;
        input.max = MaxGrams;
        input.placeholder = "Enter grams";
        helper.innerText = "Minimum: 50 grams";

    } else if(unit === "kg") {
        label.innerText = "Kilograms";
        input.min = 0.1;
        input.step = 0.1;
        input.max = AvailableStock;
        input.placeholder = "Enter kilograms";
        helper.innerText = "Minimum: 0.1 kg";
    }
}

radios.forEach(radio => {
    radio.addEventListener("change", function() {
        updateField(this.value);
    });
});

// Run on page load (for default checked)
updateField(document.querySelector('input[name="unit"]:checked').value);
</script>