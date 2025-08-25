<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farm-to-Table Marketplace</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .category-icon {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
    }
    .product-card img {
      height: 150px;
      object-fit: cover;
    }
    .hero-banner {
      background-color: #28a745;
      color: white;
      border-radius: 12px;
      padding: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
  <div class="container">
    <a class="navbar-brand" href="#">Harvest Hub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <form class="d-flex ms-auto me-3">
        <input class="form-control me-2" type="search" placeholder="Search products">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="#">Cart</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">

  <!-- Hero Banner -->
  <div class="hero-banner">
    <div>
      <h1>Fresh Goods</h1>
      <p>Order Now!</p>
    </div>
    <img src="https://via.placeholder.com/150" alt="Vegetables">
  </div>

  <!-- Categories -->
  <h5>Shop From Top Categories</h5>
  <div class="d-flex gap-4 mb-4">
    <div class="text-center">
      <img src="uploads/2/products/28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqweqw.png" class="category-icon mb-2">
      <p>Vegetables</p>
    </div>
    <div class="text-center">
      <img src="https://via.placeholder.com/80" class="category-icon mb-2">
      <p>Fruits</p>
    </div>
    <div class="text-center">
      <img src="https://via.placeholder.com/80" class="category-icon mb-2">
      <p>Fish</p>
    </div>
    <div class="text-center">
      <img src="https://via.placeholder.com/80" class="category-icon mb-2">
      <p>Meat</p>
    </div>
  </div>

  <!-- Products Grid -->
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    <!-- Product Card -->
    <div class="col">
      <div class="card product-card h-100">
        <img src="uploads/2/products/28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqweqw.png" class="card-img-top" alt="Vegetables">
        <div class="card-body">
          <h6 class="card-title">Vegetables</h6>
          <p class="card-text">₱200</p>
          <button class="btn btn-success w-100">Add to Cart</button>
        </div>
      </div>
    </div>
    <!-- Repeat cards as needed -->
    <div class="col">
      <div class="card product-card h-100">
        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Fruits">
        <div class="card-body">
          <h6 class="card-title">Fruits</h6>
          <p class="card-text">₱200</p>
          <button class="btn btn-success w-100">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card product-card h-100">
        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Fish">
        <div class="card-body">
          <h6 class="card-title">Fish</h6>
          <p class="card-text">₱200</p>
          <button class="btn btn-success w-100">Add to Cart</button>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card product-card h-100">
        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Meat">
        <div class="card-body">
          <h6 class="card-title">Meat</h6>
          <p class="card-text">₱300</p>
          <button class="btn btn-success w-100">Add to Cart</button>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Footer -->
<footer class="bg-dark text-white mt-5 py-4">
  <div class="container d-flex justify-content-between">
    <div>
      <h6>Explore</h6>
      <ul class="list-unstyled">
        <li>Home</li>
        <li>About Us</li>
        <li>Services</li>
      </ul>
    </div>
    <div>
      <h6>Customer Services</h6>
      <ul class="list-unstyled">
        <li>Online Payment & Cash on Delivery</li>
        <li>Order Tracking</li>
        <li>Help Center</li>
      </ul>
    </div>
    <div>
      <h6>Blog</h6>
      <ul class="list-unstyled">
        <li>Best Practices</li>
        <li>Careers</li>
        <li>Contact</li>
      </ul>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
