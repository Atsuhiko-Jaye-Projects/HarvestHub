<nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand"></a>

        <div class="d-flex align-items-center">
            <!-- Avatar -->
            <!-- <img src="../../libs/images/logo.png" alt="User Avatar" class="rounded-circle me-2" width="40" height="40"> -->
            <?php
                if ($page_title=="Edit Product") {
                    echo "<img src='../../../libs/images/logo.png' alt='User Avatar' class='rounded-circle me-2' width='40' height='40'>";
                }else{
                    echo "<img src='$base_url/libs/images/logo.png' alt='User Avatar' class='rounded-circle me-2' width='40' height='40'>";
                }
            ?>
            <!-- User Info -->
            <div class="d-flex flex-column ">
                <span class="fw-bold">
                    <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?>
                </span>
                <small class="text-muted"><?php echo $_SESSION['user_type']; ?></small>
            </div>

            <!-- Dropdown with caret only -->
            <div class="dropdown ms-auto">
                <button class="btn btn-sm btn-light" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-caret-down-fill"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>user/farmer/profile/profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../../../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
</nav>