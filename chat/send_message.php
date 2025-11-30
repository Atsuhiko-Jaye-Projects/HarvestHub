<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';


if(!isset($_POST['message']) || trim($_POST['message']) == '') exit('error');

$user_id = intval($_POST['user_id']);
$message = trim($_POST['message']);

$stmt = $db->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
$stmt->execute([$user_id, $message]);

echo 'ok';
?>
