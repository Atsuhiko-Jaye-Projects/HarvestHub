<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/user.php";
include_once "objects/password_reset.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $response = [
        "status" => "error",
        "message" => "Something went wrong"
    ];

    try {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (empty($token) || empty($password) || empty($confirm)) {
            throw new Exception("All fields are required");
        }

        if ($password !== $confirm) {
            throw new Exception("Passwords do not match");
        }

        $database = new Database();
        $db = $database->getConnection();

        // Verify token
        $password_reset = new PasswordReset($db);
        $password_reset->token = $token;
        $row = $password_reset->verifyToken();

        if (!$row) {
            throw new Exception("Invalid reset link.");
        }

        if (strtotime($row['expires_at']) < time()) {
            throw new Exception("This reset link has expired.");
        }

        // Update user password
        $user = new User($db);
        $user->email_address = $row['email_address'];
        $user->password = $password;

        if (!$user->updatePassword()) {
            throw new Exception("Failed to update password.");
        }

        $response["status"] = "success";
        $response["message"] = "Password updated successfully!";

    } catch (Exception $e) {
        $response["message"] = $e->getMessage();
    }

    echo json_encode($response);
    exit();
}


/* ------------------------------
    2. HANDLE GET (Show UI)
--------------------------------*/
$token = $_GET['token'] ?? '';
$token_valid = false;
$token_message = '';

if (!empty($token)) {
    $database = new Database();
    $db = $database->getConnection();

    $password_reset = new PasswordReset($db);
    $password_reset->token = $token;

    $row = $password_reset->verifyToken();

    if ($row) {
        if (strtotime($row['expires_at']) < time()) {
            $token_message = "This reset link has expired.";
        } else {
            $token_valid = true;
        }
    } else {
        $token_message = "Invalid reset link.";
    }
} else {
    $token_message = "No token provided.";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HarvestHub | Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f6f7fb; }
        .card { border-radius: 15px; animation: fadeIn 0.6s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow p-4" style="max-width: 420px; width: 100%;">
        <div class="text-center mb-3">
            <h2 class="fw-bold text-success">Reset Password</h2>
            <p class="text-muted">Enter your new password below.</p>
        </div>
            <?php if ($token_valid): ?>
                <form id="resetForm">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Reset Password</button>
                </form>
            <?php else: ?>
                <p class="text-danger"><?php echo htmlspecialchars($token_message); ?></p>
            <?php endif; ?>
        <div class="mt-3 text-center">
            <a href="login.php" class="text-decoration-none">Back to Login</a>
        </div>
    </div>
</div>

<script>
document.getElementById("resetForm").addEventListener("submit", async function(e){
    e.preventDefault();

    const formData = new URLSearchParams(new FormData(this));

    Swal.fire({
        title: 'Processing...',
        text: 'Please wait...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        const res = await fetch("", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message
            }).then(() => {
                window.location.href = "signin.php";
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message + (data.php_errors.length ? "\nPHP Errors: " + data.php_errors.join("; ") : "")
            });
        }
    } catch(err) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.'
        });
    }
});
</script>
</body>
</html>