<?php 
include '../../../config/core.php';
include_once "../../../config/database.php";
include_once "../../../objects/farm-resource.php";

$page_title = "Farm Resources & supplies";
include_once "../layout/layout_head.php";

// set the login require to true
$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);

$farm_resource->user_id = $_SESSION['user_id'];
$search_term = isset($_GET['s']) ? $_GET['s'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;

if (!empty($search_term)) {
    $stmt = $farm_resource->search($search_term, $from_record_num, $records_per_page);
    $total_rows = $farm_resource->countAll_BySearch($search_term);
    $page_url = "{$home_url}user/farmer/farm/search.php?s=" . urlencode($search_term) . "&";
} else {
    $stmt = $farm_resource->readAllProduct($from_record_num, $records_per_page);
    $total_rows = $harvest_product->countAll();
    $page_url = "{$home_url}user/farmer/farm/search.php?";
}

$num = $stmt->rowCount();

// include stats card
include_once "../statistics/stats.php";

// include the management product template
include_once "template/farm_resource_template.php";

include_once "../layout/layout_foot.php"; 
?>

