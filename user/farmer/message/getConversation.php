<?php
include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/conversation.php';
include_once '../../../objects/message.php';
include_once '../../../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user_id = intval($_SESSION['user_id']); // logged-in user

$conversation = new Conversation($db);


$conversation->property_sender_id = $user_id;
// $message->property_receiver = $farmer_id;

$conversations = $conversation->getUserConversations();
echo json_encode($conversations);

?>
