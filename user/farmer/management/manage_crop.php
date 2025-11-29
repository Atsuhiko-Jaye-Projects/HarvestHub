<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/crop.php";
include_once "../../../objects/product.php";
include_once "../../../objects/farm.php";
include_once "../../../objects/farm-resource.php";
include_once "../../../objects/user.php";
print_r($_SESSION);

$page_title = "Manage Crop";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$crop = new Crop($db);
$product = new Product($db);
$farm = new Farm($db);
$farm_resource = new FarmResource($db);

// get the user location
$farmer = new Farm($db);

$farmer->user_id = $_SESSION['user_id'];
$fetch_farm_location = $farmer->getFarmerLocation();




$page_url = "{$home_url}user/farmer/management/manage_harvest.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
$crop->user_id = $_SESSION['user_id'];




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    include_once "../../../config/database.php";
    include_once "../../../objects/harvest_product.php";


    $database = new Database();
    $db = $database->getConnection();
    $harvest_product = new HarvestProduct($db);


    // ===== CREATE =====
    if ($_POST['action'] == 'create') {

        $kilo_per_plant = isset($_POST['kilo_per_plant']) ? (float)str_replace(',', '', $_POST['kilo_per_plant']) : 0;
        $plant_counts = isset($_POST['plant_count']) ? (float)str_replace(',', '', $_POST['plant_count']) : 0;

        // Prevent division by zero
        if ($kilo_per_plant > 0 && $plant_counts > 0) {

            $estimated_stocks = ($plant_counts * $kilo_per_plant);
        
        } else {
            $harvest_product->price_per_unit = 0;
        }

        

        $crop->user_id = $_SESSION['user_id'];
        $crop->crop_name = $_POST['crop_name'];
        $crop->date_planted = $_POST['date_planted'];
        $crop->estimated_harvest_date = $_POST['estimated_harvest_date'];
        $crop->yield = $_POST['kilo_per_plant'];
        $crop->plant_count = $_POST['plant_count'];
        $crop->stocks =  $estimated_stocks;
        $crop->cultivated_area = $_POST['cultivated_area'];
        // we bind values from farmer to crop 
        $crop->province = $farmer->province;
        $crop->municipality = $farmer->municipality;
        $crop->baranggay = $farmer->baranggay;

        if ($crop->createCrop()) {
            echo "<div class='container'><div class='alert alert-success'>Crop Info Saved!</div></div>";
        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not saved.</div></div>";
        }
    }

    // ===== UPDATE =====
    elseif ($_POST['action'] == 'update') {

        $crop->id = $_POST['id'];
        $crop->user_id = $_SESSION['user_id'];
        $kilo_per_plant = isset($_POST['kilo_per_plant']) ? (float)str_replace(',', '', $_POST['kilo_per_plant']) : 0;
        $plant_counts = isset($_POST['plant_count']) ? (float)str_replace(',', '', $_POST['plant_count']) : 0;

        if ($kilo_per_plant > 0 && $plant_counts > 0) {

            $estimated_stocks = ($plant_counts * $kilo_per_plant);
        
        } else {
            $harvest_product->price_per_unit = 0;
        }

        $crop->user_id = $_SESSION['user_id'];
        $crop->crop_name = $_POST['crop_name'];
        $crop->date_planted = $_POST['date_planted'];
        $crop->estimated_harvest_date = $_POST['estimated_harvest_date'];
        $crop->yield = $_POST['kilo_per_plant'];
        $crop->plant_count = $_POST['plant_count'];
        $crop->stocks =  $estimated_stocks;
        $crop->cultivated_area = $_POST['cultivated_area'];
        $crop->is_posted = "Pending";

        if ($crop->updateFarmProduct()) {
		     echo "<div class='container'><div class='alert alert-success'>Harvest Product Info Updated!</div></div>";

        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not updated.</div></div>";
        }
    }

    else if ($_POST['action'] == 'post_crop') {

        $product->product_name = $_POST['crop_name'];
        $product->product_id = $_POST['id']; // Make sure your form has this hidden input
        $product->user_id = $_SESSION['user_id'];
        $product->price_per_unit = $_POST['price_per_unit'];
        $product->category = $_POST['category'];
        $product->total_stocks = $_POST['stocks'];
        $product->available_stocks = $_POST['stocks'];
        $product->product_description = "Reserve fresh farm produce ahead of time and get it delivered at peak quality.";
        $product->status = "Active";
        $product->product_type = "preorder";

        $image=!empty($_FILES["crop_image"]["name"])
        ? sha1_file($_FILES['crop_image']['tmp_name']) . "-" . basename($_FILES["crop_image"]["name"]) : "";
        $product->product_image = $image;

        if ($product->postCrop()) {
            $product->uploadPhoto();
            echo "<div class='container'><div class='alert alert-success'>Crop has been Posted!</div></div>";
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
include_once "template/man_crop.php";
?>


<script>
    const UpdatePostURL = "<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
    const PostCropURL = "<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
</script>
<?php include_once "../layout/layout_foot.php"; ?>
