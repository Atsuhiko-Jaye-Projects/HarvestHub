<?php
// core configuration
include_once "config/core.php";
// set page title
$page_title = "Login";

// include login checker
$require_login=false;
include_once "login_checker.php";
// default to false
$access_denied=false;
if ($_POST) {
	include_once 'config/database.php';
	include_once 'objects/user.php';

	$database = new Database();
	$db = $database->getConnection();

	$user = new User($db);
	//check if contact number and password is in the database.

	$user->email_address = $_POST['email_address'];
	//check if the contact number is exists and last name is exists
	$credential_exists = $user->credentialExists();
	if ($credential_exists && $user->first_time_logged_in >= 0 && password_verify($_POST['password'], $user->password)) {
		
		$_SESSION['logged_in'] = true;
		$_SESSION['user_type'] = $user->user_type;
		$_SESSION['user_id'] = $user->id;
		$_SESSION['firstname'] = $user->firstname;
		$_SESSION['lastname'] = $user->lastname;
		$_SESSION['contact_number'] = $user->contact_number;
		$_SESSION['is_farm_registered'] = $user->farm_details_exists;

		if ($user->user_type=='Admin') {
			header("Location:{$home_url}admin/index.php?action=login_success");
		}
		else if($user->user_type=='Farmer') {
			header("Location:{$home_url}user/farmer/index.php?action=login_success");
		}else{
			header("Location:{$home_url}Costumer/index.php?action=login_success");
		}
	}else{
		$access_denied = true;
	}

}
// include page header HTML
include_once "layout_head.php";

?>


<div class="container-fluid">
  <div class="row vh-100">
    <!-- Left Column -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="w-75">
        <?php include_once "alert_message.php"; ?>
        <h3 class="mb-4">Login</h3>
        <p class="small">Don't have an account? <a href="signup.php">Create one</a></p>
        
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST'>
          <div class="mb-3">
            <input type="email" name="email_address" class="form-control" placeholder="Email address" required>
          </div>
          <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Sign in</button>
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
  </div>
</div>

<?php include_once "layout_foot.php"; ?>

