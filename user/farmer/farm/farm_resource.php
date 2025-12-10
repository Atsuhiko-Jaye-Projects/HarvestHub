<?php
ob_start();
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
		$resource_id = date("YmdHis") . rand(100,999);
		$farm_resource->user_id = $_SESSION['user_id'];
		$farm_resource->record_name = $_POST['record_name'];

		// bind the values first to variable
		$activity_names = $_POST['activity_name'];
		$farm_activity_type = $_POST['farm_activity_type'];
		$other_farm_activity = $_POST['other_activity'];
		$activity_cost = $_POST['activity_cost'];
		$other_info = $_POST['other_info'];
		$activity_date = $_POST['activity_date'];

		for ($i=0; $i < count($activity_names); $i++) { 

			$farm_activity->record_name = $_POST['record_name'];
			$farm_activity->activity_name = $activity_names[$i];
			$farm_activity->farm_activity = $farm_activity[$i];
			$farm_activity->activity_cost = $activity_cost[$i];
			$farm_activity->other_activity = $other_farm_activity[$i];
			$farm_activity->other_info = $other_info[$i];
			$farm_activity->activity_date = $activity_date[$i];
			$farm_activity->farm_resource_id = $resource_id[$i];


			if ($farm_activity->createFarmActivity()) {

				header("LOCATION:{$base_url}user/farmer/farm/farm_resource.php?status=success&");
				exit;
			// echo "<div class='container'>";
			// 	echo "<div class='alert alert-success'>Resource Info Saved!</div>";
			// echo "</div>";

			}else{
				header("LOCATION:{$base_url}user/farmer/farm/farm_resource.php?status=failed&");
				exit;
				// echo "<div class='container'>";
				// 	echo "<div class='alert alert-danger'>ERROR: Product info is not save.</div>";
				// echo "</div>";
			}
		}
	}

	if ($_POST["action"]=="update") {
		$farm_resource->id = $_POST['record_id'];
		$farm_resource->record_name = $_POST['record_name'];
		$farm_resource->land_prep_expense_cost = $_POST['land_prep_expense_cost'];
		$farm_resource->nursery_seedling_prep_cost = $_POST['nursery_seedling_prep_cost'];
		$farm_resource->transplanting_cost = $_POST['transplanting_cost'];
		$farm_resource->crop_maintenance_cost = $_POST['crop_maintenance_cost'];
		$farm_resource->harvesting_cost = $_POST['harvesting_cost'];
		$farm_resource->input_seed_fertilizer_cost = $_POST['input_seed_fertilizer_cost'];
		$farm_resource->post_harvest_transport_cost = $_POST['post_harvest_transport_cost'];
		$farm_resource->date = $_POST['date'];
		
		if ($farm_resource->updateFarmResource()) {
			header("LOCATION:{$base_url}user/farmer/farm/farm_resource.php?status=update_success&");
			exit;
			
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

<?php if (isset($_GET['status'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    <?php if ($_GET['status'] == 'success'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Resource Info Saved!',
            showConfirmButton: false,
            timer: 1800
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'error'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Failed to Save Resource Info',
            text: 'Please try again.',
            showConfirmButton: true
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'update_success'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Resource Info Updated!',
            showConfirmButton: false,
            timer: 1800
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'error'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Failed to Update Resource Info',
            text: 'Please try again.',
            showConfirmButton: true
        });
    <?php endif; ?>

});
</script>
<?php endif; ?>

<script>
if (window.history.replaceState) {
    const url = new URL(window.location);
    url.searchParams.delete('status');
    window.history.replaceState({}, document.title, url.pathname);
}
</script>

<?php include_once "../layout/layout_foot.php"; ?>