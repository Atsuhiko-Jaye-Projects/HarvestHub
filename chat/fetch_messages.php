<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config.php';


$stmt = $db->query("SELECT * FROM chat_messages ORDER BY id DESC LIMIT 50");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);