<?php
include_once "config/core.php";

$page_title = "Sign up";
include_once "login_checker.php";

//include classes
include_once "config/database.php";
include_once "objects/user.php";

//include page header html
include_once "layout_head.php";

echo "<div class= 'col-md-12'>";

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

<div class="container-fluid">
  <div class="row vh-100">
    <!-- Left Column -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="w-75">
        <h3 class="mb-4">Create an Account</h3>
        <p class="small">Already have an Account? <a href="#">Login here</a></p>
        
        <form>
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Full Name">
          </div>
          <div class="mb-3">
            <input type="email" class="form-control" placeholder="Email address">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" placeholder="Enter your password">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" placeholder="Re-enter your password">
          </div>
          <button type="submit" class="btn btn-success w-100">Submit</button>
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































<!-- sign up html form -->
<!-- <form action="signup.php" method="post" id="signup">
	<table class='table table-responsive'>
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

	</table>
</form> -->

<?php
echo "</div>";


include_once "layout_foot.php";
?>