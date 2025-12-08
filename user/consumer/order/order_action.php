<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/order_status_history.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$order_status_history = new OrderHistory($db);


if (!empty($_POST['action']) && in_array($_POST['action'],['cancel order', 'confirmed', 'received order'])) {
    
    if ($_POST['action']) {

        switch ($_POST['action']) {

            case 'cancel order':
                // read POST
                $order->reason = $_POST['reason'] ?? null;
                $order->id = $_POST['order_id'] ?? null;
                $order->status = "order cancelled";

                // record the order history
                $order_status_history->invoice_number = $_POST['invoice_number'];
                $order_status_history->product_id = $_POST['product_id'];
                $order_status_history->status = "order cancelled";
                $order_status_history->timestamp = date("Y-m-d H:i:s");


                if ($order->cancelOrder()) {
                    $order_status_history->recordStatus();
                    echo "success";
                } else {
                    echo "error";
                }
            break;

            case 'confirmed':
                $order->id = $_POST['order_id'] ?? null;
                $order->status = "order confirmed";
                $order->modified_at = date("Y-m-d H:i:s");
                

                // record the order history
                $order_status_history->invoice_number = $_POST['invoice_number'];
                $order_status_history->product_id = $_POST['product_id'];
                $order_status_history->status = "order confirmed";
                $order_status_history->timestamp = date("Y-m-d H:m:s");



                if ($order->confirmOrder()) {
                    $order_status_history->recordStatus();
                    echo "success";
                } else {
                    echo "error";
                }
            break;

            case 'received order':
                $order->id = $_POST['order_id'] ?? null;
                $order->status = "complete";
                $order->modified_at = date("Y-m-d H:i:s");

                // record the order history
                $order_status_history->invoice_number = $_POST['invoice_number'];
                $order_status_history->product_id = $_POST['product_id'];
                $order_status_history->status = "order recieved";
                $order_status_history->timestamp = date("Y-m-d H:m:s");


                // receieved order  works only on pre-orders 
                if ($order->recievedPreOrder()) {
                    $order_status_history->recordStatus();
                    echo "success";
                } else {
                    echo "error";
                }
            break;

            
            default:
                # code...
                break;
        }
    }
}
