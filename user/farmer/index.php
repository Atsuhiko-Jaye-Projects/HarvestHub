<?php
ob_start();
include_once "../../config/core.php";
include_once "../../config/database.php";
include_once "../../objects/order.php";


$page_title = "Index";
$require_login = true;
include_once "../../login_checker.php";
include_once "layout/layout_head.php";

if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'><i class='bi bi-clipboard2-check-fill'></i> {$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger'><i class='bi bi-clipboard2-x'></i> {$_SESSION['error_message']}</div>";
    unset($_SESSION['error_message']);
}

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);


if ($_SESSION['is_farm_registered'] == 0) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once "../../config/database.php";
        include_once "../../objects/farm.php";
        include_once "../../objects/user.php";

        $database = new Database();
        $db = $database->getConnection();

        $farm = new Farm($db);
        $user = new User($db);

        $farm->user_id = $_SESSION['user_id'];
        $farm->province = $_POST['province_name'];
        $farm->municipality = $_POST['municipality_name'];
        $farm->baranggay = $_POST['barangay_name'];
        $farm->purok = $_POST['purok'];
        $farm->farm_ownership = $_POST['farm_ownership'];
        $farm->lot_size = $_POST['lot_size'];

        

      if ($farm->createFarmInfo()) {
        $user->farm_details_exists = 1;
        $user->id = $_SESSION['user_id'];
          if ($user->markFarmAsExists()) {
            $_SESSION['is_farm_registered'] = 1;
            $_SESSION['success_message'] = "Farm Details saved successfully!";
            header("Location: {$base_url}user/farmer/index.php");
            exit;
          }else{
            $_SESSION['error_message'] = "Failed to save farm details. Please try again.";
            header("Location: {$base_url}user/farmer/index.php");
            exit;
          }
      } else {
          $_SESSION['error_message'] = "Failed to save farm details. Please try again.";
          header("Location: {$base_url}user/farmer/index.php");
          exit;
      }

    }

    include_once "farm/farm_detail.php";

} else {
  // display the complete and pending count to dashboard
  $order->farmer_id = $_SESSION['user_id'];
  $pending_order_count = $order->countPendingOrder();
  $completed_order_count = $order->countCompletedOrder();

  // display the total sales to dashboard
  $total = $order->totalSales();
?>

<div class="container-fluid mt-3">
  <!-- Summary Cards -->
  <div class="row g-3">
    <div class="col-md-4 col-sm-6">
      <div class="card text-white bg-success shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6>Total Sales</h6>
            <h3><?php echo "₱" . number_format($total,2);?></h3>
          </div>
          <i class="bi bi-clipboard fs-2"></i>
        </div>
        <div class="card-footer text-white-50 small">0% From last month</div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6>Pending Orders</h6>
            <h3><?php echo $pending_order_count;?></h3>
            <small>Order</small>
          </div>
          <i class="bi bi-hourglass-split fs-2 text-warning"></i>
        </div>
        <div class="card-footer text-success small">0% From last month</div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6>Completed Orders</h6>
            <h3><?php echo $completed_order_count;?></h3>
          </div>
          <i class="bi bi-check-circle fs-2 text-primary"></i>
        </div>
        <div class="card-footer text-success small">0% From last month</div>
      </div>
    </div>
  </div>

  <?php include_once "modal-forms/product/add_product.php"; ?>

  <!-- Charts -->
  <div class="row mt-4 g-3">
    <div class="col-lg-6 col-sm-12">
      <div class="card shadow-sm p-3 h-100">
        <h5>Sales Summary</h5>
        <p><strong>3K</strong> <span class="text-success">+2.1%</span> vs Last Week</p>
        <canvas id="salesChart" height="200"></canvas>
      </div>
    </div>
    <div class="col-lg-6 col-sm-12">
      <div class="card shadow-sm p-3 h-100">
        <h5>Product Stocks</h5>
        <!-- <p><strong>3K</strong> <span class="text-success">+2.1%</span> vs Last Week</p> -->
        <canvas id="salesChart2" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Notifications & Top Products -->
  <div class="row mt-4 g-3">
  <div class="col-lg-3 col-sm-12">
    <div class="card shadow-sm h-100 border-0">
      <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #1e3c72, #2a5298); border-radius: 0.5rem 0.5rem 0 0;">
        <i class="bi bi-cart-fill me-2"></i> Order Notifications
      </div>
      <ul class="list-group list-group-flush" id="orderNotification">
      </ul>
      <div class="card-footer d-flex justify-content-between border-0" style="background-color: #f8f9fa; border-radius: 0 0 0.5rem 0.5rem;">
        <button class="btn btn-outline-primary btn-sm">&lt;</button>
        <button class="btn btn-outline-primary btn-sm">&gt;</button>
      </div>
    </div>
  </div>

<!-- Optional hover effect -->
<style>
.list-group-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
  cursor: pointer;
}
</style>




  <div class="col-lg-3 col-sm-12">
  <div class="card shadow-sm h-100 border-0">
    <div class="card-header text-white fw-bold" style="background: linear-gradient(135deg, #28a745, #71c784); border-radius: 0.5rem 0.5rem 0 0;">
      <i class="bi bi-bell-fill me-2"></i> Product Stock Notifications
    </div>
    <ul class="list-group list-group-flush" id="notificationList">
      
    </ul>
    <div class="card-footer d-flex justify-content-between border-0" style="background-color: #f8f9fa; border-radius: 0 0 0.5rem 0.5rem;">
      <button class="btn btn-outline-success btn-sm">&lt;</button>
      <button class="btn btn-outline-success btn-sm">&gt;</button>
    </div>
  </div>
</div>

<!-- Optional hover effect -->
<style>
.list-group-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
  cursor: pointer;
}
</style>


  
    <div class="col-lg-6 col-sm-12">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-white fw-bold">Top Products</div>
        <div class="card-body p-0">
          <div class="table-responsive">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>Rank</th>
                <th>Product Name</th>
                <th>Total Planted</th>
              </tr>
            </thead>
            <tbody id="mostPlantedCropTable">
              <tr><td colspan="3" class="text-center">Loading...</td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
}
ob_end_flush();
include_once "layout/layout_foot.php";
?>
