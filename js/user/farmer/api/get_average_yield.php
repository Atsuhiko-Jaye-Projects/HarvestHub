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

    $distance = $row['distance_of_planting'];
    
    list($width , $height) = explode('x', str_replace(' ', '', $distance));

    $width_spacing = (float)$width;
    $height_spacing = (float)$height;
    $area_per_plant = $width_spacing * $height_spacing;

    echo json_encode([
        "success" => true,
        "average_yield_per_plant" => $row['yield_per_plant'],
        "distance_of_plant" => $row['distance_of_planting'],
        "width" => $width_spacing,
        "height" => $height_spacing,
        "area_per_plant" => $area_per_plant
    ]);
} else {
    echo json_encode([
        "success" => false,
        "average_yield_per_plant" => 0  
    ]);
}