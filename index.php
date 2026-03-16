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

$page_title = "Home | Harvest Hub";
include_once "layout_head.php";

$page_url = "{$home_url}index.php?";
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 16; 
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $product->showAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $product->countAll();

$msp_stmt = $product->getMostSoldProduct(12); 
$msp_num = $msp_stmt->rowCount();

if (isset($_SESSION['logged_in'])) {
    $cart_item->user_id = $_SESSION['user_id'];
    $cart_item_count = $cart_item->countItem();
}
?>

<style>
    :root {
        --harvest-green: #10b981;
        --harvest-soft-green: #ecfdf5;
        --harvest-dark: #1e293b;
        --bg-main: #fcfdfd;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Inter', sans-serif;
    }

    .container-compact { max-width: 1200px; margin: 0 auto; padding: 0 15px; }

    /* 🏷️ CATEGORY NAVIGATION DIV */
    .category-nav-wrapper {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 10px 5px;
        margin-bottom: 25px;
        scrollbar-width: none; /* Hide scrollbar Firefox */
    }
    .category-nav-wrapper::-webkit-scrollbar { display: none; } /* Hide scrollbar Chrome */

    .cat-item {
        background: white;
        border: 1px solid #f1f5f9;
        padding: 8px 20px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none !important;
        color: var(--harvest-dark);
        font-weight: 600;
        font-size: 0.85rem;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .cat-item i { font-size: 1.1rem; }
    .cat-item.active {
        background: var(--harvest-green);
        color: white;
        border-color: var(--harvest-green);
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }
    .cat-item:hover:not(.active) {
        background: var(--harvest-soft-green);
        border-color: var(--harvest-green);
        transform: translateY(-2px);
    }

    /* 🖼️ Hero Banner Slim */
    .hero-slim {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 24px; padding: 35px 50px; color: white;
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 25px;
    }

    /* 📦 Product Card Styles */
    .product-card {
        border: 1px solid #f1f5f9; border-radius: 20px;
        background: white; transition: 0.3s; overflow: hidden;
    }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.05); }
    .card-img-top { height: 160px; object-fit: cover; }

    /* 🎨 Badge Colors */
    .badge-ready { background: #10b981 !important; color: white; }
    .badge-preorder { background: #f59e0b !important; color: white; }

    /* Filter Buttons */
    .filter-btn {
        border: none; background: #f1f5f9; border-radius: 12px;
        padding: 6px 16px; font-size: 0.85rem; font-weight: 700;
        color: #64748b; transition: 0.2s;
    }
    .filter-btn.active { background: var(--harvest-dark); color: white; }
</style>

<div class="container-compact py-4">
    <?php include_once "layout/navigation.php";?>

    <div class="hero-slim shadow-sm">
        <div>
            <h1 class="fw-800">Harvest Hub</h1>
            <p class="opacity-75">Sourcing the best vegetables from Baao farmers.</p>
        </div>
        <img src="libs/images/logo.png" style="width: 85px; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.1));">
    </div>

    <div class="category-nav-wrapper">
        <a href="#" class="cat-item active">
            <i class="bi bi-leaf"></i> Vegetables
        </a>
        <a href="#" class="cat-item opacity-50">
            <i class="bi bi- shop-window"></i> Others (Soon)
        </a>
    </div>

    <div class="mb-5 bg-white p-3 rounded-4 border shadow-xs">
        <div class="d-flex justify-content-between align-items-center mb-3 px-1">
            <h6 class="fw-bold m-0 text-uppercase small tracking-wider text-muted">🔥 Popular Now</h6>
            <div class="d-flex gap-1">
                <button class="btn btn-sm p-0 px-2" data-bs-target="#mspCarousel" data-bs-slide="prev"><i class="bi bi-chevron-left"></i></button>
                <button class="btn btn-sm p-0 px-2" data-bs-target="#mspCarousel" data-bs-slide="next"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>
        <div id="mspCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                if ($msp_num > 0) {
                    $count = 0; $active = "active";
                    echo '<div class="carousel-item ' . $active . '"><div class="row g-2 row-cols-3 row-cols-md-6">';
                    while ($msp_row = $msp_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $img = "user/uploads/{$msp_row['user_id']}/" . ($msp_row['product_type'] == "harvest" ? "products" : "posted_crops") . "/{$msp_row['product_image']}";
                        echo '<div class="col"><div class="text-center p-2 border border-light rounded-3">';
                        echo "<a href='product/product_detail.php?pid={$msp_row['product_id']}' class='text-decoration-none'>
                                <img src='{$img}' class='rounded-3 mb-2 w-100 shadow-xs' style='height: 65px; object-fit: cover;'>
                                <p class='mb-0 small fw-bold text-dark text-truncate'>{$msp_row['product_name']}</p>
                                <span class='text-success small fw-bold'>₱" . number_format($msp_row['price_per_unit'], 2) . "</span>
                            </a></div></div>";
                        $count++;
                        if ($count % 6 == 0 && $count < $msp_num) echo '</div></div><div class="carousel-item"><div class="row g-2 row-cols-3 row-cols-md-6">';
                    }
                    echo '</div></div>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-2 rounded-4 shadow-xs border">
        <div class="d-flex gap-2">
            <button class="filter-btn active" data-filter="all">All Items</button>
            <button class="filter-btn" data-filter="harvest">In-Stock</button>
            <button class="filter-btn" data-filter="preorder">Pre-Order</button>
        </div>
        <div class="d-flex align-items-center gap-2 pe-2">
            <i class="bi bi-sort-down text-muted"></i>
            <select class="form-select form-select-sm border-0 bg-transparent fw-bold" id="sortPrice" style="width: 130px;">
                <option value="">Sort Price</option>
                <option value="asc">Low to High</option>
                <option value="desc">High to Low</option>
            </select>
        </div>
    </div>

    <div id="productContainer" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $img = "user/uploads/{$user_id}/" . ($product_type == "harvest" ? "products" : "posted_crops") . "/{$product_image}";
                ?>
                <div class="col product-item" data-type="<?= $product_type ?>" data-price="<?= $price_per_unit ?>">
                    <div class="card product-card h-100 border-0 shadow-xs">
                        <div class="position-relative">
                            <img src="<?= $img ?>" class="card-img-top">
                            <span class="badge position-absolute top-0 start-0 m-3 rounded-pill px-3 py-1 shadow-sm <?= ($product_type == 'harvest') ? 'badge-ready' : 'badge-preorder' ?>" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                                <?= strtoupper($product_type) ?>
                            </span>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.95rem;"><?= htmlspecialchars($product_name) ?></h6>
                                <?php if(isset($_SESSION['logged_in']) && $_SESSION['user_id'] != $user_id): ?>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-3">
                                <div>
                                    <span class="text-muted d-block small" style="font-size: 0.7rem;">Price per KG</span>
                                    <span class="text-success fw-800 fs-5">₱<?= number_format($price_per_unit, 2) ?></span>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-light text-muted rounded-pill border fw-normal" style="font-size: 0.7rem;"><?= $total_stocks ?>kg left</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="product/<?= ($product_type == 'harvest' ? 'product_detail.php' : 'preorder.php') ?>?pid=<?= $product_id ?>" 
                                   class="btn <?= ($product_type == 'harvest' ? 'btn-success' : 'btn-warning') ?> w-100 btn-sm rounded-pill fw-bold py-2 shadow-xs">
                                    <?= ($product_type == 'harvest' ? 'Buy Now' : 'Reserve') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <div class="mt-5 d-flex justify-content-center">
        <?php include_once "paging.php";?>
    </div>
</div>

<?php include_once "layout_foot.php"; ob_end_flush(); ?>

<script>
// Filter script same as before... (functional)
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sortSelect = document.getElementById('sortPrice');
    const container = document.getElementById('productContainer');

    function filterAndSort() {
        const activeBtn = document.querySelector('.filter-btn.active');
        const filter = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
        const sort = sortSelect.value;
        let items = Array.from(container.querySelectorAll('.product-item'));

        items.forEach(item => {
            const isMatch = (filter === 'all' || item.getAttribute('data-type') === filter);
            item.style.display = isMatch ? 'block' : 'none';
        });

        if(sort) {
            items.sort((a, b) => {
                const pA = parseFloat(a.getAttribute('data-price'));
                const pB = parseFloat(b.getAttribute('data-price'));
                return sort === 'asc' ? pA - pB : pB - pA;
            });
            items.forEach(item => { if(item.style.display !== 'none') container.appendChild(item); });
        }
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterAndSort();
        });
    });
    sortSelect.addEventListener('change', filterAndSort);
});
</script>