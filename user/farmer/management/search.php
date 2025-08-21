<?php 
include '../../../config/core.php';
include_once "../../../config/database.php";
include_once "../../../objects/harvest_product.php";

$page_title = "Manage Product";
include_once "../layout/layout_head.php";

// set the login require to true
$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);
$harvest_product->user_id = $_SESSION['user_id'];

$search_term = isset($_GET['s']) ? $_GET['s'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;

if (!empty($search_term)) {
    $stmt = $harvest_product->search($search_term, $from_record_num, $records_per_page);
    $total_rows = $harvest_product->countAll_BySearch($search_term);
    $page_url = "{$home_url}user/farmer/management/search.php?s=" . urlencode($search_term) . "&";
} else {
    $stmt = $harvest_product->readAllProduct($from_record_num, $records_per_page);
    $total_rows = $harvest_product->countAll();
    $page_url = "{$home_url}user/farmer/management/search.php?";
}

$num = $stmt->rowCount();

// include stats card
include_once "../statistics/stats.php";

// include the management product template
include_once "template/man_product.php";

include_once "../layout/layout_foot.php"; 
?>
