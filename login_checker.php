<?php

$current_url = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['logged_in'], $_SESSION['user_type']) &&
    $_SESSION['logged_in'] === true &&
    $_SESSION['user_type'] == "Admin" &&
    strpos($current_url, 'admin/index.php') === true) {
    header("Location: {$home_url}user/admin/index.php?action=success");
    exit();
}

else if (isset($_SESSION['logged_in'], $_SESSION['user_type']) &&
    $_SESSION['logged_in'] === true &&
    $_SESSION['user_type'] == "Farmer" &&
    strpos($current_url, 'farmer/index.php') === true) {

    header("Location: {$home_url}user/farmer/index.php?action=success");
    exit();
}

else if (isset($_SESSION['logged_in'], $_SESSION['user_type']) &&
    $_SESSION['logged_in'] === true &&
    $_SESSION['user_type'] == "Consumer" &&
    strpos($current_url, 'consumer/index.php') === true) {

    header("Location: {$home_url}user/consumer/index.php?action=success");
    exit();
}

// Require login enforcement
if (isset($require_login) && $require_login === true) {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: {$home_url}signin.php?action=please_login");
        exit();
    }

}

?>