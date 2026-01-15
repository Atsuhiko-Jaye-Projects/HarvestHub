<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/config/core.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/config/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/objects/order_status_history.php";

$database = new Database();
$db = $database->getConnection();

$order_status_history = new OrderHistory($db);

$order_status_history->invoice_number = $_POST['invoice'];
$order_status_history->id = $_POST['notif_id'];
//$order_status_history->notif_viewed = 1;

$order_status_history->markNotifcation();

?>