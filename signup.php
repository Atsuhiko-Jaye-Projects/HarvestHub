<?php
include_once "config/core.php";

$page_title = "Sign up";
include_once "login_checker.php";

//include classes
include_once "config/database.php";
include_once "objects/user.php";

//include page header html
include_once "layout_head.php";

echo "<div class='container-fluid'>";
echo "<div class='row vh-100'>";

$alert_message = "";

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();

    // initialize the objects
    $user = new User($db);
    $user->firstname = $_POST['firstname'];
    $user->lastname = $_POST['lastname'];
    $user->email_address = $_POST['email_address'];
    $user->password = $_POST['password'];
    $user->farm_details_exists = 0;
    $user->user_type = "consumer";

    if ($user->create()) {
        $alert_message = "<div class='alert alert-success'>
            Information Submitted! <a href='{$home_url}login'> Please sign in to continue </a>
        </div>";
    } else {
        $alert_message = "<div class='alert alert-danger' role='alert'>
            ERROR! Please try again later.
        </div>";
    }
}
?>

<!-- Left Column -->
<div class="col-md-6 d-flex align-items-center justify-content-center">
    <div class="w-75">

        <?php 
        // Display alert here
        if (!empty($alert_message)) { 
            echo $alert_message; 
        } 
        ?>

        <h3 class="mb-4">Create an Account</h3>
        <p class="small">Already have an Account? <a href="signin.php">Login here</a></p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST'>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                </div>

                <div class="col-md-6 mb-3">
                    <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="email_address" class="form-control" placeholder="Email address" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                
                <div class="mb-3">
                    <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter your password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100">Sign up</button>
        </form>

    </div>
</div>

<!-- Right Column with Background -->
<div class="col-md-6 p-0 d-none d-md-block" 
     style="background: url('libs/images/background.png') no-repeat center center; background-size: cover;">
    <div class="h-100 w-100 d-flex align-items-center justify-content-center text-center text-white px-4" style="background-color: rgba(0,0,0,0.2);">
        <div>
            <h1 class="fw-bold"><span class="text-success">Harvest</span> Hub</h1>
            <p class="lead">A Digital Marketplace for Fresh Goods</p>
            <p class="small">Harvest Hub is an innovative online marketplace connecting local farmers directly with consumers and businesses.</p>
        </div>
    </div>
</div>

<?php
echo "</div>"; // row
echo "</div>"; // container-fluid

include_once "layout_foot.php";
?>