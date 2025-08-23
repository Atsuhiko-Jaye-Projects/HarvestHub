<?php $page = basename($_SERVER['PHP_SELF']); ?>

<div class="col-2 col-sm-3 col-xl-2 bg-dark vh-100 p-0">

  <!-- Logo -->
  <nav class="navbar bg-dark border-bottom border-white mb-3 d-flex justify-content-center p-3">
    <a class="navbar-brand d-flex flex-column align-items-center w-100" href="#">
      <?php
        $logo_path = ($page_title=="Edit Product") ? '../../../libs/images/logo.png' : '../../../../../libs/images/logo.png';
        echo "<img src='$base_url/libs/images/logo.png' alt='User Avatar' class='rounded-circle' width='100' height='100'>";
      ?>
    </a>
  </nav>

  <!-- Sidebar Menu -->
  <nav class="nav flex-column">

    <!-- Dashboard -->
    <a href="<?php echo $base_url; ?>user/farmer/index.php" class="sidebar-btn <?= $page=='index.php' ? 'active' : '' ?>">
      <i class="bi bi-grid me-2"></i>
      <span>Home</span>
    </a>

    <!-- Harvest Record Collapsible -->
    <button class="sidebar-btn d-flex justify-content-between align-items-center <?= 
        in_array($page, ['farm_input.php','manage_harvest.php']) ? 'active' : '' ?>" 
        type="button" data-bs-toggle="collapse" data-bs-target="#collapseHarvest" aria-expanded="false" aria-controls="collapseHarvest">
      <div><i class="bi bi-tools me-2"></i> Dashboard</div>
      <i class="bi <?= in_array($page, ['farm_input.php','manage_harvest.php']) ? 'bi-caret-down-fill' : 'bi-caret-up-fill' ?> caret-icon"></i>
    </button>
    <div class="collapse ps-3 <?= in_array($page, ['farm_resource.php','manage_harvest.php']) ? 'show' : '' ?>" id="collapseHarvest">
      <a href="<?php echo $base_url?>user/farmer/farm/farm_resource.php" class="sidebar-btn <?= $page=='farm_resource.php' ? 'active' : '' ?>">
        <i class="bi bi-box-seam me-2"></i> Farm Inputs
      </a>
      <a href="<?php echo $base_url; ?>user/farmer/management/manage_harvest.php" class="sidebar-btn <?= $page=='manage_harvest.php' ? 'active' : '' ?>">
        <i class="bi bi-tree me-2"></i> Harvest
      </a>
    </div>

    <!-- Inventory Collapsible -->
    <button class="sidebar-btn d-flex justify-content-between align-items-center <?= 
        in_array($page, ['inventory.php','planted_crops.php']) ? 'active' : '' ?>" 
        type="button" data-bs-toggle="collapse" data-bs-target="#collapseInventory" aria-expanded="false" aria-controls="collapseInventory">
      <div><i class="bi bi-box-seam me-2"></i> Inventory</div>
      <i class="bi <?= in_array($page, ['inventory.php','planted_crops.php']) ? 'bi-caret-down-fill' : 'bi-caret-up-fill' ?> caret-icon"></i>
    </button>

    <div class="collapse ps-3 <?= in_array($page, ['manage_product.php','search.php']) ? 'show' : '' ?>" id="collapseInventory">
      <a href="<?php echo $base_url; ?>user/farmer/management/manage_product.php" class="sidebar-btn <?= ($page == 'manage_product.php' || $page == 'search.php') ? 'active' : '' ?>">
        <i class="bi bi-box-fill me-2"></i> Products
      </a>

    </div>

    <!-- Orders -->
    <a href="<?php echo $base_url;?>/user/farmer/order/order.php" class="sidebar-btn <?= $page=='order.php' ? 'active' : '' ?>">
      <i class="bi bi-archive me-2"></i>
      <span>Orders</span>
    </a>

    <!-- Feedback -->
    <a href="<?php echo $base_url;?>user/farmer/review/feedback.php" class="sidebar-btn <?= $page=='feedback.php' ? 'active' : '' ?>">
      <i class="bi bi-chat-left me-2"></i>
      <span>Feedback</span>
    </a>

    <!-- Help & Support -->
    <!-- <a href="help.php" class="sidebar-btn <?= $page=='help.php' ? 'active' : '' ?>">
      <i class="bi bi-question-circle me-2"></i>
      <span>Help & Support</span>
    </a> -->

    <!-- Farmers -->
    <!-- <a href="farmers.php" class="sidebar-btn <?= $page=='farmers.php' ? 'active' : '' ?>">
      <i class="bi bi-person me-2"></i>
      <span>Farmers</span>
    </a> -->

  </nav>
</div>

<!-- Custom CSS -->
<style>
  .sidebar-btn {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 0.75rem 1rem;
    color: #fff;
    background-color: transparent;
    border: none;
    border-radius: 0;
    text-align: left;
    gap: 0.5rem;
    transition: background 0.2s;
    text-decoration: none;
  }
  .sidebar-btn:hover {
    background-color: rgba(255,255,255,0.1);
    text-decoration: none;
  }
  .sidebar-btn.active {
    background-color: #198754;
    color: #fff;
  }
  #collapseHarvest .sidebar-btn,
  #collapseInventory .sidebar-btn {
    padding-left: 2rem;
  }
  .caret-icon {
    transition: transform 0.3s;
  }
</style>

<!-- JS for caret toggle -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Harvest Record caret
    const collapseHarvest = document.getElementById('collapseHarvest');
    const caretHarvest = collapseHarvest.previousElementSibling.querySelector('.caret-icon');

    if (collapseHarvest.classList.contains('show')) {
      caretHarvest.classList.replace('bi-caret-up-fill','bi-caret-down-fill');
    }
    collapseHarvest.addEventListener('show.bs.collapse', () => caretHarvest.classList.replace('bi-caret-up-fill','bi-caret-down-fill'));
    collapseHarvest.addEventListener('hide.bs.collapse', () => caretHarvest.classList.replace('bi-caret-down-fill','bi-caret-up-fill'));

    // Inventory caret
    const collapseInventory = document.getElementById('collapseInventory');
    const caretInventory = collapseInventory.previousElementSibling.querySelector('.caret-icon');

    if (collapseInventory.classList.contains('show')) {
      caretInventory.classList.replace('bi-caret-up-fill','bi-caret-down-fill');
    }
    collapseInventory.addEventListener('show.bs.collapse', () => caretInventory.classList.replace('bi-caret-up-fill','bi-caret-down-fill'));
    collapseInventory.addEventListener('hide.bs.collapse', () => caretInventory.classList.replace('bi-caret-down-fill','bi-caret-up-fill'));
  });
</script>
