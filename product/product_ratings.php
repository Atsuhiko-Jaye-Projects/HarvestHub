<!-- Bootstrap 5 CSS CDN (if not already included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">



<style>
  .ratings-container {
    background-color: #fff6f1;
    padding: 1rem 1.5rem;
    border-radius: 0.375rem; /* rounded-md */
    font-family: Arial, sans-serif;
  }
  .rating-score {
    font-size: 2.5rem;
    font-weight: 700;
    color: #e84c3d;
    line-height: 1;
  }
  .rating-text {
    font-size: 0.9rem;
    color: #e84c3d;
  }
  .star {
    color: #e84c3d;
    font-size: 1.5rem;
  }
  .filter-btn {
    border: 1.5px solid #ddd;
    color: #555;
    font-weight: 500;
    font-size: 0.9rem;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    padding: 0.375rem 0.9rem;
    border-radius: 0.375rem;
    background-color: white;
    transition: all 0.3s ease;
  }
  .filter-btn.active, 
  .filter-btn:hover {
    border-color: #e84c3d;
    color: #e84c3d;
    background-color: white;
  }
</style>
<div class="card p-3 shadow-sm rounded mb-3 mt-3">
<h3>Product Ratings</h3>
<div class="ratings-container">
  
  <div class="d-flex align-items-center mb-3">
    <div class="me-4 text-center">
      <div class="rating-score">4.9</div>
      <div class="rating-text">out of 5</div>
    </div>
    <div>
      <!-- Using Bootstrap icons (or FontAwesome) for stars -->
      <i class="bi bi-star-fill star"></i>
      <i class="bi bi-star-fill star"></i>
      <i class="bi bi-star-fill star"></i>
      <i class="bi bi-star-fill star"></i>
      <i class="bi bi-star-fill star"></i>
    </div>
  </div>

  <div class="d-flex flex-wrap">
    <button type="button" class="filter-btn active">All</button>
    <button type="button" class="filter-btn">5 Star (1.3K)</button>
    <button type="button" class="filter-btn">4 Star (82)</button>
    <button type="button" class="filter-btn">3 Star (22)</button>
    <button type="button" class="filter-btn">2 Star (9)</button>
    <button type="button" class="filter-btn">1 Star (14)</button>
    <button type="button" class="filter-btn">With Comments (298)</button>
    <button type="button" class="filter-btn">With Media (249)</button>
    <button type="button" class="filter-btn">Local Review (1.5K)</button>
  </div>
</div>
<!-- reviews -->
<?php include_once "review.php"; ?>
</div>
<!-- Bootstrap Icons CDN for star icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
