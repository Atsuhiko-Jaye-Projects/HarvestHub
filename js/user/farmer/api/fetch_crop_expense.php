<?php
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/farm-resource.php";

$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);

// Fetch records and total count
$farm_resource_id = $_GET['id'] ?? '';
//$farm_resource_id = "FID694131376";
$farm_resource->farm_resource_id = $farm_resource_id;
$result = $farm_resource->getResourceExpense();
$row = $result->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode([
    "grand_total" => $row['grand_total']
], JSON_PRETTY_PRINT);
