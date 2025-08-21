<?php
include_once "../../../config/core.php";

$require_login=true;
include_once "../../../login_checker.php";

$page_title = "Profile";
include_once "../layout/layout_head.php";


?>

<div class="container">
    <div class="row">
        <div class="col-12-md">
            <div class="card bg-success text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                
                <!-- Left side: Avatar + Name + Role -->
                <div class="d-flex align-items-center">
                    <!-- Avatar -->
                    <div
                    class="rounded-circle bg-light d-flex justify-content-center align-items-center"
                    style="width:60px;height:60px;"
                    >
                    <!-- Placeholder icon (you can replace this with an <img src=""> tag) -->
                    <img src="../../../libs/images/logo.png" style="width:60px;height:60px;border-radius:50%" alt="">
                    </div>

                    <!-- Name & Role -->
                    <div class="ms-3">
                    <h5 class="mb-1 text-capitalize"><?php echo $_SESSION['lastname'] . ", " . $_SESSION['firstname']; ?></h5>
                    <small><?php echo $_SESSION['user_type']; ?></small>
                    </div>
                </div>
                <!-- Right side: Edit Button -->
                <button class="btn btn-primary btn-sm">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2><strong>Personal Informations</strong></h2>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h2 class="text-capitalize"><?php echo $_SESSION['lastname'] . ", " . $_SESSION['firstname']; ?></h2>
                            <h4>Name</h4>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <h2 class="text-capitalize"><?php echo $_SESSION['contact_number']; ?></h2>
                            <h4>Contact Number</h4>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col">
                            <h2 class="text-capitalize"><?php echo $_SESSION['contact_number']; ?></h2>
                            <h4>Contact Number</h4>
                        </div>
                    </div>   
                </div>
            </div>
        </div>

        <div class="col mt-3">
            <div class="card">
                <div class="card-header">
                    <h2><strong>Farm Informations</strong></h2>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h2 class="text-capitalize"><?php echo $_SESSION['lastname'] . ", " . $_SESSION['firstname']; ?></h2>
                            <h4>Name</h4>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <h2 class="text-capitalize"><?php echo $_SESSION['contact_number']; ?></h2>
                            <h4>Contact Number</h4>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col">
                            <h2 class="text-capitalize"><?php echo $_SESSION['contact_number']; ?></h2>
                            <h4>Contact Number</h4>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once "../layout/layout_foot.php"; ?>


