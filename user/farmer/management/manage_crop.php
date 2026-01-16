<?php
ob_start();

include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/crop.php";
include_once "../../../objects/product.php";
include_once "../../../objects/farm.php";
include_once "../../../objects/farm-resource.php";
include_once "../../../objects/user.php";
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

// get Farm input crops
$page_url = "{$home_url}user/farmer/management/manage_crop.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
$crop->user_id = $_SESSION['user_id'];

$crop_stmt = $crop->readAllCrop($from_record_num, $records_per_page);
$crop_num = $crop_stmt->rowCount();
$total_rows = $crop->countAll();


$crop->user_id = $_SESSION['user_id'];
$farm_stats = $crop->getFarmStats();

// get the lot used for the farm



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
        $crop->farm_resource_id = $_POST['farm_resource_id'];
        // we bind values from farmer to crop 
        $crop->province = $farmer->province;
        $crop->municipality = $farmer->municipality;
        $crop->baranggay = $farmer->baranggay;
        $crop->crop_status = "crop planted";

        // also bind a values for farm-resource to update the crop status
        $farm_resource->farm_resource_id = $_POST['farm_resource_id'];
        $farm_resource->crop_status = "crop planted";

        // record the additional used_lot_size
        $farm->additional_used_size = $_POST['cultivated_area'];
        $farm->user_id = $_SESSION['user_id'];
        
        // verify if the user posted used lot size is valid
        $lotSize = $farm->getLotSizeInfo(); // fetch total and used
        $totalLotSize = $lotSize['lot_size'];
        $usedLotSize  = $lotSize['used_lot_size'];

        $cultivatedArea = $_POST['cultivated_area'];
        $availableLot   = $totalLotSize - $usedLotSize;

        if ($cultivatedArea <= 0) {
                $_SESSION['flash'] = [
                    'title' => 'Failed!',
                    'text'  => 'Cultivated area must be greater than 0.',
                    'icon'  => 'error' // 'success', 'error', 'warning', 'info'
                ];
        } elseif ($cultivatedArea > $availableLot) {
                $_SESSION['flash'] = [
                    'title' => 'Failed!',
                    'text'  => "Error: You only have $availableLot sqm left in your farm. You cannot use $cultivatedArea sqm.",
                    'icon'  => 'error' // 'success', 'error', 'warning', 'info'
                ];
            $error = "Error: You only have $availableLot sqm left in your farm. You cannot use $cultivatedArea sqm.";
        } else {
            if ($crop->createCrop()) {
                // mark the crop as planted and the farm resource
                $crop->MarkCropAsPlanted();
                $farm_resource->MarkCropAsPlanted();
                $farm->addUsedLotSize();

                $_SESSION['flash'] = [
                    'title' => 'Success!',
                    'text'  => 'New has been addedd successfully.',
                    'icon'  => 'success' // 'success', 'error', 'warning', 'info'
                ];
            } else {
                echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not saved.</div></div>";
            }

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
        $crop->crop_status = $_POST['mark_crop'] ?? "";
        
        
        if ($crop->updateFarmProduct()) {
            if ($_POST['mark_crop'] == "harvested") {
                $farm->user_id = $_SESSION['user_id'];
                $farm->deduct_used_size = $_POST['cultivated_area'];
                $farm->deductUsedLotSize();

                
                // bind the posted values to the harvest crop property
                $plant_count = isset($_POST['plant_count']) ? (float)str_replace(',', '', $_POST['plant_count']) : 0;
                $kilo_per_plant = isset($_POST['kilo_per_plant']) ? (float)str_replace(',', '', $_POST['kilo_per_plant']) : 0;
                $farm_expense = isset($_POST['total_plant_expense']) ? (float)str_replace(',', '', $_POST['total_plant_expense']) : 0;
                $total_farm_size = isset($_POST['cultivated_area']) ? (float)str_replace(',', '', $_POST['cultivated_area']) : 0;

                // General markup (50% profit)
                $markup = 0.20;

                // Example: general yield for vegetables ~0.06–0.08 kg/sqm (use 0.08 default)
                

                // Prevent division by zero
                if ($farm_expense > 0 && $total_farm_size > 0) {

                    
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
                $harvest_product->product_name = $_POST['crop_name'];
                $harvest_product->total_stocks = $stocks;
                $harvest_product->plant_count = $_POST['plant_count'];
                $harvest_product->expense = $_POST['total_plant_expense'];
                $harvest_product->lot_size = $_POST['cultivated_area'];
                $harvest_product->category = "Not Set";
                $harvest_product->unit = "KG";
                $harvest_product->kilo_per_plant = $_POST['kilo_per_plant'];
                $harvest_product->is_posted = "Pending";
                
                $harvest_product->createProduct();
                $crop->id = $_POST['id'];
                $crop->status = "posted";
                $crop->cropPosted();
                
                $_SESSION['flash'] = [
                'title' => 'Success!',
                'text'  => 'Crop has been updated harvested.',
                'icon'  => 'success' // 'success', 'error', 'warning', 'info'
                ];

            }else{
                $_SESSION['flash'] = [
                    'title' => 'Success!',
                    'text'  => 'Crop has been updated successfully.',
                    'icon'  => 'success' // 'success', 'error', 'warning', 'info'
                ];
            }
        }else {
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

        //update the crop status to posted


        $image=!empty($_FILES["crop_image"]["name"])
        ? sha1_file($_FILES['crop_image']['tmp_name']) . "-" . basename($_FILES["crop_image"]["name"]) : "";
        $product->product_image = $image;

        if ($product->postCrop()) {
            $product->uploadPhoto();
            $crop->id = $_POST['id'];
            $crop->status = "posted";
            $crop->cropPosted();

                $_SESSION['flash'] = [
                    'title' => 'Success!',
                    'text'  => 'Crop has been updated successfully.',
                    'icon'  => 'success' // 'success', 'error', 'warning', 'info'
                ];
        }
    }

}

// get the users farm lot_size
$farm->user_id = $_SESSION['user_id'];

$farm_lot = $farm->getFarmLot();
// include the stats cards
include_once "../statistics/stats.php";
include_once "template/man_crop.php";
?>


<script>
    const UpdatePostURL = "<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
    const PostCropURL = "<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
</script>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    title: <?= json_encode($_SESSION['flash']['title']) ?>,
    text: <?= json_encode($_SESSION['flash']['text']) ?>,
    icon: <?= json_encode($_SESSION['flash']['icon']) ?>,
    showConfirmButton: false, // ❌ no OK button
}).then(() => {
   window.location.href = window.location.pathname;
});

