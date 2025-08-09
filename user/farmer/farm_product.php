<?php
include_once "../../config/core.php";
include_once "../../config/database.php";
include_once "../../objects/farm-product.php";

$database = new Database();
$db = $database->getConnection();

$farm_product = new FarmProduct($db);

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Farm Products";
include_once "layout_head.php";

$farm_product->user_id = $_SESSION['user_id'];
$stmt = $farm_product->readAllProduct();
$num = $stmt->rowCount();



if ($_SERVER["REQUEST_METHOD"] == "POST") {

	include_once "../../config/database.php";
	include_once "../../objects/farm-resource.php";

	$database = new Database();
	$db = $database->getConnection();

	$farm_product = new FarmProduct($db);

	$farm_product->user_id = $_SESSION['user_id'];
	$farm_product->product_name = $_POST['product_name'];
    $farm_product->date_planted = $_POST['date_planted'];
	$farm_product->estimated_harvest_date = $_POST['estimated_harvest_date'];
	$farm_product->yield = $_POST['yield'];
    $farm_product->suggested_price = $_POST['suggested_price'];

	if ($farm_product->createFarmProduct()) {

		echo "<div class='container'>";
			echo "<div class='alert alert-success'>Product Info Saved!</div>";
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

<?php include_once "modal-forms/add-farm-product.php"; ?>



	<!-- Add Product Button -->
	<div class="mb-3 mt-3">
	<button class="btn btn-success px-4 py-2 " data-bs-toggle="modal" data-bs-target="#exampleModal"><span><i class="bi bi-plus-circle"></i></span> Add Button</button>
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
				<th>Product Name</th>
				<th>Date Planted</th>
				<th>Estimated Harvest Date</th>
				<th>Yield</th>
                <th>Suggested Price</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					echo "<tr w-20>";
						echo "<td>{$product_name}</td>";
						echo "<td>{$date_planted}</td>";
						echo "<td>{$estimated_harvest_date}</td>";
						echo "<td>{$yield}</td>";
                        echo "<td>{$suggested_price}</td>";
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