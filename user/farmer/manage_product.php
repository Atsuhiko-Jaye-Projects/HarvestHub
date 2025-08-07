<?php 
include '../../config/core.php';


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
	<div class="table-responsive">
		<table class="table align-middle">
			<thead class="table-light">
			<tr>
				<th>Product ID</th>
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
			<tr>
				<td>#2456JL</td>
				<td>Carrot</td>
				<td>High Valued Crops</td>
				<td>₱200.00</td>
				<td>kg</td>
				<td>10kg/Lot</td>
				<td>Feb 12, 12:23 pm</td>
				<td>
				<button class="btn btn-primary rounded-pill px-3">Edit</button>
				</td>
			</tr>
			<tr>
				<td>#5435DF</td>
				<td>Mango</td>
				<td>Fruit</td>
				<td>₱200.00</td>
				<td>kg</td>
				<td>10kg/Lot</td>
				<td>Feb 01, 01:13 pm</td>
				<td>
				<button class="btn btn-primary rounded-pill px-3">Edit</button>
				</td>
			</tr>
			<tr>
				<td>#9876XC</td>
				<td>Egg Plant</td>
				<td>High Valued Crops</td>
				<td>₱200.00</td>
				<td>kg</td>
				<td>10kg/Lot</td>
				<td>Jan 20, 09:08 am</td>
				<td>
				<button class="btn btn-primary rounded-pill px-3">Edit</button>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>


<?php include_once "layout_foot.php"; ?>