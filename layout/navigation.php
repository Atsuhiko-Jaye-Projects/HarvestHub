<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 mb-3">
  <div class="container">
    <img src="<?php echo $base_url; ?>libs/images/logo.png" alt="Vegetables" class="category-icon mb-2">
    <a class="navbar-brand" href="<?php echo $base_url; ?>index.php">Harvest Hub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <form class="d-flex ms-auto me-3">
        <input class="form-control me-2" type="search" placeholder="Search products">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <?php
        if (isset($_SESSION['logged_in'])) {
          echo "<ul class='navbar-nav position-relative'>";
            echo "<li class='nav-item position-relative'>";
              echo "<a class='nav-link' href='{$base_url}user/consumer/order/cart.php'>Cart";
                     echo "<span id='cart-count' class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'></span>";
                    echo"</a>";
            echo "</li>";
            if ($_SESSION['user_type']=='farmer') {
              echo "<li class='nav-item'><a class='nav-link' href='{$home_url}user/farmer/profile/profile.php'>Profile</a></li>";
            }else{
              echo "<li class='nav-item'><a class='nav-link' href='{$home_url}user/consumer/profile/profile.php'>Profile</a></li>";
            }

          echo "</ul>";
        }else{
          echo "<ul class='navbar-nav'>";
            echo "<li class='nav-item'><a class='nav-link' href='{$home_url}signin.php?action=add_to_cart'>Sign In</a></li>";
            echo "<li class='nav-item'><a class='nav-link' href='#'>Sign Up</a></li>";
          echo "</ul>";
        }
      ?>
    </div>
  </div>
</nav>

