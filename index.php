<?php
ob_start();
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

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $product->showAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $product->countAll();

if (!isset($_SESSION['logged_in'])) {

} else {
  $cart_item->user_id = $_SESSION['user_id'];
  $cart_item_count= $cart_item->countItem();
}

?>
<div class="container">
<?php include_once "layout/navigation.php";?>
  <div class="hero-banner">
    <div>
      <h1>Fresh Goods</h1>
      <p>Order Now!</p>
    </div>
    <img src="libs/images/logo.png" alt="Vegetables" class="category-icon mb-2">
  </div>

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

  <!-- ⭐ ADDED ONLY THIS BUTTON GROUP (NO OTHER CHANGE) -->
  <div class="d-flex gap-2 mb-4">
      <button class="btn btn-dark">All Products</button>
      <button class="btn btn-primary">Harvest Products</button>
      <button class="btn btn-warning">Pre-Order Products</button>
  </div>
  <!-- ⭐ END OF ADDED BUTTONS -->

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
<?php
if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product_type = $row['product_type'];
        
        ?>
        <div class="col product-item mb-4" data-type="<?= $product_type ?>">
            <div class="card product-card h-100 shadow-sm">
                
                <!-- Image with Pre-Order badge if needed -->
                <div class="position-relative">
                    <?php
                        
                        $path = "user/uploads/{$user_id}/products/{$product_image}";
                        $default = "libs/images/logo.png";
                        $image = ( !empty($product_image) && file_exists($path) ) ? $path : $default;
                    ?>
                    <img src="<?= $image ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($product_name) ?>" 
                         style="object-fit: cover; height: 180px;">

                    <?php 
                        $discount = ($row['discount'] * 100) * 100;
                        if (!empty($row['discount'])): 
                    ?>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                            <?= $discount ?>% OFF
                        </span>
                    <?php endif; ?>
                    <?php if ($product_type != "harvest") : ?>
                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">Pre-Order</span>
                    <?php endif; ?>
                </div>
                
                <div class="card-body d-flex flex-column">
                    <!-- Product Name -->
                    <h5 class="card-title text-truncate"><?= htmlspecialchars($product_name) ?></h5>
                    
                    <!-- Price -->
                    <p class="card-text text-success fw-bold">₱ <?= number_format($price_per_unit, 2) ?> per KG</p>
                    
                    <!-- Stock and KG info -->
                    <p class="small text-muted mb-1">Available: <?= number_format($row['total_stocks']); ?> KG</p>
                    <!-- <p class="small text-muted mb-2">KG/Plant: <?= $yield ?></p> -->
                    
                    <!-- Action button -->
                    <?php if (empty($_SESSION['logged_in'])): ?>
                        <a href="<?= $home_url ?>signin.php?action=add_to_cart" class="btn btn-info w-100 mt-auto">
                            Sign in to Order
                        </a>
                    <?php else: ?>
                        <?php if ($product_type == "harvest"): ?>
                            <a class="btn btn-success w-100 mt-auto" href="<?= $home_url ?>product/product_detail.php?pid=<?= $product_id ?>">
                                Add to Cart
                            </a>
                        <?php else: ?>
                            <a class="btn btn-warning w-100 mt-2 mt-auto" href="<?= $home_url ?>product/preorder.php?pid=<?= $product_id ?>">
                                Pre-Order
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p class='text-muted'>No products available.</p>";
}
?>

  </div>
  <?php include_once "paging.php";?>
</div>
<?php 
include_once "layout_foot.php";
ob_end_flush();
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.d-flex .btn');
    const items = document.querySelectorAll('.product-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.textContent.toLowerCase().includes('harvest') ? 'harvest' :
                           btn.textContent.toLowerCase().includes('pre-order') ? 'preorder' : 'all';

            items.forEach(item => {
                if(filter === 'all') {
                    item.style.display = 'block';
                } else {
                    if(item.dataset.type === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });
});
</script>
