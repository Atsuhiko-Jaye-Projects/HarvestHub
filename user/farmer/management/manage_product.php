<?php 
include_once '../../../config/core.php';
include_once "../../../config/database.php";
include_once "../../../objects/product.php";
include_once "../../../objects/product_history.php";


$page_title = "Manage Product";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product_history = new ProductHistory($db);

// get the search term
$page_url = "{$home_url}user/farmer/management/manage_product.php?";
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 5;

$product->user_id = $_SESSION['user_id'];
$stmt = $product->readAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $product->countAll();



// set the login require to to true

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$add_stock = $_POST['add_stock'];
    $new_price = $_POST['price_per_unit'];
    $current_price = $_POST['current_price'];

	$product->product_id = $_POST['product_id'];
	$product->price_per_unit = $_POST['price_per_unit'];
	$product->add_stocks = $add_stock;
	$product->product_type = $_POST['product_type'];
	$product->product_description = $_POST['description'];

	if (!empty($add_stock) && $add_stock > 0) {
        //print_r($_POST);
		$product->updateAvailableStock();
			echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Product Details Updated & Added New Stocks',
                    text: 'Product information has been updated successfully',
                    showConfirmButton: true
                });
            </script>
            ";
        if ($new_price != $current_price) {
            $product_history->farmer_id = $_SESSION['user_id'];
            $product_history->product_id = $_POST['product_id'];
            $product_history->new_price_per_unit = $new_price;
            $product_history->old_price_per_unit = $current_price;
            $product_history->LogPrice();
        }

	}else{
		$product->updateProductDetails();
		echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Product Details Updated!',
                    text: 'Product information has been updated successfully',
                    showConfirmButton: true
                });
            </script>
            ";
            if ($new_price != $current_price) {
            $product_history->farmer_id = $_SESSION['user_id'];
            $product_history->product_id = $_POST['product_id'];
            $product_history->new_price_per_unit = $new_price;
            $product_history->old_price_per_unit = $current_price;
            $product_history->LogPrice();
        }
	}

}
// include stats card
include_once "../statistics/stats.php";

//show the data counts in the cards
$product->user_id = $_SESSION['user_id'];
$total_posted_product = $product->activeProductCount();
$product_sold_count = $product->countProductSold();
$product_total_value = $product->productValue();

// include the management product template
include_once "template/man_product.php";
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.4/bootbox.min.js"></script>
<?php //include_once "../layout/layout_foot.php"; ?>