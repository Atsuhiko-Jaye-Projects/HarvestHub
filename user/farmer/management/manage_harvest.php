<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/harvest_product.php";
include_once "../../../objects/product.php";
include_once "../../../objects/farm.php";
include_once "../../../objects/farm-resource.php";

$page_title = "Manage Harvest";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";


$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);
$product = new Product($db);
$farm = new Farm($db);
$farm_resource = new FarmResource($db);
$farm_resource->user_id = $_SESSION['user_id'];
$farm_resource->getRecordExpense();


$page_url = "{$home_url}user/farmer/management/manage_harvest.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$harvest_product->user_id = $_SESSION['user_id'];
// $stmt = $harvest_product->readAllProduct($from_record_num, $records_per_page);
// $num;
// $total_rows = $harvest_product->countAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    include_once "../../../config/database.php";
    include_once "../../../objects/harvest_product.php";


    $database = new Database();
    $db = $database->getConnection();
    $harvest_product = new HarvestProduct($db);


    // ===== CREATE =====
    if ($_POST['action'] == 'create') {

        $planted_area = isset($_POST['lot_size']) ? (float)str_replace(',', '', $_POST['lot_size']) : 0;
        $plant_count = isset($_POST['plant_count']) ? (float)str_replace(',', '', $_POST['plant_count']) : 0;
        $kilo_per_plant = isset($_POST['kilo_per_plant']) ? (float)str_replace(',', '', $_POST['kilo_per_plant']) : 0;
        $farm_expense = isset($_POST['total_plant_expense']) ? (float)str_replace(',', '', $_POST['total_plant_expense']) : 0;
        $total_farm_size = isset($_POST['farm_size_sqm']) ? (float)str_replace(',', '', $_POST['farm_size_sqm']) : 0;

        // General markup (50% profit)
        $markup = 0.015 * 100;

        // Example: general yield for vegetables ~0.06–0.08 kg/sqm (use 0.08 default)
        

        // Prevent division by zero
        if ($planted_area > 0 && $farm_expense > 0 && $total_farm_size > 0) {

            
            // Expense allocated to the planted area
            $kilo_harvested_product = $plant_count * $kilo_per_plant;

            // Prevent zero division
            if ($kilo_harvested_product <= 0) {
                $kilo_harvested_product = 1;
            }

            $stocks = $plant_count * $kilo_per_plant;

            // Cost per kg
            $cost_per_kg = $farm_expense / $kilo_harvested_product;

            

            // Selling price with markup
            $selling_price = $cost_per_kg * $markup;

            // Rounded price (currency format)
            $harvest_product->price_per_unit = round($selling_price, 2);

        } else {
            $harvest_product->price_per_unit = 0;
        }

        $harvest_product->user_id = $_SESSION['user_id'];
        $harvest_product->product_name = $_POST['product_name'];
        $harvest_product->category = $_POST['category'];
        $harvest_product->total_stocks = $stocks;
        $harvest_product->plant_count = $_POST['plant_count'];
        $harvest_product->expense = $_POST['total_plant_expense'];
        $harvest_product->unit = "KG";
        $harvest_product->kilo_per_plant = $_POST['kilo_per_plant'];
        $harvest_product->product_description = $_POST['product_description'];
        $harvest_product->lot_size = $_POST['lot_size'];
        $harvest_product->is_posted = "Pending";


        // bind the image value
        $image=!empty($_FILES["product_image"]["name"])
        ? sha1_file($_FILES['product_image']['tmp_name']) . "-" . basename($_FILES["product_image"]["name"]) : "";
        $harvest_product->product_image = $image;

        $price = $harvest_product->price_per_unit = round($selling_price, 2);


        if ($harvest_product->createProduct()) {
            echo "
                <div class='container mt-3'>
                <div class='alert alert-success alert-dismissible fade show shadow-sm border-0' role='alert' 
                    style='border-radius: 12px; font-size: 0.95rem;'>
                    <i class='bi bi-check-circle-fill me-2'></i> 
                    <strong>Success!</strong> Product information has been saved successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                </div>
                ";
            if ($harvest_product->uploadPhoto()) {
                echo "";
            }
        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not saved.</div></div>";
        }
    }

    // ===== UPDATE =====
    elseif ($_POST['action'] == 'update') {

        $planted_area = isset($_POST['lot_size']) ? (float)str_replace(',', '', $_POST['lot_size']) : 0;
        $plant_count = isset($_POST['plant_count']) ? (float)str_replace(',', '', $_POST['plant_count']) : 0;
        $kilo_per_plant = isset($_POST['kilo_per_plant']) ? (float)str_replace(',', '', $_POST['kilo_per_plant']) : 0;
        $farm_expense = isset($_POST['total_plant_expense']) ? (float)str_replace(',', '', $_POST['total_plant_expense']) : 0;
        // $total_farm_size = isset($_POST['farm_size_sqm']) ? (float)str_replace(',', '', $_POST['farm_size_sqm']) : 0;

        // General markup (50% profit)
        $markup = 0.015 * 100;

        // Example: general yield for vegetables ~0.06–0.08 kg/sqm (use 0.08 default)
        

        // Prevent division by zero
        if ($planted_area > 0 && $farm_expense > 0) {

            
            // Expense allocated to the planted area
            $kilo_harvested_product = $plant_count * $kilo_per_plant;

            // Prevent zero division
            if ($kilo_harvested_product <= 0) {
                $kilo_harvested_product = 1;
            }

            // $stocks = $plant_count * $kilo_per_plant;

            // Cost per kg
            $cost_per_kg = $farm_expense / $kilo_harvested_product;


            // Selling price with markup
            $selling_price = $cost_per_kg * $markup;

            // Rounded price (currency format)
            $harvest_product->price_per_unit = round($selling_price, 2);

        } else {
            $harvest_product->price_per_unit = 0;
        }

        $harvest_product->user_id = $_SESSION['user_id'];
        $harvest_product->id = $_POST['product_id'];
        $harvest_product->product_name = $_POST['product_name'];
        $harvest_product->category = $_POST['category'];
        $harvest_product->unit = $_POST['unit'];
        $harvest_product->expense =['farm_expense'];
        $harvest_product->product_description = $_POST['product_description'];
		$harvest_product->lot_size = $_POST['lot_size'];
        $harvest_product->is_posted = "Pending";

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
        $product->price_per_unit = $_POST['selling_price'];
        $product->category = $_POST['category'];
        $product->unit = $_POST['unit'];
        $product->total_stocks = $_POST['total_stocks'];
        $product->available_stocks = $_POST['total_stocks'];
        $product->product_description = $_POST['product_description'];
		$product->lot_size = $_POST['lot_size'];
        $product->product_image = $_POST['product_image'] ?? 'default.png';
        $product->status = "Active";
        $product->product_type = "harvest";

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

$farm_lot = $farm->getFarmLot();
$harvest_product->user_id = $_SESSION['user_id'];
$count_total_product = $harvest_product->harvestCount();
$product_price = $harvest_product->SumOfHarvest();
$count_posted_product = $harvest_product->postedProductCount();
$count_pending_product = $harvest_product->pendingProductCount();

if ($count_total_product > 0) {
    $avg_price = $product_price / $count_total_product;
} else {
    $avg_price = 0; // or null, or whatever default you want
}

// include the stats cards
include_once "../statistics/stats.php";
include_once "template/man_harvest.php";
?>


<!-- pass the php post methods from php to JS -->
<script>
//for UPDATE post method
const UpdatePostURL = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>";
//for PRODUCT POSTING post method
const ProductPostingURL = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>";
</script>

<script src="/HarvestHub/js/user/farmer/modals/farm_product/farm_product_modal.js"></script>
<?php include_once "../layout/layout_foot.php"; ?>
