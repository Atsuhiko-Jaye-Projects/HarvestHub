<?php
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/cart_item.php";

$database = new Database();
$db = $database->getConnection();

$cart_item = new CartItem($db);
$cart_item->user_id = $_SESSION['user_id'];


// Fetch records and total count
$result = $cart_item->countItem();


header('Content-Type: application/json');
echo json_encode(["cart_item_count" => (int)$result]);
