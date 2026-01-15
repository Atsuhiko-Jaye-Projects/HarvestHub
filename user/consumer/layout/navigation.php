<nav class="navbar navbar-light bg-light shadow-sm sticky-top">
  <div class="container-fluid d-flex align-items-center justify-content-between">


    <div class="d-flex align-items-center">
      <button id="sidebarToggle" class="btn btn-outline-success me-2 d-md-none">
        <i class="bi bi-list fs-5"></i>
      </button>
      
      <!-- Logo -->
      <img src="<?php echo $page_title=="Edit Product" ? '../../../libs/images/logo.png' : $base_url.'libs/images/logo.png'; ?>" 
           alt="HarvestHub Logo" class="rounded-circle me-2" width="40" height="40">

      <!-- Brand -->
      <span class="navbar-brand fw-semibold mb-0 d-none d-sm-inline">HarvestHub</span>
    </div>


    <!-- Right: User Info + Dropdown -->
    <div class="d-flex align-items-center flex-nowrap">
    <?php include_once "notification.php"; ?>

      <!-- User Info -->
      <div class="text-end me-2 d-none d-sm-block">
        <span class="fw-bold d-block"><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></span>
        <small class="text-muted"><?php echo $_SESSION['user_type']; ?></small>
      </div>

      <!-- Dropdown -->
      <div class="dropdown">
        <button class="btn btn-sm btn-light" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-caret-down-fill"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="<?php echo $base_url; ?>user/consumer/profile/profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="../../../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Sidebar toggle script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.querySelector('.sidebar'); // adjust selector to your sidebar class
  const toggleBtn = document.querySelector('#sidebarToggle');

  toggleBtn?.addEventListener('click', () => {
    sidebar.classList.toggle('show');
  });
});
</script>

<style>
/* Ensure navbar and brand text are mobile-friendly */
.navbar-brand {
  font-size: 1.1rem;
}

@media (max-width: 576px) {
  .navbar .text-end {
    display: none; /* hide user info on very small screens */
  }
}
</style>
