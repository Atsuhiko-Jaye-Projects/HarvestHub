<?php
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/message.php';
include_once '../../../objects/conversation.php';

$database = new Database();
$db = $database->getConnection();

// Initialize objects
$message = new Message($db);
$conversation = new Conversation($db);

// Get POST data safely
$farmer_id = intval($_POST['farmer_id']);
$sender_id = intval($_POST['sender_id']);
$msg_text = trim($_POST['message']);

// Set message properties
$message->farmer_id = $farmer_id;
$message->user_id = $sender_id;
$message->message = $msg_text;

// Get or create conversation
$conversation_id = $conversation->getOrCreateConversation($sender_id, $farmer_id);
$message->conversation_id = $conversation_id;

// Send message
if ($message->sendMessage()) {
    echo "message sent"; // Only this should be echoed
} else {
    echo "message not sent";
    // Optionally log errors to PHP logs:
    // error_log(print_r($message->conn->errorInfo(), true));
}
?>
