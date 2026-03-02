<?php
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/production_data.php";

$database = new Database();
$db = $database->getConnection();

$crop_production_details = new CropProductionDetails($db);

header('Content-Type: application/json');

if (!isset($_POST['plant_name']) || empty($_POST['plant_name'])) {
    echo json_encode([
        "success" => false,
        "message" => "No plant name provided"
    ]);
    exit;
}

$crop_production_details->crop_name = $_POST['plant_name'];

$result = $crop_production_details->getAverageYield();
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row && isset($row['yield_per_plant'])) {
    echo json_encode([
        "success" => true,
        "average_yield_per_plant" => $row['yield_per_plant']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "average_yield_per_plant" => 0
    ]);
}