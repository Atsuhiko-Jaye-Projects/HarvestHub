<?php
// Start output buffering to catch any stray output
ob_start();

// Set JSON header
header('Content-Type: application/json');

// Array to store PHP errors/warnings/notices
$errors = [];

// Custom error handler to capture PHP notices/warnings
set_error_handler(function($errno, $errstr, $errfile, $errline) use (&$errors) {
    $errors[] = "Error [$errno] $errstr in $errfile on line $errline";
    return true; // prevent default output
});

// Exception handler
set_exception_handler(function($exception) use (&$errors) {
    $errors[] = "Exception: ".$exception->getMessage();
});

// Enable all errors for logging
error_reporting(E_ALL);

include_once "config/database.php";
include_once "objects/user.php";
include_once "objects/password_reset.php";
include_once "objects/util.php"; // Make sure the path is correct

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method");
    }

    if (!isset($_POST['email_address']) || empty(trim($_POST['email_address']))) {
        throw new Exception("Email address is required");
    }

    $email_address = trim($_POST['email_address']);

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $password_reset = new PasswordReset($db);
    $mailer = new Mailer();

    $user->email_address = $email_address;

    if (!$user->emailAddressExists()) {
        throw new Exception("Email not found");
    }

    // Generate token
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $password_reset->email_address = $email_address;
    $password_reset->token = $token;
    $password_reset->expires_at = $expires;

    if (!$password_reset->generateToken()) {
        throw new Exception("Failed to generate reset token");
    }

    // Prepare email
    $reset_link = "http://localhost/reset_password.php?token=$token";
    $subject = "HarvestHub Password Reset";
    $body = "
        <h3>Hello!</h3>
        <p>You requested to reset your HarvestHub password.</p>
        <p>Click the link below to reset it:</p>
        <a href='$reset_link'>$reset_link</a>
        <p><small>This link is valid for 1 hour.</small></p>
    ";

    $result = $mailer->send($email_address, $subject, $body);

    if ($result !== true) {
        throw new Exception("Mailer error: $result");
    }

    // Send JSON response
    echo json_encode([
        "status" => "success",
        "message" => "Reset link sent successfully"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage(),
        "php_errors" => $errors
    ]);
}

// Ensure no extra output
ob_end_flush();
exit;
