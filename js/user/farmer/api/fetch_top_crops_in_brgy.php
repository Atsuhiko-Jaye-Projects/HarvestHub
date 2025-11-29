<?php
header("Content-Type: application/json");

// Include config & objects
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/crop.php";
include_once "../../../../objects/farm.php";

$database = new Database();
$db = $database->getConnection();

$crop = new Crop($db);
$farmer = new Farm($db);

// get the farmer location base on session
$farmer->user_id = $_SESSION['user_id'];
$farmer->getFarmerLocation();

$crop->baranggay = $farmer->baranggay;

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}


// Fetch data
$data = $crop->topCropInArea();

// Return as JSON
echo json_encode([
    "status" => "success",
    "records" => $data
]);
