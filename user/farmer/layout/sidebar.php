<?php $page = basename($_SERVER['PHP_SELF']); ?>

<!-- Sidebar for large screens -->
<div class="d-none d-xl-block col-xl-2 col-md-3 bg-dark min-vh-100 p-0 w-5">
  <nav class="nav flex-column">
    <!-- Logo -->
    <div class="navbar bg-dark border-bottom border-white mb-3 d-flex justify-content-center p-3">
      <a class="navbar-brand d-flex flex-column align-items-center w-100" href="#">
        <img src="<?= $base_url ?>libs/images/logo.png" alt="Logo" class="rounded-circle" width="100" height="100">
      </a>
    </div>

    <!-- Sidebar Menu -->
    <a href="<?= $base_url ?>user/farmer/index.php" class="sidebar-btn <?= $page=='index.php' ? 'active' : '' ?>">
      <i class="bi bi-grid me-2"></i> Home
    </a>

    <?php if($_SESSION['is_farm_registered'] == "1") { ?>

    <!-- Harvest Collapsible -->
    <button class="sidebar-btn d-flex justify-content-between align-items-center <?= in_array($page, ['farm_resource.php']) ? 'active' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHarvest">
      <div><i class="bi bi-tools me-2"></i> Dashboard</div>
      <i class="bi <?= in_array($page, ['farm_resource.php']) ? 'bi-caret-down-fill' : 'bi-caret-up-fill' ?> caret-icon"></i>
    </button>
    <div class="collapse ps-3 mt-3 <?= in_array($page, ['farm_resource.php', 'search.php', 'activities.php', 'edit_activities.php' ]) ? 'show' : '' ?>" id="collapseHarvest">
      <a href="<?= $base_url ?>user/farmer/farm/farm_resource.php" class="sidebar-btn <?= ($page=='farm_resource.php' || $page=='search.php' || $page=='activities.php' || $page='Edit Activities') ? 'active' : '' ?>">
        <i class="bi bi-box-seam me-2"></i> Farm Inputs
      </a>
    </div>

    <!-- Inventory Collapsible -->
    <button class="sidebar-btn d-flex justify-content-between align-items-center <?= in_array($page, ['manage_product.php','manage_harvest.php','manage_crop.php']) ? 'active' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInventory">
      <div><i class="bi bi-box-seam me-2"></i> Inventory</div>
      <i class="bi <?= in_array($page, ['manage_product.php','manage_harvest.php','manage_crop.php','search.php']) ? 'bi-caret-down-fill' : 'bi-caret-up-fill' ?> caret-icon"></i>
    </button>
    <div class="collapse ps-3 mt-3 <?= in_array($page, ['manage_product.php','manage_harvest.php','manage_crop.php','search.php']) ? 'show' : '' ?>" id="collapseInventory">
      <a href="<?= $base_url ?>user/farmer/management/manage_crop.php" class="sidebar-btn <?= $page=='manage_crop.php' ? 'active' : '' ?>"><i class="bi bi-tree me-2"></i> Crops</a>
      <a href="<?= $base_url ?>user/farmer/management/manage_harvest.php" class="sidebar-btn <?= $page=='manage_harvest.php' ? 'active' : '' ?>"><i class="bi bi-tree me-2"></i> Harvested</a>
      <a href="<?= $base_url ?>user/farmer/management/manage_product.php" class="sidebar-btn <?= ($page=='manage_product.php' || $page=='search.php') ? 'active' : '' ?>"><i class="bi bi-box-fill me-2"></i> Products</a>
    </div>

    <a href="<?= $base_url ?>user/farmer/order/order.php" class="sidebar-btn <?= $page=='order.php' || $page=='process_order.php' ? 'active' : '' ?>"><i class="bi bi-archive me-2"></i> Orders</a>
    <!-- messaging feature -->
    <a href="<?= $base_url ?>user/farmer/message/message.php" 
    class="sidebar-btn <?= $page=='message.php' ? 'active' : '' ?>">
    <i class="bi bi-envelope me-2"></i> Messages
    </a>

    <!-- messaging feature -->
    <a href="<?= $base_url ?>user/farmer/review/feedback.php" 
    class="sidebar-btn <?= $page=='message.php' ? 'active' : '' ?>">
    <i class="bi bi-chat-dots me-2"></i> Feedback
    </a>

    <?php } ?>
  </nav>
</div>

