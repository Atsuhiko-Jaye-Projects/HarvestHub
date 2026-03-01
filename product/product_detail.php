<?php 

$product_id = isset($_GET['pid']) ? $_GET['pid'] : die('ERROR: missing ID.');
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/product.php";
include_once "../objects/cart_item.php";
include_once "../objects/farm.php";
include_once "../objects/review.php";

$page_title = "HarvestHUB";
include_once "layout_head.php";

$require_login=true;
include_once "../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$cart_item = new CartItem($db);
$farm_info = new Farm($db);
$product_review = new Review($db);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$records_per_page = 5;
$from_record_num = ($page - 1) * $records_per_page;


// ✅ User is logged in
$product->id = $product_id;
$product->readOne();

// get the farm performance details
$farm_info->user_id = $product->user_id;
$getFarmInfo = $farm_info->getFarmInfo();

//get the product reviews
$product_review->product_id = $product_id;
$getProductReview = $product_review->ReadAllReview($from_record_num, $records_per_page);
$num = $getProductReview->rowCount();

$raw_image = $farm_info->farm_image;
$farmer_id = $product->user_id;
$logo_path = "{$base_url}user/uploads/{$farmer_id}/farm_logo/{$raw_image}";
$default_logo = "{$base_url}user/uploads/logo.png";

if (empty($raw_image) || !file_exists($img_path)) {
    $logo = $default_logo;
} else {
    $logo = $logo_path;
}

// get how old the farm is
$created = new DateTime($farm_info->created_at);
$now = new DateTime();

$diff = $now->diff($created);

$years = $diff->y;
$months = $diff->m;

$joined_duration = ($years > 0) 
    ? $years . " Year" . ($years > 1 ? "s" : "") . " " .
      $months . " Month" . ($months > 1 ? "s" : "")
    : $months . " Month" . ($months > 1 ? "s" : "");


//convert the follower count
$farm_info->follower_count;

// Format it directly
if ($farm_info->follower_count >= 1000000000) {
    $farm_info->follower_count = round($farm_info->follower_count / 1000000000, 1) . 'B';
} elseif ($farm_info->follower_count >= 1000000) {
    $farm_info->follower_count = round($farm_info->follower_count / 1000000, 1) . 'M';
} elseif ($farm_info->follower_count >= 1000) {
    $farm_info->follower_count = round($farm_info->follower_count / 1000, 1) . 'K';
}

//fetch the product Reviews



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
    $cart_item->product_type = "harvest";
    
    if ($cart_item->itemExist()) {
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



<div class="container py-5">
  
  <?php include_once "../layout/navigation.php" ; ?>
  <!-- Product Section -->
  <div class="row g-5 align-items-start">
    <!-- Left: Image -->
    <div class="col-md-5">
    <?php echo "<img src='{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}' class='img-fluid rounded' alt='Petsay'>";?>

      <div class="d-flex gap-2 mt-3 thumbs">
        <?php
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}'>";
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}'>";
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}'>";
            echo "<img src='{$base_url}user/uploads/{$product->user_id}/products/{$product->product_image}'>";
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
      <p class="price-range"><?php echo "₱{$product->price_per_unit}.00";?></p>

      <div class="d-flex align-items-center mb-3">
        <span class="me-3 text-muted"><?php echo $product->sold_count; ?> KG Sold</span>
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
      <h6>Available Stocks:</h6>
      <p class="text-secondary">
        <?php echo $product->available_stocks; ?> KG
      </p>

      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST' id="cartForm">
        <div class="mb-3">
          <label class="form-label">Select Kilos:</label><br>
          <div class="btn-group" role="group" aria-label="Select Kilos">
            <input type="text" name="product_id" hidden value="<?php echo $product->id; ?>">
            <input type="text" name="amount" hidden value="<?php echo $product->price_per_unit; ?>">
            <input type="text" id="available_stocks" hidden value="<?php echo $product->available_stocks; ?>">

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
          <button type="submit" id="addToCartBtn" class="btn btn-success px-4">Add to Cart</button>
          <input type="hidden" class="btn-check" name="farmer_id" value="<?php echo $product->user_id;?>">
          <!-- <button class="btn btn-outline-dark px-4">Checkout Now</button> -->
        </div>
      </div>
    </form>
  </div>

<!-- shop information -->
<?php include_once "shop_info.php";?>

<!-- Ratings -->
<?php include_once "product_ratings.php"; ?>

<!-- related products -->
<?php include_once "related_product.php"; ?>
  



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