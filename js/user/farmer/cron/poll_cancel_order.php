<?php
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/order.php";
include_once "../../../../objects/order_status_history.php";

$database = new Database();
$db = $database->getConnection();

$order = new order($db);
$order_status_history = new OrderHistory($db);

// Fetch records and total count
//

// fetch the orders thats is order placed more than 30 mins
$result = $order->getPendingCancelOrder();
// /$pending_orders_json = $result->fetchAll(PDO::FETCH_ASSOC);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $order_status_history->product_id = $row['product_id'];
    $order_status_history->status = 'cancelled';
    $order_status_history->invoice_number = $row['invoice_number'];
    $order_status_history->timestamp = date("Y-m-d H:i:s");
    $order_status_history->recordStatus();
    
    // AUTO cancel THE ORDER PLACED 30 MINS AGO
    $order->updateCancelledOrder();
}


header('Content-Type: application/json');
echo json_encode([
    "ok" => true,
    "checked_at" => date("Y-m-d H:i:s"),   
], JSON_PRETTY_PRINT);
