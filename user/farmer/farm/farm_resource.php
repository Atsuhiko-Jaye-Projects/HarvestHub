<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/farm-resource.php";

$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);


$page_title = "Farm Resources & supplies";
$require_login=true;
include_once "../../../login_checker.php";
include_once "../layout/layout_head.php";

$farm_resource->user_id = $_SESSION['user_id'];

$today = date('Y-m-d');

// First day of the current month
$month_first_day = date('Y-m-01');

// Default filter dates (for inputs)
$filter_from_date = isset($_GET['from_date']) ? $_GET['from_date'] : $month_first_day;
$filter_to_date   = isset($_GET['to_date'])   ? $_GET['to_date']   : $today;

// Display labels (pretty format)
$start_date = date('M d, Y', strtotime($filter_from_date));
$end_date   = date('M d, Y', strtotime($filter_to_date));


$page_url = "{$home_url}user/farmer/farm/farm_resource.php?";
$page_url .= "from_date={$filter_from_date}&to_date={$filter_to_date}&";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;


//display the current month farm expense

$farm_resource->start_date_expense = $filter_from_date;
$farm_resource->today_expense = $filter_to_date;
$farm_resource->user_id = $_SESSION['user_id'];

$stmt = $farm_resource->readAllResource($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $farm_resource->countAll();



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

	include_once "../../../config/database.php";
	include_once "../../../objects/farm-resource.php";

	$database = new Database();
	$db = $database->getConnection();

	$farm_resource = new FarmResource($db);

	if ($_POST["action"]=="create") {
		$farm_resource->user_id = $_SESSION['user_id'];
		$farm_resource->item_name = $_POST['item_name'];
		$farm_resource->type = $_POST['type'];
		$farm_resource->cost = $_POST['cost'];
		$farm_resource->date = $_POST['date'];
		
		if ($farm_resource->createFarmResource()) {
			echo "<div class='container'>";
				echo "<div class='alert alert-success'>Resource Info Saved!</div>";
			echo "</div>";

		}else{
			echo "<div class='container'>";
				echo "<div class='alert alert-danger'>ERROR: Product info is not save.</div>";
			echo "</div>";
		}
	}

	if ($_POST["action"]=="update") {
		$farm_resource->id = $_POST['item_id'];
		$farm_resource->item_name = $_POST['item_name'];
		$farm_resource->type = $_POST['type'];
		$farm_resource->cost = $_POST['cost'];
		$farm_resource->date = $_POST['date'];
		
		if ($farm_resource->updateFarmResource()) {
			echo "<div class='container'>";
				echo "<div class='alert alert-success'>Resource Info update!</div>";
			echo "</div>";
			
		}else{
			echo "<div class='container'>";
				echo "<div class='alert alert-danger'>ERROR: Product info is not save.</div>";
			echo "</div>";
		}
	}


}


//include stats card
include_once "../statistics/management/management_resource_stats.php";
include_once "template/farm_resource_template.php";
?>



<?php include_once "../layout/layout_foot.php"; ?>