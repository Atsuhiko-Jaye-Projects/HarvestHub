<?php
header("Content-Type: application/json");

include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/user.php";

$response = ["success" => false, "message" => "Unknown error occurred"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "update_profile") {

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->id = $_SESSION['user_id'];
    $user->user_type = $_SESSION['user_type'];
    $user->firstname = $_POST['firstname'] ?? "";
    $user->lastname = $_POST['lastname'] ?? "";
    $user->contact_number = $_POST['contact_number'] ?? "";
    $user->address = $_POST['address'] ?? "";
    $user->municipality = $_POST['municipality'] ?? "";
    $user->barangay = $_POST['barangay'] ?? "";
    $user->province = $_POST['province'] ?? "";

    // Handle profile picture
    if (!empty($_FILES['profile_pic']['name'])) {
        $image = sha1_file($_FILES['profile_pic']['tmp_name']) . "-" . basename($_FILES['profile_pic']['name']);
        $user->profile_pic = $image;
    }

    if ($user->updateUserProfile()) {
        if (!empty($image) && $user->uploadPhoto()) {
            $response['message'] = "Profile updated successfully with new photo";
        } else {
            $response['message'] = "Profile updated successfully";
        }
        $response['success'] = true;
    } else {
        $response['message'] = "Failed to update profile";
    }
} else {
    $response['message'] = "Invalid request";
}

echo json_encode($response);
