<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";


$page_title = "Order";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";

?>

<div class="container">
    <div class="alert alert-secondary mt-2">
        <div class="row align-items-center">
            <div class="col-8">
                <button class='btn btn-success me-2'>All</button>
                <button class='btn btn-success me-2'>In Progress</button>
                <button class='btn btn-success me-2'>Delivered</button>
                <button class='btn btn-success me-2'>Complete</button>
            </div>
        </div>
    </div>
    <div class="p-3 bg-light rounded">
        <h5 class="mb-0"><i class="bi bi-basket-fill text-success"></i> <?php echo $page_title; ?></h5>
        <small class="text-muted">Update and manage your harvest inventory</small>
    </div>

    <!-- card records -->
  <div class="order-card alert alert-secondary mt-3">
    <div class="d-flex justify-content-between">
      <div>
        <h6 class="mb-1">Order Delivered</h6>
        <small class="text-muted">Apr 5, 2025, 10:07 AM</small>
      </div>
      <div class="alert alert-success">COMPLETED</div>
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
            <div class="text-muted small"><strong>6x</strong></div>
          </div>
        </div>

        <div class="order-images d-flex">
          <img src="<?php echo $base_url;?>libs/images/logo.png" alt="">
          <img src="https://via.placeholder.com/50" alt="">
          <img src="https://via.placeholder.com/50" alt="">
          <img src="https://via.placeholder.com/50" alt="">
        </div>
      </div>
      <div class="col-md-4 d-flex flex-column align-items-end justify-content-between">
        <a href="order_details.php" class="small text-decoration-none mb-2">View Order Details</a>
        <button class="btn btn-warning">Rate your Order</button>
      </div>
    </div>
  </div>
</div>




<?php include_once "../layout/layout_foot.php"; ?>