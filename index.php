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

$msp_stmt = $product->getMostSoldProduct(6);
$msp_num = $msp_stmt->rowCount();


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

    <div class="most-sold-banner my-4 p-3 rounded-3 bg-light shadow-sm">
    <h5 class="mb-3">🔥 Most Sold Products</h5>

    <div id="mostSoldCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">

            <?php
            if ($msp_num > 0) {
                $count = 0; // counter for products per slide
                $active = "active"; // first slide is active
                echo '<div class="carousel-item ' . $active . '"><div class="d-flex justify-content-center gap-3">';
                
                while ($msp_row = $msp_stmt->fetch(PDO::FETCH_ASSOC)) {

                    $raw_image = $msp_row['product_image'];
                    $img_owner = $msp_row['user_id'];
                    $image_path = "";

                    if ($msp_row['product_type'] == "harvest") {
                       $image_path = "{$base_url}user/uploads/{$img_owner}/products/{$raw_image}";
                    }else{
                        $image_path = "{$base_url}user/uploads/{$img_owner}/posted_crops/{$raw_image}";
                    }

                    
                    $url = "";
                    if ($msp_row['product_type'] == "harvest") {
                        $url = "product/product_detail.php?pid={$msp_row['product_id']}";
                    }else{
                         $url = "product/preorder.php?pid={$msp_row['product_id']}";
                    }

                    // Display product card
                    echo '<div class="text-center border rounded" style="width:140px; flex-shrink:0;">';
                    echo "<a href='{$url}'>
                    <img src='{$image_path}' class='img-fluid mb-2' style='height:100px; object-fit:cover;'></a>";
                    echo '<p class="mb-0 small">' . $msp_row['product_name'] . '</p>';
                    echo '<p class="mb-1 small text-success">₱' . number_format($msp_row['price_per_unit'], 2) . '</p>';
                    echo '<p class="mb-0 small text-muted"><i class="bi bi-cart"></i> ' . $msp_row['sold_count'] . ' sold</p>';
                    $rating = $msp_row['avg_rating']; // e.g., 4.2

                    // Calculate full, half, and empty stars
                    $fullStars = floor($rating);
                    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                    $emptyStars = 5 - $fullStars - $halfStar;

                    // Start separate echo for rating
                    echo '<p class="mb-0 small text-warning">';

                    // Full stars
                    for ($i = 0; $i < $fullStars; $i++) {
                        echo '★';
                    }

                    // Half star (optional)
                    if ($halfStar) {
                        echo '☆'; // You can replace with a half star icon if you have one
                    }

                    // Empty stars
                    for ($i = 0; $i < $emptyStars; $i++) {
                        echo '☆';
                    }

                    // Show numeric rating
                    echo " (" . number_format($rating, 1) . ")";
                    echo '</p>';
                    echo '</div>';

                    $count++;

                    // If 3 products are in this slide, close divs and start a new slide
                    if ($count % 3 == 0 && $count < $msp_num) {
                        echo '</div></div>'; // close current slide
                        $active = ""; // only first slide is active
                        echo '<div class="carousel-item ' . $active . '"><div class="d-flex justify-content-center gap-3">';
                    }
                }

                echo '</div></div>'; // close last slide
            } else {
                echo '<p>No products found.</p>';
            }
            ?>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mostSoldCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mostSoldCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
        </button>
    </div>
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
      <button class="btn btn-dark" data-filter="all">All Products</button>
      <button class="btn btn-primary" data-filter="harvest">Harvest Products</button>
      <button class="btn btn-warning" data-filter="preorder">Pre-Order Products</button>
        <select class="form-select w-auto" id="sortPrice">
            <option value="" hidden>Sort by Price</option>
            <option value="asc">Low to High</option>
            <option value="desc">High to Low</option>
        </select>
  </div>
  <!-- ⭐ END OF ADDED BUTTONS -->

<div id="productContainer" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
<?php
if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product_type = $row['product_type'];
        
        ?>
        <div class="col product-item mb-4" data-type="<?= $product_type ?>"  data-price="<?= $price_per_unit ?>" >
            <div class="card product-card h-100 shadow-sm">
                
                <!-- Image with Pre-Order badge if needed -->
                <div class="position-relative">
                    <?php
                    $path = "user/uploads/{$user_id}/products/{$product_image}";
                    $crops_path = "user/uploads/{$user_id}/posted_crops/{$product_image}";
                    $default = "libs/images/logo.png";

                    if (!empty($product_image) && file_exists($path)) {
                        $image = $path;
                    } elseif (!empty($product_image) && file_exists($crops_path)) {
                        $image = $crops_path;
                    } else {
                        $image = $default;
                    }
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
                            <a class="btn btn-success w-100 mt-auto" href="<?= $home_url ?>product/product_detail.php?pid=<?= $product_id ?>&page=1">
                                Add to Cart
                            </a>
                        <?php else: ?>
                            <a class="btn btn-warning w-100 mt-2 mt-auto" href="<?= $home_url ?>product/preorder.php?pid=<?= $product_id ?>&page=1">
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
    const filterButtons = document.querySelectorAll('.d-flex button[data-filter]');
    const sortSelect = document.getElementById('sortPrice');
    const container = document.getElementById('productContainer');

    function filterAndSort() {
        const filter = document.querySelector('.d-flex button.active')?.dataset.filter || 'all';
        const sort = sortSelect.value;

        let items = Array.from(container.querySelectorAll('.product-item'));

        // Filter
        items.forEach(item => {
            item.style.display = (filter === 'all' || item.dataset.type === filter) ? 'block' : 'none';
        });

        // Sort visible items
        if(sort) {
            items.sort((a, b) => {
                const priceA = parseFloat(a.dataset.price) || 0;
                const priceB = parseFloat(b.dataset.price) || 0;
                return sort === 'asc' ? priceA - priceB : priceB - priceA;
            });
            items.forEach(item => {
                if(item.style.display !== 'none') container.appendChild(item);
            });
        }
    }

    // Filter button click
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterAndSort();
        });
    });

    // Sort dropdown change
    sortSelect.addEventListener('change', filterAndSort);

    // Initial filter & sort
    filterAndSort();
});


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
