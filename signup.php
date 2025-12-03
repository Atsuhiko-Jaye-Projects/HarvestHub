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
    include_once "objects/util.php";
    $database = new Database();
    $db = $database->getConnection();

    // initialize the objects
    $user = new User($db);
    $mailer = new Mailer($db);

    $user->firstname = $_POST['firstname'];
    $user->lastname = $_POST['lastname'];
    $user->email_address = $_POST['email_address'];
    $user->contact_number = $_POST['contact_number'];
    $user->password = $_POST['password'];
    $user->farm_details_exists = "0";
    $user->user_type = "consumer";
    $user->is_verified = 0;

    // generate token for verification
    $user->verification_token = bin2hex(random_bytes(32));

    $_POST['confirm_password'];

    if ($_POST['password'] != $_POST['confirm_password']) {
        $alert_message = "<div class='alert alert-danger' role='alert'>
            Password did not match. <i class='bi bi-exclamation-diamond-fill'></i> 
        </div>";
    }

    else if ($user->emailExists()) {
        $alert_message = "<div class='alert alert-danger' role='alert'>
            <i class='bi bi-exclamation-diamond-fill'></i> ERROR! Email Address is already taken. Please try another.
        </div>";
    }else{
        // send an email verification
        $verify_link = "{$home_url}verification.php?token=" . $user->verification_token;
        
        $subject = "Verify Your HarvestHub Account";

        $body = "
                <div style='font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 40px 0;'>
                    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden;'>
                        <div style='background-color: #4CAF50; color: white; text-align: center; padding: 30px 20px;'>
                            <h1 style='margin: 0;'>HarvestHub Digital Marketplace</h1>
                        </div>
                        <div style='padding: 30px 20px; color: #333; line-height: 1.6;'>
                            <h2 style='color: #4CAF50;'>Hello $user->firstname! Welcome to HarvestHub Digital Marketplace!</h2>
                            <p>Please click the link below to confirm your account and start exploring HarvestHub Digital Marketplace.</p>
                            <p style='text-align: center; margin: 30px 0;'>
                                <a href='$verify_link' 
                                style='background-color: #FFA500; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;'>
                                    Verify Email
                                </a>
                            </p>
                            <p>If the button above doesn’t work, copy and paste this link into your browser:</p>
                            <p style='word-break: break-all;'><a href='$verify_link' style='color: #4CAF50;'>$verify_link</a></p>
                            <p style='font-size: 0.9em; color: #777; margin-top: 20px;'>
                                This link is valid for 1 hour. If you did not request a verification link, please ignore this email.
                            </p>
                        </div>
                        <div style='background-color: #f4f6f8; text-align: center; padding: 20px; font-size: 0.8em; color: #aaa;'>
                            © " . date('Y') . " HarvestHub. All rights reserved.
                        </div>
                    </div>
                </div>
                ";
        if ($mailer->send($user->email_address, $subject, $body)) {
            $user->create();
            $alert_message = "<div class='alert alert-success'>
                Please verify you account to start exploring HarvestHub!
            </div>";
            json_encode(["status" => "success", "message" => "Registration successful. Check your email to verify."]);
        }else{
            $alert_message = "<div class='alert alert-danger'>
                Something went wrong please try again later.
            </div>";
            json_encode(["status" => "Failed", "message" => "Registration failed."]);
        }
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

                <div class="col-md-6 mb-3">
                    <input type="text" name="contact_number" class="form-control" placeholder="Contact No" required>
                </div>

                <div class="col-md-6 mb-3">
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