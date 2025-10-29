<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/harvest_product.php";
include_once "../../../objects/product.php";
include_once "../../../objects/farm.php";
include_once "../../../objects/farm-resource.php";

$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);
$product = new Product($db);
$farm = new Farm($db);
$farm_resource = new FarmResource($db);

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
//$stmt = $harvest_product->readAllProduct($from_record_num, $records_per_page);
$num;
$total_rows = $harvest_product->countAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    include_once "../../../config/database.php";
    include_once "../../../objects/harvest_product.php";


    $database = new Database();
    $db = $database->getConnection();
    $harvest_product = new HarvestProduct($db);


    // ===== CREATE =====
    if ($_POST['action'] == 'create') {

        $planted_area = isset($_POST['lot_size']) ? (float)str_replace(',', '', $_POST['lot_size']) : 0;
        $farm_expense = isset($_POST['farm_expense']) ? (float)str_replace(',', '', $_POST['farm_expense']) : 0;
        $total_farm_size = isset($_POST['farm_size_sqm']) ? (float)str_replace(',', '', $_POST['farm_size_sqm']) : 0;

        // General markup (50% profit)
        $markup = 1.5;

        // Example: general yield for vegetables ~0.06–0.08 kg/sqm (use 0.08 default)
        $general_yield = 0.08;

        // Prevent division by zero
        if ($planted_area > 0 && $farm_expense > 0 && $total_farm_size > 0) {

            // 1️⃣ Compute expense for the planted lot (proportionally)
            $expense_farm_lot = ($farm_expense / $total_farm_size) * $planted_area;

            // 2️⃣ Compute estimated yield (kg)
            $total_harvested_yield = $planted_area * $general_yield;

            // 3️⃣ Compute cost per kg
            $cost_per_kg = $expense_farm_lot / $total_harvested_yield;

            // 4️⃣ Add markup
            $selling_price = $cost_per_kg * $markup;

            // 5️⃣ Round to 2 decimals for currency
            $harvest_product->price_per_unit = round($selling_price, 2);

        } else {
            $harvest_product->price_per_unit = 0;
        }

        $harvest_product->user_id = $_SESSION['user_id'];
        $harvest_product->product_name = $_POST['product_name'];
        $harvest_product->category = $_POST['category'];
        $harvest_product->unit = $_POST['unit'];
        $harvest_product->product_description = $_POST['product_description'];
        $harvest_product->lot_size = $_POST['lot_size'];
        $harvest_product->is_posted = "Pending";


        // bind the image value
        $image=!empty($_FILES["product_image"]["name"])
        ? sha1_file($_FILES['product_image']['tmp_name']) . "-" . basename($_FILES["product_image"]["name"]) : "";
        $harvest_product->product_image = $image;

        if ($harvest_product->createProduct()) {
            echo "<div class='container'><div class='alert alert-success'>Product Info Saved!</div></div>";
            if ($harvest_product->uploadPhoto()) {
            }else{
                echo "Upload Failed";
            }
        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not saved.</div></div>";
        }
    }

    // ===== UPDATE =====
    elseif ($_POST['action'] == 'update') {

        $harvest_product->user_id = $_SESSION['user_id'];
        $harvest_product->id = $_POST['product_id'];
        $harvest_product->product_name = $_POST['product_name'];
        $harvest_product->price_per_unit = $_POST['price_per_unit'];
        $harvest_product->category = $_POST['category'];
        $harvest_product->unit = $_POST['unit'];
        $harvest_product->product_description = $_POST['product_description'];
		    $harvest_product->lot_size = $_POST['lot_size'];

        if ($harvest_product->updateHarvestProduct()) {

            // header("location:{$home_url}user/farmer/manage_harvest.php?r=pu");

			      echo "<div class='container'><div class='alert alert-success'>Harvest Product Info Updated!</div></div>";

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

// get the users farm lot_size
$farm->user_id = $_SESSION['user_id'];

//get the total expense of the farmer
$farm_resource->user_id = $_SESSION['user_id'];
$total_farm_expense = $farm_resource->farmStatsTotalCost();

$farm_lot = $farm->getFarmLot();
// include the stats cards
include_once "../statistics/stats.php";
include_once "template/man_harvest.php";
?>


<?php include_once "../layout/layout_foot.php"; ?>
<!-- include the load api  -->

<!-- pass the php post methods from php to JS -->
<script>

//for UPDATE post method
const UpdatePostURL = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>";
//for PRODUCT POSTING post method
const ProductPostingURL = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>";
</script>
<script src="../../../js/user/farmer/modals/farm_product/farm_product_modal.js"></script>
<script src="../../../js/user/farmer/utils/utils.js"></script>
<!-- include the modals for modifications -->
