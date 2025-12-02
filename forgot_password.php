<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer or include manually
require 'objects/utils/PHPMailer/src/PHPMailer.php';
require 'objects/utils/PHPMailer/src/SMTP.php';
require 'objects/utils/PHPMailer/src/Exception.php';

// --- Mailer Class ---
class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        try {
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'ajcodalify@gmail.com';
            $this->mail->Password   = 'kppv omij rxyk adyq';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port       = 587;
            $this->mail->setFrom('ajcodalify@gmail.com', 'HarvestHub Support');
        } catch (Exception $e) {
            throw new Exception("Mailer Initialization Error: {$e->getMessage()}");
        }
    }

    public function send($to, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}

// --- Database / User Classes ---
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/user.php";
include_once "objects/password_reset.php";

// --- Handle POST Request ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $errors = [];
    try {
        $email = isset($_POST['email_address']) ? trim($_POST['email_address']) : '';
        if (!$email) throw new Exception("Email address is required");

        $db = (new Database())->getConnection();
        $user = new User($db);
        $password_reset = new PasswordReset($db);
        $mailer = new Mailer();

        $user->email_address = $email;
        if (!$user->emailAddressExists()) throw new Exception("Email not found");

        // Generate token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $password_reset->email_address = $email;
        $password_reset->token = $token;
        $password_reset->expires_at = $expires;

        if (!$password_reset->generateToken()) throw new Exception("Failed to generate reset token");

        // Send email
        $reset_link = "http://localhost/harvesthub/reset_password.php?token=$token";
        $subject = "HarvestHub Password Reset";
$body = "
<div style='font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 40px 0;'>
    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden;'>
        <div style='background-color: #4CAF50; color: white; text-align: center; padding: 30px 20px;'>
            <h1 style='margin: 0;'>HarvestHub</h1>
        </div>
        <div style='padding: 30px 20px; color: #333; line-height: 1.6;'>
            <h2 style='color: #4CAF50;'>Hello!</h2>
            <p>We received a request to reset your HarvestHub password. Don’t worry, we’ve got you covered!</p>
            <p style='text-align: center; margin: 30px 0;'>
                <a href='$reset_link' 
                   style='background-color: #FFA500; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;'>
                    Reset Password
                </a>
            </p>
            <p>If the button above doesn’t work, copy and paste this link into your browser:</p>
            <p style='word-break: break-all;'><a href='$reset_link' style='color: #4CAF50;'>$reset_link</a></p>
            <p style='font-size: 0.9em; color: #777; margin-top: 20px;'>
                This password reset link is valid for 1 hour. If you did not request a password reset, please ignore this email.
            </p>
        </div>
        <div style='background-color: #f4f6f8; text-align: center; padding: 20px; font-size: 0.8em; color: #aaa;'>
            © " . date('Y') . " HarvestHub. All rights reserved.
        </div>
    </div>
</div>
";



        $result = $mailer->send($email, $subject, $body);
        if ($result !== true) throw new Exception($result);

        echo json_encode(['status'=>'success','message'=>'Reset link sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['status'=>'error','message'=>$e->getMessage(),'php_errors'=>$errors]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HarvestHub | Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body { background: #f6f7fb; }
.card { border-radius: 15px; animation: fadeIn 0.6s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card shadow p-4" style="max-width:420px; width:100%;">
        <div class="text-center mb-3">
            <h2 class="fw-bold text-success">HarvestHub</h2>
            <p class="text-muted">Forgot your password? We’ll help you recover access to your account.</p>
        </div>
        <form id="forgotForm">
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email_address" id="email" class="form-control" placeholder="Enter your registered email" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Send Reset Link</button>
        </form>
        <div class="mt-3 text-center">
            <a href="signin.php" class="text-decoration-none">Back to Login</a>
        </div>
    </div>
</div>

<script>
document.getElementById("forgotForm").addEventListener("submit", async function(e){
    e.preventDefault();
    let email = document.getElementById("email").value.trim();

    Swal.fire({title:'Processing...', text:'Please wait...', allowOutsideClick:false, didOpen:()=>Swal.showLoading()});

    try {
        const formData = new URLSearchParams();
        formData.append('email_address', email);

        const res = await fetch("", { method:'POST', body: formData });
        const data = await res.json();

        if(data.status==='success'){
            Swal.fire({icon:'success', title:'Reset Link Sent!', text:data.message});
            document.getElementById("forgotForm").reset();
        } else {
            Swal.fire({icon:'error', title:'Error', text:data.message + (data.php_errors?.length ? "\nPHP Errors: " + data.php_errors.join("; ") : "")});
        }
    } catch(err){
        Swal.fire({icon:'error', title:'Error', text:'Something went wrong. Please try again.'});
    }
});
</script>

</body>
</html>
