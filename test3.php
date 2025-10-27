<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details - Petsay</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff;
    }
    .product-card img {
      border-radius: 8px;
      object-fit: cover;
    }
    .thumbs img {
      width: 80px;
      height: 80px;
      cursor: pointer;
      border-radius: 6px;
      border: 1px solid #ddd;
    }
    .thumbs img:hover {
      border-color: #198754;
    }
    .price-range {
      font-size: 1.25rem;
      font-weight: 600;
      color: #198754;
    }
    .rating i {
      color: #ffc107;
    }
    .btn-success {
      font-weight: 500;
    }
    footer {
      background: #442f16;
      color: #fff;
      padding: 40px 0;
    }
    footer a {
      color: #fff;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="container py-5">

  <!-- Product Section -->
  <div class="row g-5 align-items-start">
    <!-- Left: Image -->
    <div class="col-md-5">
      <img src="https://via.placeholder.com/600x400" class="img-fluid rounded" alt="Petsay">
      <div class="d-flex gap-2 mt-3 thumbs">
        <img src="https://via.placeholder.com/100" alt="">
        <img src="https://via.placeholder.com/100" alt="">
        <img src="https://via.placeholder.com/100" alt="">
        <img src="https://via.placeholder.com/100" alt="">
      </div>
    </div>

    <!-- Right: Details -->
    <div class="col-md-7">
      <p class="text-muted mb-1">Vegetable</p>
      <h2>Petsay</h2>
      <p class="price-range">₱65.00 – ₱75.00</p>

      <div class="d-flex align-items-center mb-3">
        <span class="me-3 text-muted">1,728 Sold</span>
        <div class="rating">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-half"></i>
          <span class="ms-2">4.5</span>
        </div>
      </div>

      <h6>Description:</h6>
      <p class="text-secondary">
        Sweet, crisp, and freshly harvested petsay perfect for cooking. Grown naturally without harmful chemicals to ensure quality and freshness.
      </p>

      <p><strong>Lot Size:</strong> 30</p>

      <div class="mb-3">
        <label class="form-label">Select Kilos:</label><br>
        <div class="btn-group" role="group">
          <input type="radio" class="btn-check" name="kilo" id="kilo5">
          <label class="btn btn-outline-secondary" for="kilo5">5</label>

          <input type="radio" class="btn-check" name="kilo" id="kilo10">
          <label class="btn btn-outline-secondary" for="kilo10">10</label>

          <input type="radio" class="btn-check" name="kilo" id="kilo15">
          <label class="btn btn-outline-secondary" for="kilo15">15</label>

          <input type="radio" class="btn-check" name="kilo" id="kilo20">
          <label class="btn btn-outline-secondary" for="kilo20">20</label>

          <input type="radio" class="btn-check" name="kilo" id="kilo25">
          <label class="btn btn-outline-secondary" for="kilo25">25</label>

          <input type="radio" class="btn-check" name="kilo" id="kilo30">
          <label class="btn btn-outline-secondary" for="kilo30">30</label>
        </div>
      </div>

      <div class="d-flex gap-3">
        <button class="btn btn-success px-4">Add to Cart</button>
        <button class="btn btn-outline-dark px-4">Checkout Now</button>
      </div>
    </div>
  </div>

  <!-- Related Products -->
  <div class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Related Products</h4>
      <a href="#" class="text-success">View All</a>
    </div>

    <div class="row row-cols-2 row-cols-md-4 g-3">
      <div class="col">
        <div class="card h-100 product-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Apple">
          <div class="card-body">
            <h6 class="card-title mb-1">Apple</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 product-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Potato">
          <div class="card-body">
            <h6 class="card-title mb-1">Potato</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 product-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Carrots">
          <div class="card-body">
            <h6 class="card-title mb-1">Carrots</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 product-card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Petsay">
          <div class="card-body">
            <h6 class="card-title mb-1">Petsay</h6>
            <p class="text-success mb-1">₱200.00</p>
            <p class="text-muted small mb-0">1,218 Sold</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h6>Explore</h6>
        <ul class="list-unstyled">
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h6>Customer Services</h6>
        <ul class="list-unstyled">
          <li><a href="#">Online Payment</a></li>
          <li><a href="#">Order Tracking</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h6>Blog</h6>
        <ul class="list-unstyled">
          <li><a href="#">Best Practices</a></li>
          <li><a href="#">Color Wheel</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
