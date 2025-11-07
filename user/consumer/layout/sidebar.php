

<!-- Sidebar -->
<div class="sidebar bg-dark text-white vh-100 d-flex flex-column p-0 shadow-sm position-fixed top-0 start-0" style="width: 250px;">

  <!-- Logo -->
  <div class="text-center py-4 border-bottom border-secondary">
    <a href="<?php echo $base_url;?>index.php" class="text-decoration-none text-white">
      <img src="<?php echo $base_url; ?>libs/images/logo.png" 
           alt="Logo" 
           class="rounded-circle mb-2" 
           width="90" height="90">
      <h6 class="fw-bold mb-0">HarvestHub</h6>
    </a>
  </div>

  <!-- Navigation Menu -->

<nav class="flex-grow-1 py-3 overflow-auto">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="<?php echo $base_url; ?>user/consumer/order/order.php"
         class="nav-link text-white <?= ($page=='order.php' || $page=='order_details.php') ? 'active' : '' ?>">
        <i class="bi bi-basket2-fill me-2"></i> My Purchase
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo $base_url;?>user/consumer/review/feedback.php"
         class="nav-link text-white <?= ($page=='feedback.php') ? 'active' : '' ?>">
        <i class="bi bi-chat-right-text-fill me-2"></i> Your Reviews
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo $base_url;?>user/consumer/support/support.php"
         class="nav-link text-white <?= ($page=='support.php') ? 'active' : '' ?>">
        <i class="bi bi-question-circle-fill me-2"></i> Help & Support
      </a>
    </li>
  </ul>
</nav>


  <!-- Footer -->
  <div class="border-top border-secondary text-center py-3 small bg-white text-muted">
    <i class="bi bi-flower2 text-success"></i> HarvestHub © 2025
  </div>
</div>
