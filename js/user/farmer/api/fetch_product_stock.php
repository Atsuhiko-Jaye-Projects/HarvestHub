<?php

header("Content-Type: application/json");

// Include config & objects
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product_status = new Product($db);

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$product_status->user_id = $_SESSION['user_id'];

$data = $product_status->getProductStock();

echo json_encode([
    "status" => "success",
    "product_stock" => $data
]);


?>