<?php
include_once "../../../config/database.php";
include_once "../../../objects/cart_item.php";

$database = new Database();
$db = $database->getConnection();

$cart_item = new CartItem($db);

$id = $_POST['id'] ?? null;

if (!$id) {
    echo "error: no id provided";
    exit;
}

if ($cart_item->deleteCartItem()) {
    echo "success";
} else {
    echo "error";
}
?>
