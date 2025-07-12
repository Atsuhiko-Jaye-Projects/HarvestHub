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

	$user->contact_number = $_POST['contact_number'];
	$user->lastname = $_POST['lastname'];
	//check if the contact number is exists and last name is exists
	$credential_exists = $user->credentialExists();

	if ($credential_exists && $user->first_time_logged_in >= 0) {
		
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
echo "<div class='col-sm-6 col-md-4 col-md-offset-4'>";
	include_once 'alert_message.php';
	// actual HTML login form
	echo "<div class='account-wall'>";
		echo "<div id='my-tab-content' class='tab-content'>";
			echo "<div class='tab-pane active' id='login'>";
				echo "<img class='profile-img' src='libs/images/logo.png'>";
				echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
					echo "<input type='text' name='contact_number' class='form-control' placeholder='Contact No.' required autofocus />";
					echo "<input type='text' name='lastname' class='form-control' placeholder='Last Name' required />";
					echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
				echo "</form>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
echo "</div>";


// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>

