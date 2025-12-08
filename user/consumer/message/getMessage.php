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
// $farmer_id = isset($_GET['fid']) ? intval($_GET['fid']) : 0;

// 🔥 Correct: read conversation ID from 'cid'
$conversation_id = isset($_GET['cid']) ? intval($_GET['cid']) : 0;


if ($conversation_id > 0) {
    $messages = $message->getMessagesByConversation($conversation_id);
    echo json_encode($messages);
} else {
    echo json_encode([]);
}
?>
