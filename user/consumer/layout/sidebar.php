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
    <!-- Dashboard -->

    <a href="<?php echo $base_url; ?>user/consumer/order/order.php" class="sidebar-btn <?= $page=='order.php' || $page=='order_details.php' ? 'active' : '' ?>">
      <i class="bi bi-grid me-2"></i>
      <span>My Purchase</span>
    </a>

    
    <a href="<?php echo $base_url;?>user/consumer/notification/notification.php" class="sidebar-btn <?= $page=='notification.php' ? 'active' : '' ?>">
      <i class="bi bi-bell"></i>
      <span>Notifications</span>
    </a>

    <a href="<?php echo $base_url;?>user/consumer/review/feedback.php" class="sidebar-btn <?= $page=='feedback.php' ? 'active' : '' ?>">
      <i class="bi bi-chat-right"></i>
      <span>Your Reviews</span>
    </a>

    <a href="<?php echo $base_url;?>user/consumer/support/support.php" class="sidebar-btn <?= $page=='support.php' ? 'active' : '' ?>">
      <i class="bi bi-question-circle"></i>
      <span>Help & Support</span>
    </a>
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
