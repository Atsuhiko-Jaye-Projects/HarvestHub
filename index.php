<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/product.php";
include_once "objects/cart_item.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$cart_item = new CartItem($db);

$page_title = "Index";
include_once "layout_head.php";


$page_url = "{$home_url}index.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 10;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $product->showAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $product->countAll();

if (!isset($_SESSION['logged_in'])) {
  
}else{
  $cart_item->user_id = $_SESSION['user_id'];
  $cart_item_count= $cart_item->countItem();
}

?>
<div class="container">
<?php include_once "layout/navigation.php";?>
  <!-- Hero Banner -->
  <div class="hero-banner">
    <div>
      <h1>Fresh Goods</h1>
      <p>Order Now!</p>
    </div>
    <img src="libs/images/logo.png" alt="Vegetables" class="category-icon mb-2">
  </div>

  <!-- Categories -->
  <h5>Shop From Top Categories</h5>
  <div class="d-flex gap-4 mb-4">
    <div class="text-center">
      <img src="libs/images/general/vegetables/1.jpg" class="category-icon mb-2">
      <p>Vegetables</p>
    </div>
    <div class="text-center">
      <img src="libs/images/general/fruits/1.jpg" class="category-icon mb-2">
      <p>Fruits</p>
    </div>
    <div class="text-center">
      <img src="libs/images/general/seafoods/1.jpg" class="category-icon mb-2">
      <p>Fish</p>
    </div>
    <div class="text-center">
      <img src="libs/images/general/proteins/1.jpg" class="category-icon mb-2">
      <p>Meat</p>
    </div>
  </div>

  <!-- Products Grid -->
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    <!-- Product Card -->
     <?php
        if ($num>0) {

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
              echo "<div class='col'>";
              echo "<div class='card product-card h-100'>";
                echo "<img src='user/uploads/{$user_id}/products/{$product_image}' class='card-img-top' alt='Vegetables'>";
                echo "<div class='card-body'>";
                  echo "<h6 class='card-title'>{$product_name}</h6>";
                  echo "<p class='card-text'>PHP {$price_per_unit}.00</p>";
                  if (empty($_SESSION['logged_in'])) {
                    echo "<a href='{$home_url}signin.php?action=add_to_cart' class='btn btn-info w-100'>Sign in to Order</a>";
                  }else{

                    echo "<a class='btn btn-success w-100' href='{$home_url}product/product_detail.php?pid={$product_id}'>Add to Cart</a>";

                    // echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="POST">';
                    //   echo "<button type='submit' class='btn btn-success w-100'>Add to Cart</button>";
                    //   echo '<input hidden name="product_id" value="' . htmlspecialchars($product_id) . '">';
                    // echo "</form>";
                  } 
                echo "</div>";
              echo "</div>";
            echo "</div>";
          }
        }else{
        }
     ?>
  </div>
  <?php include_once "paging.php";?>
</div>
<?php 

include_once "layout_foot.php";?>
