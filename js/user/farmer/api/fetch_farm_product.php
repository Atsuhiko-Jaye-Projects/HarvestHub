<?php
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/harvest_product.php";

$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);
$harvest_product->user_id = $_SESSION['user_id'];

// Pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;

// Fetch records and total count
$result = $harvest_product->readAllProduct($from_record_num, $records_per_page);

$records = $result['records'];
$total_rows = $result['total_rows'];

// Build full image path
foreach ($records as &$row) {
    $row['product_image_path'] = !empty($row['product_image'])
        ? $base_url . "user/uploads/" . $_SESSION['user_id'] . "/products/" . $row['product_image']
        : $base_url . "user/uploads/default.png";
}

// Calculate total pages
$total_pages = ceil($total_rows / $records_per_page);

header('Content-Type: application/json');
echo json_encode([
    "records" => $records,
    "total_rows" => $total_rows,
    "current_page" => $page,
    "total_pages" => $total_pages
], JSON_PRETTY_PRINT);
