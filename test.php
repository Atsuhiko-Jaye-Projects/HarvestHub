<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HarvestHub | Premium Landing</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
  body { font-family: 'Segoe UI', sans-serif; background: #f9fafb; color:#333; margin:0; }

  /* Navbar */
  .navbar { background:#fff; box-shadow:0 4px 15px rgba(0,0,0,0.08);}
  .navbar-brand {
    font-weight:bold; font-size:2rem;
    background: linear-gradient(90deg,#FF7E5F,#FEB47B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .nav-link { color:#555 !important; font-weight:500; transition:0.3s; }
  .nav-link:hover { color:#FF7E5F; }

  /* Hero */
  .hero-carousel .carousel-item { height:90vh; background-size:cover; background-position:center; position:relative;}
  .hero-carousel .overlay { position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.25);}
  .hero-carousel .carousel-caption { bottom:30%; text-align:left; max-width:700px; }
  .hero-carousel h1 {
    font-size:4rem; font-weight:bold;
    background: linear-gradient(90deg,#FF7E5F,#FEB47B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .hero-carousel p { font-size:1.3rem; color:#fff; text-shadow:1px 1px 6px rgba(0,0,0,0.4);}
  .hero-btn { background: linear-gradient(135deg,#FF7E5F,#FEB47B); border:none; font-weight:bold; padding:14px 36px; font-size:1.2rem; border-radius:12px; transition:0.3s; }
  .hero-btn:hover { transform:scale(1.05); box-shadow:0 0 20px rgba(255,126,95,0.5); }

  @keyframes fadeInUp { from { opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }
  .fade-in { animation: fadeInUp 1.5s ease-in; }

  .section-title {
    font-size:2.8rem; font-weight:bold; text-align:center; margin-bottom:50px;
    color:#FF7E5F; /* vibrant but clean color, no shadow */
  }

  /* Feature Cards */
  .feature-card {
    border-radius:20px;
    background:#fff; /* clean white */
    box-shadow:0 10px 25px rgba(0,0,0,0.08); /* subtle shadow for depth */
    transition: transform 0.5s ease, box-shadow 0.5s ease;
    overflow:hidden; text-align:center; padding:50px 20px;
  }
  .feature-card i { font-size:3rem; color:#FF7E5F; margin-bottom:20px; }
  .feature-card:hover { transform:translateY(-10px); box-shadow:0 20px 40px rgba(0,0,0,0.12); }

  #about { background:#f0f8ff; padding:90px 0; }
  #about img { border-radius:20px; box-shadow:0 10px 25px rgba(0,0,0,0.08); transition: transform 0.5s; }
  #about img:hover { transform:scale(1.05); }

  .btn-custom { background: linear-gradient(135deg,#FF7E5F,#FEB47B); color:#fff; font-weight:bold; padding:12px 30px; border-radius:10px; transition:all 0.3s; }
  .btn-custom:hover { transform:scale(1.05); box-shadow:0 0 20px rgba(255,126,95,0.5); }

  footer { background:#212529; color:#fff; padding:50px 0; }
  footer a { color:#FEB47B; text-decoration:none; transition:0.3s; }
  footer a:hover { color:#FF7E5F; text-decoration:underline; }
  .footer-icon { font-size:1.5rem; margin-right:12px; transition: all 0.3s; }
  .footer-icon:hover { color:#FF7E5F; transform: scale(1.3); }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="#">HarvestHub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item"><a class="btn btn-warning ms-2 hero-btn" href="#">Get Started</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" style="background-image:url('https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?crop=entropy&cs=tinysrgb&fit=crop&h=800&w=1600');">
      <div class="overlay"></div>
      <div class="carousel-caption d-none d-md-block">
        <h1>Fresh From Farm to Table</h1>
        <p>Discover local produce and support our farmers.</p>
        <a href="#" class="btn hero-btn btn-lg">Shop Now</a>
      </div>
    </div>
    <div class="carousel-item" style="background-image:url('https://images.unsplash.com/photo-1506801310323-534be5e7b69b?crop=entropy&cs=tinysrgb&fit=crop&h=800&w=1600');">
      <div class="overlay"></div>
      <div class="carousel-caption d-none d-md-block">
        <h1>Quality Products, Trusted Farmers</h1>
        <p>HarvestHub connects you with the best in your community.</p>
        <a href="#" class="btn hero-btn btn-lg">Learn More</a>
      </div>
    </div>
    <div class="carousel-item" style="background-image:url('https://images.unsplash.com/photo-1587300003388-59208cc962cb?crop=entropy&cs=tinysrgb&fit=crop&h=800&w=1600');">
      <div class="overlay"></div>
      <div class="carousel-caption d-none d-md-block">
        <h1>Organic & Sustainable</h1>
        <p>Support eco-friendly farming and enjoy fresh, healthy products.</p>
        <a href="#" class="btn hero-btn btn-lg">Join Us</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Features Section -->
<section id="features" class="py-5">
  <div class="container">
    <h2 class="section-title">What We Offer</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card fade-in">
          <i class="bi bi-basket-fill"></i>
          <h5 class="mt-3">Fresh Produce</h5>
          <p>Fruits, vegetables, and grains directly from local farms.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card fade-in">
          <i class="bi bi-truck"></i>
          <h5 class="mt-3">Fast Delivery</h5>
          <p>Your order reaches you quickly and safely.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card fade-in">
          <i class="bi bi-people-fill"></i>
          <h5 class="mt-3">Support Farmers</h5>
          <p>Purchase supports local farmers and communities.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section id="about">
  <div class="container">
    <h2 class="section-title">About HarvestHub</h2>
    <div class="row align-items-center">
      <div class="col-md-6 fade-in">
        <img src="https://images.unsplash.com/photo-1514986888952-8cd320577b74?crop=entropy&cs=tinysrgb&fit=crop&h=400&w=600" alt="About" class="img-fluid">
      </div>
      <div class="col-md-6 fade-in">
        <p>HarvestHub connects consumers with trusted local farmers, providing fresh, sustainable products.</p>
        <p>Enjoy farm-to-table produce while supporting hardworking farmers in your community.</p>
        <a href="#" class="btn btn-custom btn-lg">Join Our Community</a>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4 fade-in">
        <h5>HarvestHub</h5>
        <p>Fresh produce, trusted farmers, delivered to you.</p>
      </div>
      <div class="col-md-4 fade-in">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="#features">Features</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-4 fade-in">
        <h5>Contact</h5>
        <p>Email: info@harvesthub.com</p>
        <p>Phone: +63 912 345 6789</p>
        <p>Address: Mogpog, Marinduque, Philippines</p>
        <div class="mt-2">
          <i class="bi bi-facebook footer-icon"></i>
          <i class="bi bi-twitter footer-icon"></i>
          <i class="bi bi-instagram footer-icon"></i>
        </div>
      </div>
    </div>
    <div class="text-center mt-3">
      &copy; 2025 HarvestHub. All rights reserved.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
