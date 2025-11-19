<?php
header("Content-Type: application/json");

// Include config & objects
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/crop.php"; // <-- your crop object

$database = new Database();
$db = $database->getConnection();

$crop = new Crop($db);

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$crop->user_id = $_SESSION['user_id'];

// Fetch data
$data = $crop->getMostPlanted();

// Return as JSON
echo json_encode([
    "status" => "success",
    "records" => $data
]);
