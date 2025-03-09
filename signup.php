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
<!-- sign up html form -->
<form action="signup.php" method="post" id="signup">
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
</form>

<?php
echo "</div>";


include_once "layout_foot.php";
?>