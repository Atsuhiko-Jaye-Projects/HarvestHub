<?php

include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/message.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

$message = new Message($db);

// Get conversation id from GET
$user_id = $_SESSION['user_id'];
// // Get farmer ID (optional)
$farmer_id = isset($_GET['fid']) ? intval($_GET['fid']) : 0;

// 🔥 Correct: read conversation ID from 'cid'
$conversation_id = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

$message->conversation_id = $conversation_id;
$message->property_sender_id = $user_id;
$message->property_receiver = $farmer_id;

if ($conversation_id > 0) {
    $messages = $message->getMessagesByConversation();
    echo json_encode($messages);
} else {
    echo json_encode([]);
}
?>
