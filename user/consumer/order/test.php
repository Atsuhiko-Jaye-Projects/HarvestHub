<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order UI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .order-card {
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      padding: 1.5rem;
      margin-top: 1rem;
      background: #fff;
    }
    .order-status {
      font-size: 0.85rem;
      font-weight: bold;
      color: #198754;
      background: #e9f8f0;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
    }
    .order-images img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 5px;
    }
    .rate-btn {
      border-radius: 8px;
      background: #ffca2c;
      border: none;
      font-size: 0.9rem;
      padding: 0.5rem 1rem;
      transition: 0.2s;
    }
    .rate-btn:hover {
      background: #e0b323;
    }
  </style>
</head>
<body class="bg-light">

<div class="container my-4">

  <!-- Tabs -->
  <ul class="nav nav-pills mb-3">
    <li class="nav-item">
      <a class="nav-link active" href="#">All</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">In Progress</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Delivered</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Cancelled</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Completed</a>
    </li>
  </ul>

  <!-- Order Card -->
  <div class="order-card">
    <div class="d-flex justify-content-between">
      <div>
        <h6 class="mb-1">Order Delivered</h6>
        <small class="text-muted">Apr 5, 2025, 10:07 AM</small>
      </div>
      <div class="order-status">COMPLETED</div>
    </div>

    <div class="row mt-3">
      <div class="col-md-8">
        <div class="d-flex align-items-center mb-2">
          <div class="me-4">
            <strong>₱200.00</strong>
            <div class="text-muted small">Paid with cash</div>
          </div>
          <div>
            <strong>Items</strong>
            <div class="text-muted small">6x</div>
          </div>
        </div>

        <div class="order-images d-flex">
          <img src="https://via.placeholder.com/50" alt="">
          <img src="https://via.placeholder.com/50" alt="">
          <img src="https://via.placeholder.com/50" alt="">
          <img src="https://via.placeholder.com/50" alt="">
        </div>
      </div>
      <div class="col-md-4 d-flex flex-column align-items-end justify-content-between">
        <a href="#" class="small text-decoration-none mb-2">View Order Details</a>
        <button class="rate-btn">Rate your Order</button>
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
