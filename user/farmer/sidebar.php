<?php $page = basename($_SERVER['PHP_SELF']); ?>

<div class="col-2 col-sm-3 col-xl-2 bg-dark">
  <nav class="navbar bg-dark border-bottom border-white mb-3" data-bs-theme="dark">
    <a class="navbar-brand d-flex flex-column align-items-center w-100" href="#">
      <img src="../../libs/images/logo.png" alt="Harvest Hub" height="100" width="100" class="rounded-circle mb-2">
    </a>
  </nav>

  <nav class="nav flex-column">

    <a class="btn btn-outline-success text-white mb-3 d-flex align-items-center gap-2 <?= $page == 'index.php' ? 'active bg-success' : '' ?>" href="index.php">
      <i class="bi bi-grid"></i> <span>Dashboard</span>
    </a>

    <a class="btn btn-outline-success text-white mb-3 d-flex align-items-center gap-2 <?= $page == 'manage_product.php' ? 'active bg-success' : '' ?>" href="manage_product.php">
      <i class="bi bi-box"></i> <span>Manage Products</span>
    </a>

    <a class="btn btn-outline-success text-white mb-3 d-flex align-items-center gap-2 <?= $page == 'manage_harvest.php' ? 'active bg-success' : '' ?>" href="manage_harvest.php">
      <i class="bi bi-book"></i> <span>Manage Harvest</span>
    </a>

    <a class="btn btn-outline-success text-white mb-3 d-flex align-items-center gap-2 <?= $page == 'orders.php' ? 'active bg-success' : '' ?>" href="orders.php">
      <i class="bi bi-archive"></i> <span>Orders</span>
    </a>

    <a class="btn btn-outline-success text-white mb-3 d-flex align-items-center gap-2 <?= $page == 'feedback.php' ? 'active bg-success' : '' ?>" href="feedback.php">
      <i class="bi bi-chat-left"></i> <span>Feedback</span>
    </a>

    <a class="btn btn-outline-success text-white mb-3 d-flex align-items-center gap-2 <?= $page == 'help.php' ? 'active bg-success' : '' ?>" href="help.php">
      <i class="bi bi-question-circle"></i> <span>Help & Support</span>
    </a>

    <a class="btn btn-outline-success text-white mb-3 d-flex align-items-center gap-2 <?= $page == 'farmers.php' ? 'active bg-success' : '' ?>" href="farmers.php">
      <i class="bi bi-person"></i> <span>Farmers</span>
    </a>

  </nav>
</div>
