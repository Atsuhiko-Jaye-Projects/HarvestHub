<?php 
include '../../../config/core.php';
include_once "../../../config/database.php";
include_once "../../../objects/harvest_product.php";

$page_title = "Manage Product";
include_once "../layout/layout_head.php";

$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);

// get the search term
$page_url = "{$home_url}user/farmer/management/manage_product.php?";
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

$harvest_product->user_id = $_SESSION['user_id'];
$stmt = $harvest_product->readAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $harvest_product->countAll();

// set the login require to to true
$require_login=true;
include_once "../../../login_checker.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$harvest_product->user_id = $_SESSION['user_id'];
	$harvest_product->category = $_POST['category'];
	$harvest_product->product_name = $_POST['product_name'];
	$harvest_product->unit = $_POST['unit'];
	$harvest_product->lot_size = $_POST['lot_size'];
	$harvest_product->price_per_unit = $_POST['price_per_unit'];
	$harvest_product->total_stock = $_POST['total_stock'];
	$harvest_product->product_description = $_POST['product_description']; 

	$image=!empty($_FILES["product_image"]["name"])
        ? sha1_file($_FILES['product_image']['tmp_name']) . "-" . basename($_FILES["product_image"]["name"]) : "";
	$harvest_product->product_image = $image;

	
	if ($harvest_product->createProduct()) {
		echo $harvest_product->uploadPhoto();

		echo "<div class='container'>";
			echo "<div class='alert alert-success'>Product Info Saved!</div>";
		echo "</div>";
	}else{
		echo "<div class='container'>";
			echo "<div class='alert alert-danger'>ERROR: Product info is not save.</div>";
		echo "</div>";
	}

}
// include stats card
include_once "../statistics/stats.php";

// include the management product template
include_once "template/man_product.php";
?>
<?php include_once "../layout/layout_foot.php"; ?>