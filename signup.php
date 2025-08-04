<?php
include_once "config/core.php";

$page_title = "Sign up";
include_once "layout_head.php";

include_once "login_checker.php";

//include classes
include_once "config/database.php";
include_once "objects/user.php";

//include page header html


if ($_POST) {
	
	$database = new Database();
	$db = $database->getConnection();

	//initialize the objects
	$user = new User($db);
	//set user contact number to  detect if it already used
	$user->contact_number = $_POST['contact_number'];
	$user->baranggay = $_POST['baranggay'];
	$user->lastname = $_POST['lastname'];
	$user->firstname = $_POST['firstname'];
	$user->user_type = "consumer";

	if ($user->create()) {

		echo "<div class='alert alert-success'>";
			echo "Information Submitted! <a href='{$home_url}login'> Please sign in to continue </a>";
		echo "</div>";

	}else{
		echo "<div class='alert alert-danger'> role='alert'>ERROR! Please try again later.</div>";
	}
}
?>
<!-- sign up html form -->
<?php

echo "<div class='left-panel'>";
    echo "<div class='account-wall'>";
    	echo "<h2 class='text-center'>$page_title</h2>";
        echo "<p class='text-center'>Don't have an account? <a href='signin.php'>Sign up</a></p>";
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
                    	echo "<label>";
                        echo "<input type='checkbox' name='remember_me' /> Remember me";
                        echo "</label>";
                        echo "<a href= '#' > Forgot Password?</a>";
                    echo "</div>";
                echo "</form>";
                
				//if mag-login sa google and fb
                echo "<div class='social-login'>";
                	echo "<p class='text-center'>or login with</p>";
                    echo "<button class='btn btn-block btn-social btn-google'>";
                        	echo "<i class='fa fa-google'></i> Login with Google";
                	echo "</button>";
                        echo "<button class='btn btn-block btn-social btn-facebook'>";
                            echo "<i class='fa fa-facebook'></i> Login with Facebook";
                            echo "</button>";
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
?>



	<!-- <table class='table table-responsive'>
		<tr>
			<td>Contact No.</td>
			<td><input type="text" name="contact_number" class="form-control" required></td>
		</tr>

		<tr>
			<td class='width-30-percent'>Baranggay</td>
			<td><input type="text" name="baranggay" class="form-control"></td>
		</tr>

		<tr>
			<td class='width-30-percent'>Last Name</td>
			<td><input type="text" name="lastname" class="form-control" required></td>
		</tr>

		<tr>
			<td class='width-30-percent'>First Name</td>
			<td><input type="text" name="firstname" class="form-control" required></td>
		</tr>

		<tr>
			<td></td>
			<td>
				<button type="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-plus"></span> Sign up

				</button>
			</td>
		</tr>

	</table> -->

<?php


include_once "layout_foot.php";
?>