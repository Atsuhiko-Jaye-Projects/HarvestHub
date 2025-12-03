<?php
include_once "config/database.php";
include_once "objects/user.php";

$token = $_GET['token'] ?? '';
$verified = false;
$message = '';

if (!empty($token)) {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->verification_token = $token;

    if ($user->verifyAccount()) {
        $verified = true;
        $message = "Your account has been successfully verified!";
    } else {
        $message = "This verification link is invalid or has expired.";
    }
} else {
    $message = "No verification token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HarvestHub | Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background: #f6f7fb; }
        .card { border-radius: 15px; animation: fadeIn 0.6s ease; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon {
            font-size: 70px;
        }
    </style>
</head>

<body>

<script>
document.addEventListener("DOMContentLoaded", function () {
    <?php if ($verified): ?>
        Swal.fire({
            icon: "success",
            title: "Email Verified!",
            text: "<?php echo $message; ?>",
            confirmButtonColor: "#28a745"
        });
    <?php else: ?>
        Swal.fire({
            icon: "error",
            title: "Verification Failed",
            text: "<?php echo $message; ?>",
            confirmButtonColor: "#dc3545"
        });
    <?php endif; ?>
});
</script>

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow p-4 text-center" style="max-width: 420px; width: 100%;">

        <?php if ($verified): ?>
            <div class="text-success icon mb-3">✔</div>
            <h2 class="fw-bold text-success">Email Verified</h2>
            <p class="text-muted"><?php echo htmlspecialchars($message); ?></p>
            <a href="signin.php" class="btn btn-success w-100 mt-3">Proceed to Login</a>

        <?php else: ?>
            <div class="text-danger icon mb-3">✖</div>
            <h2 class="fw-bold text-danger">Verification Failed</h2>
            <p class="text-muted"><?php echo htmlspecialchars($message); ?></p>
            <a href="signup.php" class="btn btn-danger w-100 mt-3">Back to Register</a>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