<!-- Offcanvas Sidebar for mobile -->
<div class="offcanvas offcanvas-start d-xl-none bg-dark" tabindex="-1" id="sidebarMobile">
  <div class="offcanvas-header">

    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body p-0">
      <nav class="nav flex-column">
    <!-- Logo -->
    <div class="navbar bg-dark border-bottom border-white mb-3 d-flex justify-content-center p-3">
      <a class="navbar-brand d-flex flex-column align-items-center w-100" href="#">
        <img src="<?= $base_url ?>libs/images/logo.png" alt="Logo" class="rounded-circle" width="100" height="100">
      </a>
    </div>

    <!-- Sidebar Menu -->
    <a href="<?= $base_url ?>user/farmer/index.php" class="sidebar-btn <?= $page=='index.php' ? 'active' : '' ?>">
      <i class="bi bi-grid me-2"></i> Home
    </a>

    <?php if($_SESSION['is_farm_registered'] == "1") { ?>

    <!-- Harvest Collapsible -->
    <button class="sidebar-btn d-flex justify-content-between align-items-center <?= in_array($page, ['farm_resource.php']) ? 'active' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHarvest">
      <div><i class="bi bi-tools me-2"></i> Dashboard</div>
      <i class="bi <?= in_array($page, ['farm_resource.php']) ? 'bi-caret-down-fill' : 'bi-caret-up-fill' ?> caret-icon"></i>
    </button>
    <div class="collapse ps-3 mt-3 <?= in_array($page, ['farm_resource.php', 'search.php']) ? 'show' : '' ?>" id="collapseHarvest">
      <a href="<?= $base_url ?>user/farmer/farm/farm_resource.php" class="sidebar-btn <?= ($page=='farm_resource.php' || $page=='search.php') ? 'active' : '' ?>">
        <i class="bi bi-box-seam me-2"></i> Farm Inputs
      </a>
    </div>

    <!-- Inventory Collapsible -->
    <button class="sidebar-btn d-flex justify-content-between align-items-center <?= in_array($page, ['manage_product.php','manage_harvest.php','manage_crop.php']) ? 'active' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInventory">
      <div><i class="bi bi-box-seam me-2"></i> Inventory</div>
      <i class="bi <?= in_array($page, ['manage_product.php','manage_harvest.php','manage_crop.php','search.php']) ? 'bi-caret-down-fill' : 'bi-caret-up-fill' ?> caret-icon"></i>
    </button>
    <div class="collapse ps-3 mt-3 <?= in_array($page, ['manage_product.php','manage_harvest.php','manage_crop.php','search.php']) ? 'show' : '' ?>" id="collapseInventory">
      <a href="<?= $base_url ?>user/farmer/management/manage_crop.php" class="sidebar-btn <?= $page=='manage_crop.php' ? 'active' : '' ?>"><i class="bi bi-tree me-2"></i> Crops</a>
      <a href="<?= $base_url ?>user/farmer/management/manage_harvest.php" class="sidebar-btn <?= $page=='manage_harvest.php' ? 'active' : '' ?>"><i class="bi bi-tree me-2"></i> Harvested</a>
      <a href="<?= $base_url ?>user/farmer/management/manage_product.php" class="sidebar-btn <?= ($page=='manage_product.php' || $page=='search.php') ? 'active' : '' ?>"><i class="bi bi-box-fill me-2"></i> Products</a>
    </div>

    <a href="<?= $base_url ?>user/farmer/order/order.php" class="sidebar-btn <?= $page=='order.php' || $page=='process_order.php' ? 'active' : '' ?>"><i class="bi bi-archive me-2"></i> Orders</a>

    <?php } ?>
  </nav>
  </div>
</div>

<!-- Toggle button for mobile -->


<!-- Sidebar CSS -->
<style>
.sidebar-btn {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 0.75rem 1rem;
  color: #fff;
  background-color: transparent;
  border: none;
  gap: 0.5rem;
  text-decoration: none;
  transition: background 0.2s;
}
.sidebar-btn:hover {
  background-color: rgba(255,255,255,0.1);
}
.sidebar-btn.active {
  background-color: #198754;
}
.caret-icon {
  transition: transform 0.3s;
}
#collapseHarvest .sidebar-btn,
#collapseInventory .sidebar-btn {
  padding-left: 2rem;
}
</style>

<!-- Sidebar JS for caret toggles -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const collapsibles = ['collapseHarvest','collapseInventory'];
  collapsibles.forEach(id => {
    const el = document.getElementById(id);
    const caret = el.previousElementSibling.querySelector('.caret-icon');
    if(el.classList.contains('show')) caret.classList.replace('bi-caret-up-fill','bi-caret-down-fill');
    el.addEventListener('show.bs.collapse', () => caret.classList.replace('bi-caret-up-fill','bi-caret-down-fill'));
    el.addEventListener('hide.bs.collapse', () => caret.classList.replace('bi-caret-down-fill','bi-caret-up-fill'));
  });
});
</script>
