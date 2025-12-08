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

$sender_id = intval($_POST['sender_id']);
$farmer_id = intval($_POST['farmer_id']);
$message_text = trim($_POST['message']);

// Validate input
if (empty($message_text)) {
    echo "Message cannot be empty";
    exit;
}

// 1️⃣ Get or create conversation
//$conversation_code = $conversation->getOrCreate($sender_id, $farmer_id);

// 2️⃣ Set message properties
$message->sender_id = $sender_id;
$message->message = $message_text;

// 3️⃣ Send message
if ($message->sendMessage()) {
    echo "message sent";
} else {
    echo "message not sent";
    // optional debug
    print_r($message->conn->errorInfo());
}
?>
