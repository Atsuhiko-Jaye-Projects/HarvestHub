<?php
// core configuration
include_once "config/core.php";
// set page title
$page_title = "Login";
include_once "layout_head.php";
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
if (isset($_POST['remember_me'])) {
    // Set a cookie for 7 days
    setcookie("contact_number", $user->contact_number, time() + (86400 * 7), "/");
    setcookie("lastname", $user->lastname, time() + (86400 * 7), "/");
}

// include page header HTML
    echo "<div class='left-panel'>";
        include_once 'alert_message.php';
        echo "<div class='account-wall'>";
            echo "<h2 class='text-center'>Login</h2>";
            echo "<p class='text-center'>Don't have an account? <a href='signup.php'>Sign up</a></p>";
            echo "<div id='my-tab-content' class='tab-content'>";
                echo "<div class='tab-pane active' id='login'>";
                    echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                        echo "<label> Contact Number</label>";
                        echo "<input type='text' name='contact_number' class='form-control' placeholder='Contact No.' required autofocus />";
                        echo "<span> Last Name</span>";
                        echo "<input type='text' name='lastname' class='form-control' placeholder='Last Name' required />";
                        echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
                        //checkbox ito para sa remember me aking mahal
                        echo "<div class='forgot-password'>";
                            echo "  <label>";
                            echo "    <input type='checkbox' name='remember_me' /> Remember me";
                            echo "  </label>";
                            echo "<a href= '#' > Forgot Password?</a>";
                        echo "</div>";
                    echo "</form>";
                    //if mag-login sa google and fb
                    echo "<div class='social-login'>";
                        echo "<p class='text-center'>or login with</p>";
                        echo "<button class='btn btn-block btn-social btn-google'>
                                <i class='fa fa-google'></i> Login with Google
                              </button>";
                        echo "<button class='btn btn-block btn-social btn-facebook'>
                                <i class='fa fa-facebook'></i> Login with Facebook
                              </button>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
    
    echo "<div class='right-panel'>";
        echo "<h1><span>Harvest</span> Hub</h1>";
        echo "<p>A Digital Marketplace for Fresh Goods</p>";
        echo "<p>Harvest Hub is an innovative online marketplace connecting local farmers directly with consumers and businesses.</p>";
    echo "</div>";



// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>

