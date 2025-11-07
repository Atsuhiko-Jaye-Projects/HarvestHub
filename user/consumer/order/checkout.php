<?php 
$invoice = isset($_GET['invoice']) ? htmlspecialchars($_GET['invoice']) : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ Important for mobile scaling -->
  <title>Order Successful</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #d4fc79, #96e6a1);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Poppins", sans-serif;
      padding: 15px; /* ✅ Adds breathing space on small screens */
    }

    .card {
      width: 100%;
      max-width: 420px; /* ✅ Scales nicely for Android */
      border: none;
      border-radius: 1.2rem;
      background: #fff;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      padding: 2rem 1.5rem;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .check-icon {
      font-size: 3.5rem;
      color: #28a745;
      animation: pop 0.5s ease;
    }

    @keyframes pop {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    h3 {
      font-size: 1.4rem;
    }

    .btn {
      border-radius: 10px;
      padding: 0.75rem;
      font-size: 1rem;
    }

    .alert {
      font-size: 0.9rem;
    }

    .countdown {
      font-weight: bold;
      color: #28a745;
    }

    /* ✅ Better touch spacing for small devices */
    @media (max-width: 480px) {
      .check-icon {
        font-size: 3rem;
      }
      h3 {
        font-size: 1.2rem;
      }
      .btn {
        font-size: 0.95rem;
      }
      .card {
        padding: 1.5rem 1rem;
      }
    }
  </style>
</head>
<body>

  <div class="card text-center shadow-lg">
    <div class="mb-3">
      <i class="bi bi-check-circle-fill check-icon"></i>
    </div>
    <h3 class="fw-bold mb-2">Order Placed Successfully!</h3>
    <p class="text-muted mb-3">Thank you for your purchase. Your order has been received and is being processed.</p>

    <p class="fw-semibold mb-1 text-secondary">Invoice Number</p>
    <h5 class="fw-bold text-primary mb-3">#<?php echo $invoice; ?></h5>

    <div class="alert alert-success mb-4 py-2">
      <i class="bi bi-clock-history me-2"></i>
      Redirecting in <span class="countdown" id="timer">10</span> seconds...
    </div>

    <a href="cart.php" class="btn btn-success w-100 mb-2">
      <i class="bi bi-box-seam me-1"></i> Go to My Cart
    </a>

  </div>

  <script>
    let seconds = 10;
    const timerEl = document.getElementById('timer');

    const countdown = setInterval(() => {
      seconds--;
      timerEl.textContent = seconds;
      if (seconds <= 0) {
        clearInterval(countdown);
        window.location.href = "order.php";
      }
    }, 1000);

    // ✅ Prevent user from going back to checkout
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function() {
      window.history.pushState(null, "", window.location.href);
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
