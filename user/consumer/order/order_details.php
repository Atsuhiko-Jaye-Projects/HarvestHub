<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";





$page_title = "Order";
include_once "../layout/layout_head.php";

$require_login=true;
include_once "../../../login_checker.php";

?>


    <div class="row mt-4">
      <!-- Left side: Order Details -->
      <div class="col-md-8">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title fw-bold">Order Details</h5>
            <p class="text-muted small mb-2"><i class="bi bi-calendar"></i> April 5, 2025</p>

            <!-- Delivery Info -->
            <div class="border p-3 rounded mb-3">
              <h6 class="fw-bold">Delivery info</h6>
              <p class="mb-0"><i class="bi bi-geo-alt text-success"></i> Laon, Mogpog Marinduque</p>
            </div>

            <!-- Payment Method -->
            <div class="border p-3 rounded mb-3">
              <h6 class="fw-bold">Payment Method</h6>
              <p class="mb-0"><i class="bi bi-cash-coin text-success"></i> Cash on Delivery <br> +63 912 3456 789</p>
            </div>

            <!-- Review Order -->
            <div class="border p-3 rounded" id='order_details_img'>
              <h6 class="fw-bold">Review Order</h6>
              <div class="d-flex align-items-center">
                <img src="<?php echo $base_url;?>libs/images/logo.png" alt="Product">
                <div class="bg-light border rounded d-flex justify-content-center align-items-center" style="width:60px; height:60px;">+12</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right side: Order Summary -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold">Order Summary</h5>
            <div class="d-flex justify-content-between">
              <span>Delivery fee</span>
              <span>₱5.00</span>
            </div>
            <div class="d-flex justify-content-between">
              <span>Service fee</span>
              <span>₱5.00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Items total</span>
              <span>₱200.00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
              <span>Total</span>
              <span>₱200.00</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once "../layout/layout_foot.php"; ?>