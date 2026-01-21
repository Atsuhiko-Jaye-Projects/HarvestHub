<?php
header("Content-Type: application/json");

include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/crop.php";
include_once "../../../../objects/farm-resource.php";

$database = new Database();
$db = $database->getConnection();

$crop = new Crop($db);
$farm_resource = new FarmResource($db);

// ✅ Check request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request"
    ]);
    exit;
}

// ✅ Assign ID
$crop->id = intval($_POST['id']);
$farm_resource->farm_resource_id = intval($_POST['farm_resource_id']);

// ✅ Delete
if ($crop->deleteCrop()) {
    $farm_resource->updateCropStatus();
    echo json_encode([
        "success" => true
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Unable to delete record"
    ]);
}
