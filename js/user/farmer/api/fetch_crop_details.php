<?php
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/farm-resource.php";

$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);

// Fetch records and total count
$crop_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
//$crop_id = 1;
$farm_resource->id = $crop_id;
$result = $farm_resource->readCropDetails();
$row = $result->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode([
    "average_yield_per_plant" => $row['average_yield_per_plant'],
    "plant_count" => $row['plant_count'],
    "planted_area_sqm" => $row['planted_area_sqm']
], JSON_PRETTY_PRINT);
