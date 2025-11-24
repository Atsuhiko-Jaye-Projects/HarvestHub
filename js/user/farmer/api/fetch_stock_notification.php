<?php

header("Content-Type: application/json");

// Include config & objects
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product_stock = new Product($db);

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$product_stock->user_id = $_SESSION['user_id'];

$data = $product_stock->getProductStockCount();

echo json_encode([
    "status" => "success",
    "product_status" => $data
]);


?>