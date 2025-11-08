<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 shadow-sm mb-3">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_url; ?>index.php">
      <img src="<?php echo $base_url; ?>libs/images/logo.png" alt="Harvest Hub Logo" class="me-2" style="width:40px;height:40px;">
      <span class="fw-bold">Harvest Hub</span>
    </a>

    <!-- Mobile Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Items -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Optional: Hide search until ready -->
      <!-- <form class="d-flex ms-auto me-3">
        <input class="form-control me-2" type="search" placeholder="Search products" disabled>
        <button class="btn btn-outline-success" type="submit" disabled>Search</button>
      </form> -->
      <div class="ms-auto d-flex align-items-center gap-3">
        <?php if (isset($_SESSION['logged_in'])): ?>
          <!-- Cart -->
          <a class="nav-link position-relative" href="<?php echo $base_url; ?>user/consumer/order/cart.php">
            <i class="bi bi-cart-fill fs-5"></i>
            <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
          </a>

          <!-- User Dropdown -->
          <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
              <img src="<?php echo $_SESSION['profile_pic'] ?? $base_url.'libs/images/logo.png'; ?>" alt="Avatar" class="rounded-circle me-2" style="width:30px;height:30px;object-fit:cover;">
              <span><?php echo $_SESSION['firstname']; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?php echo $base_url; ?>user/consumer/profile/profile.php">Profile</a></li>
              <li><a class="dropdown-item" href="<?php echo $base_url; ?>logout.php">Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <!-- Sign In / Sign Up -->
          <a class="btn btn-outline-success" href="<?php echo $home_url; ?>signin.php?action=add_to_cart">Sign In</a>
          <a class="btn btn-success" href="<?php echo $home_url; ?>signup.php">Sign Up</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
