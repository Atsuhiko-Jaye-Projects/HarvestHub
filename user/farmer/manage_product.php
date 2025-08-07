<?php 
include '../../config/core.php';
include_once "../../config/database.php";
include_once "../../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$product->user_id = $_SESSION['user_id'];
$stmt = $product->readAllProduct();
$num = $stmt->rowCount();


$require_login=true;
include_once "../../login_checker.php";

$page_title = "Manage Product";
include_once "layout_head.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	include_once "../../config/database.php";
	include_once "../../objects/product.php";

	$database = new Database();
	$db = $database->getConnection();

	$product = new Product($db);

	$product->user_id = $_SESSION['user_id'];
	$product->category = $_POST['category'];
	$product->product_name = $_POST['product_name'];
	$product->unit = $_POST['unit'];
	$product->lot_size = $_POST['lot_size'];
	$product->price_per_unit = $_POST['price_per_unit'];
	$product->total_stock = $_POST['total_stock'];
	$product->product_description = $_POST['product_description']; 

	$image=!empty($_FILES["product_image"]["name"])
        ? sha1_file($_FILES['product_image']['tmp_name']) . "-" . basename($_FILES["product_image"]["name"]) : "";
	$product->product_image = $image;

	
	if ($product->createProduct()) {
		echo $product->uploadPhoto();

		echo "<div class='container'>";
			echo "<div class='alert alert-success'>Product Info Saved!</div>";
		echo "</div>";
	}else{
		echo "<div class='container'>";
			echo "<div class='alert alert-danger'>ERROR: Product info is not save.</div>";
		echo "</div>";
	}

}



?>

<div class="container">
	<!-- Add Product Button -->
	<div class="mb-3 mt-3">
	<button class="btn btn-success px-4 py-2 " data-bs-toggle="modal" data-bs-target="#exampleModal"><span><i class="bi bi-plus-circle"></i></span> Add Product</button>
	</div>

	<?php include_once "modal-forms/add-product.php";?>

	<!-- Table -->
	<?php
		if ($num>0) {
	?>
	<div class="table-responsive">
		<table class="table align-middle">
			<thead class="table-light">
			<tr>
				<th>Product Name</th>
				<th>Category</th>
				<th>Price</th>
				<th>Unit</th>
				<th>Lot Size</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					echo "<tr>";
						echo "<td>{$product_name}</td>";
						echo "<td>{$category}</td>";
						echo "<td>{$price_per_unit}</td>";
						echo "<td>{$unit}</td>";
						echo "<td>{$lot_size}</td>";
						echo "<td>{$created_at}</td>";
						echo "<td>";
							echo "<button class='btn btn-primary me-2'>Edit</button>";
							echo "<button class='btn btn-warning me-2'>View</button>";
							echo "<button class='btn btn-danger me-2'>Remove</button>";
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