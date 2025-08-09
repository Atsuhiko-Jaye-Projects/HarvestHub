<?php
include_once "../../config/core.php";
	include_once "../../config/database.php";
	include_once "../../objects/farm-resource.php";

	$database = new Database();
	$db = $database->getConnection();

$farm_resource = new FarmResource($db);

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Farm Supplies & Resources";
include_once "layout_head.php";

$farm_resource->user_id = $_SESSION['user_id'];
$stmt = $farm_resource->readAllResource();
$num = $stmt->rowCount();



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
include_once "stats.php";
?>

<div class="container">

	<?php include_once "modal-forms/add-resource.php"; ?>



	<!-- Add Product Button -->
	<div class="mb-3 mt-3">
	<button class="btn btn-success px-4 py-2 " data-bs-toggle="modal" data-bs-target="#exampleModal"><span><i class="bi bi-plus-circle"></i></span></button>
	</div>
	<h2><?php echo $page_title; ?></h2>

	<!-- Table -->
	<?php
		if ($num>0) {
	?>
	<div class="table">
		<table class="table align-middle table-bordered text-center">
			<thead class="table-light">
			<tr>
				<th>Type</th>
				<th>Name</th>
				<th>Cost</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					echo "<tr w-20>";
						echo "<td>{$type}</td>";
						echo "<td>{$item_name}</td>";
						echo "<td>{$cost}</td>";
						echo "<td>{$date}</td>";
						echo "<td>";
							echo "<button class='btn btn-primary me-2'>Edit</button>";
							echo "<button class='btn btn-warning me-2'>View</button>";
						echo "</td>";
					echo "</tr>";
				}			
			?>
			</tbody>
		</table>
	</div>
	<?php
	}else{
		echo "<div class='alert alert-danger'>No products Found</div>";
	}
	?>
</div>



<?php include_once "layout_foot.php"; ?>