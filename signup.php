<?php
include_once "config/core.php";
//include classes

$page_title = "Sign up";
include_once "login_checker.php";

//include page header html
include_once "layout_head.php";

echo "<div class='container-fluid'>";
echo "<div class='row vh-100'>";

$alert_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include_once "config/database.php";
    include_once "objects/user.php";
    $database = new Database();
    $db = $database->getConnection();

    // initialize the objects
    $user = new User($db);
    $user->firstname = $_POST['firstname'];
    $user->lastname = $_POST['lastname'];
    $user->email_address = $_POST['email_address'];
    $user->password = $_POST['password'];
    $user->farm_details_exists = "0";
    $user->user_type = "consumer";

    if ($user->emailExists()) {
        $alert_message = "<div class='alert alert-danger' role='alert'>
            <i class='bi bi-exclamation-diamond-fill'></i> ERROR! Email Address is already taken. Please try another.
        </div>";

    } 

    else if ($user->contactExists()) {
        $alert_message = "<div class='alert alert-danger' role='alert'>
            <i class='bi bi-exclamation-diamond-fill'></i> ERROR! Contact number is already taken. Please try another.
        </div>";
    } 
    
    // no errors to inputs, proceed to account creation
    else {
        $user->create();
        $alert_message = "<div class='alert alert-success'>
            Start your account and <a href='{$home_url}login'>continue! </a>
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
        <p class="small">Already have an Account? <a class="text-decoration-none" href="signin.php">Login here</a></p>
        
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

        <div class="mt-3">
            <p class="small">Want to sell your good the community? Be a seller! <a class="text-decoration-none" href="seller-signup.php">HERE</a></p>
        </div>
        <hr>

        <div>
            <p class="small">By signing up, you agree to the HarvestHub.com Service <a href="">Terms & Conditions</a> and the <a href="">Privacy Policy.</a></p>
        </div>
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