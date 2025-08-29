<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/harvest_product.php";
include_once "../../../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);
$product = new Product($db);

$require_login=true;
include_once "../../../login_checker.php";

$page_title = "Manage Harvest";
include_once "../layout/layout_head.php";

$page_url = "{$home_url}user/farmer/management/manage_harvest.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$harvest_product->user_id = $_SESSION['user_id'];
$stmt = $harvest_product->readAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $harvest_product->countAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    include_once "../../../config/database.php";
    include_once "../../../objects/harvest_product.php";


    $database = new Database();
    $db = $database->getConnection();
    $harvest_product = new HarvestProduct($db);


    // ===== CREATE =====
    if ($_POST['action'] == 'create') {
        $farm_product->product_name = $_POST['product_name'];
        $farm_product->date_planted = $_POST['date_planted'];
        $farm_product->estimated_harvest_date = $_POST['estimated_harvest_date'];
        $farm_product->yield = $_POST['yield'];
        $farm_product->suggested_price = $_POST['suggested_price'];

        if ($farm_product->createFarmProduct()) {
            echo "<div class='container'><div class='alert alert-success'>Product Info Saved!</div></div>";
        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not saved.</div></div>";
        }
    }

    // ===== UPDATE =====
    elseif ($_POST['action'] == 'update') {

        $harvest_product->user_id = $_SESSION['user_id'];
        $harvest_product->id = $_POST['product_id']; // Make sure your form has this hidden input
        $harvest_product->product_name = $_POST['product_name'];
        $harvest_product->price_per_unit = $_POST['price_per_unit'];
        $harvest_product->category = $_POST['category'];
        $harvest_product->unit = $_POST['unit'];
        $harvest_product->product_description = $_POST['product_description'];
		$harvest_product->lot_size = $_POST['lot_size'];

        if ($harvest_product->updateHarvestProduct()) {
						
            header("location:{$home_url}user/farmer/manage_harvest.php?r=pu");

			//echo "<div class='container'><div class='alert alert-success'>Harvest Product Info Updated!</div></div>";

        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not updated.</div></div>";
        }
    }

    else if ($_POST['action'] == 'product_post') {

        $product->product_id = $_POST['product_id']; // Make sure your form has this hidden input
        $product->product_name = $_POST['product_name'];
        $product->user_id = $_SESSION['user_id'];
        $product->price_per_unit = $_POST['price_per_unit'];
        $product->category = $_POST['category'];
        $product->unit = $_POST['unit'];
        $product->product_description = $_POST['product_description'];
		$product->lot_size = $_POST['lot_size'];
        $product->product_image = $_POST['product_image'] ?? 'default.png';
        $product->status = "Active";

        $harvest_product->id = $_POST['product_id'];
        $harvest_product->is_posted = "Posted";

        if ($_POST['is_posted'] == "Posted") {
            echo "<div class='container'><div class='alert alert-warning'>Product is already posted.</div></div>";
        }else{
            $product->postProduct();
            //update the item by the status if its posted 
			$harvest_product->postedProduct();
			echo "<div class='container'><div class='alert alert-success'>Product Posted!</div></div>";
        }
    }
}
// include the stats cards
include_once "../statistics/stats.php";
include_once "template/man_harvest.php";
?>


<?php include_once "../layout/layout_foot.php"; ?>