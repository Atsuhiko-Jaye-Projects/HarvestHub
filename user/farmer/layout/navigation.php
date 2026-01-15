<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <button class="btn btn-outline-dark d-xl-none m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
    <i class="bi bi-list"></i>
    </button>
    <!-- show notice to user who address is not set -->
    <?php include_once "notice.php"; ?>
    <a class="navbar-brand"></a>
        <div class="d-flex align-items-center">

        <!-- notification bell file here -->
        <?php include_once "notification.php"; ?>
        <!-- Avatar -->
        <?php
            if ($page_title=="Edit Product") {
                echo "<img src='../../../libs/images/logo.png' alt='User Avatar' class='rounded-circle me-2' width='40' height='40' >";
            }else{
                echo "<img src='$base_url/libs/images/logo.png' alt='User Avatar' class='rounded-circle me-2' width='40' height='40'>";
            }
        ?>

        <!-- User Info -->
        <div class="d-flex flex-column">
            <span class="fw-bold">
                <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?>
            </span>
            <small class="text-muted"><?php echo $_SESSION['user_type']; ?></small>
        </div>

        <!-- Dropdown -->
        <div class="dropdown ms-auto">
            <button class="btn btn-sm btn-light" type="button" id="userDropdown" data-bs-toggle="dropdown">
                <i class="bi bi-caret-down-fill"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo $base_url; ?>user/farmer/profile/profile.php">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo $base_url; ?>logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>