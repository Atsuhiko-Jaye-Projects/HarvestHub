<?php
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/harvest_product.php";

$database = new Database();
$db = $database->getConnection();

$page_url = "{$home_url}user/farmer/management/manage_harvest.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;


$harvest_product = new HarvestProduct($db);

$harvest_product->user_id = $_SESSION['user_id'];
$data = $harvest_product->readAllProduct();

echo json_encode($data, JSON_PRETTY_PRINT);

?>
