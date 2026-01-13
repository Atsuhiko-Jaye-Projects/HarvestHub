<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Harvest Hub | Farm to Table Marketplace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            background: linear-gradient(135deg, #198754, #28a745);
            color: white;
            padding: 80px 20px;
        }
        .feature-icon {
            font-size: 40px;
            color: #198754;
        }
        footer {
            background: #212529;
            color: #bbb;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Harvest Hub</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <!-- <li class="nav-item"><a class="btn btn-light text-success ms-2" href="login.php">Login</a></li> -->
            </ul>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Harvest Hub</h1>
        <p class="lead mt-3">
            Connecting Farmers and Consumers <br>
            Fresh • Local • Direct from the Farm
        </p>
        <a href= "signup.php" class="btn btn-light btn-lg mt-3">Get Started</a>
    </div>
</section>

<!-- FEATURES -->
<section class="py-5" id="features">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Harvest Hub?</h2>

        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">🌱</div>
                <h5>Farm to Table</h5>
                <p>Buy fresh produce directly from local farmers without middlemen.</p>
            </div>

            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">🛒</div>
                <h5>Online Marketplace</h5>
                <p>Browse farm products, check availability, and order with ease.</p>
            </div>

            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">💬</div>
                <h5>Direct Chat</h5>
                <p>Communicate directly with farmers for orders, questions, and updates.</p>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="py-5 bg-white" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>About Harvest Hub</h2>
                <p>
                    Harvest Hub is a farm-to-table online marketplace designed to support
                    local farmers and provide consumers with fresh, affordable agricultural products.
                </p>
                <p>
                    Our goal is to strengthen local food systems and empower communities
                    through technology.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2909/2909764.png"
                     alt="Farm"
                     class="img-fluid"
                     style="max-width:300px;">
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="py-5 text-center bg-success text-white">
    <div class="container">
        <h2>Start Selling Today!</h2>
        <p class="mt-2">Join Harvest Hub and support local agriculture.</p>
        <a href="seller-signup.php" class="btn btn-light btn-lg mt-3">Create an Account</a>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-4">
    <div class="container text-center">
        <p class="mb-1">&copy; <?= date("Y") ?> Harvest Hub</p>
        <small>Farm to Table Online Marketplace</small>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