</script>

<script>
document.addEventListener("shown.bs.modal", function (e) {
    const modal = e.target;
    if (!modal.id.startsWith("update-crop-modal-")) return;

    const plantedInput = modal.querySelector("input[name='date_planted']");
    const harvestInput = modal.querySelector("input[name='estimated_harvest_date']");

    if (!plantedInput || !harvestInput) return;

    function validateHarvestDate() {
        if (!plantedInput.value || !harvestInput.value) return;

        const plantedDate = new Date(plantedInput.value);
        const harvestDate = new Date(harvestInput.value);

        // Normalize time
        plantedDate.setHours(0,0,0,0);
        harvestDate.setHours(0,0,0,0);

        const diffDays = Math.round(
            (harvestDate - plantedDate) / (1000 * 60 * 60 * 24)
        );

        // ❌ Same day or past
        if (diffDays <= 0) {
            Swal.fire({
                icon: "error",
                title: "Invalid Harvest Date",
                text: "Estimated harvest date must be AFTER the date planted."
            });
            harvestInput.value = "";
            return;
        }

        // ❌ Less than 45 days
        if (diffDays < 45) {
            Swal.fire({
                icon: "error",
                title: "Too Early",
                text: "Estimated harvest must be at least greater than 45 days after planting."
            });
            harvestInput.value = "";
            return;
        }

        // ⚠️ Exactly 45 days (real-world warning)
        if (diffDays === 45) {
            Swal.fire({
                icon: "warning",
                title: "Minimum Growth Period",
                text: "45 days is the minimum growth period. Actual harvest may vary depending on crop condition."
            });
        }
    }

    plantedInput.addEventListener("change", validateHarvestDate);
    harvestInput.addEventListener("change", validateHarvestDate);
});
</script>

<script>
document.addEventListener("shown.bs.modal", function (e) {
    const modal = e.target;
    if (!modal.id.startsWith("new-crop-modal")) return;

    const plantedInput = modal.querySelector("input[name='date_planted']");
    const harvestInput = modal.querySelector("input[name='estimated_harvest_date']");

    if (!plantedInput || !harvestInput) return;

    function validateHarvestDate() {
        if (!plantedInput.value || !harvestInput.value) return;

        const plantedDate = new Date(plantedInput.value);
        const harvestDate = new Date(harvestInput.value);

        // Normalize time
        plantedDate.setHours(0,0,0,0);
        harvestDate.setHours(0,0,0,0);

        const diffDays = Math.round(
            (harvestDate - plantedDate) / (1000 * 60 * 60 * 24)
        );

        // ❌ Same day or past
        if (diffDays <= 0) {
            Swal.fire({
                icon: "error",
                title: "Invalid Harvest Date",
                text: "Estimated harvest date must be AFTER the date planted."
            });
            harvestInput.value = "";
            return;
        }

        // ❌ Less than 45 days
        if (diffDays < 45) {
            Swal.fire({
                icon: "error",
                title: "Too Early",
                text: "Estimated harvest must be at least greater than 45 days after planting."
            });
            harvestInput.value = "";
            return;
        }

        // ⚠️ Exactly 45 days (real-world warning)
        if (diffDays === 45) {
            Swal.fire({
                icon: "warning",
                title: "Minimum Growth Period",
                text: "45 days is the minimum growth period. Actual harvest may vary depending on crop condition."
            });
        }
    }

    plantedInput.addEventListener("change", validateHarvestDate);
    harvestInput.addEventListener("change", validateHarvestDate);
});
</script>
<?php unset($_SESSION['flash']); ?>
<?php include_once "../layout/layout_foot.php"; ?>
