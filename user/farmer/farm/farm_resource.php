<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/farm-resource.php";

$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);

$require_login=true;
include_once "../../../login_checker.php";

$page_title = "Farm Supplies & Resources";
include_once "../layout/layout_head.php";

$page_url = "{$home_url}user/farmer/farm_resource.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$farm_resource->user_id = $_SESSION['user_id'];
$stmt = $farm_resource->readAllResource($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $farm_resource->countAll();



if ($_SERVER["REQUEST_METHOD"] == "POST") {

	include_once "../../config/database.php";
	include_once "../../objects/farm-resource.php";

	$database = new Database();
	$db = $database->getConnection();

	$farm_resource = new FarmResource($db);

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

//include stats card
include_once "../statistics/management/management_resource_stats.php";
include_once "template/farm_resource_template.php";
?>



<?php include_once "../layout/layout_foot.php"; ?>