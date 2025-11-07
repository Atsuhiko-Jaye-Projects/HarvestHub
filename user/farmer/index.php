<?php
include_once "../../config/core.php";

$page_title = "Index";
$require_login = true;
include_once "../../login_checker.php";

include_once "layout/layout_head.php";

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
        $farm->municipality = $_POST['municipality'];
        $farm->baranggay = $_POST['baranggay'];
        $farm->purok = $_POST['purok'];
        $farm->farm_ownership = $_POST['farm_ownership'];
        $farm->lot_size = $_POST['lot_size'];

        $farm_details = 1;
        $user->farm_details_exists = $farm_details;

        if ($farm->createFarmInfo()) {
            $user->user_id = $_SESSION['user_id'];
            $user->markFarmAsExists();
            $_SESSION['is_farm_registered'] = 1;
            echo "<div class='alert alert-success'><i class='bi bi-clipboard2-check-fill'></i> Farm Details saved successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'><i class='bi bi-clipboard2-x'></i> Failed to save farm details. Please try again.</div>";
        }
    }

    include_once "farm/farm_detail.php";

} else {
?>

<div class="container-fluid mt-3">
  <!-- Summary Cards -->
  <div class="row g-3">
    <div class="col-md-4 col-sm-6">
      <div class="card text-white bg-success shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6>Total Sales</h6>
            <h3>₱30,137.00</h3>
          </div>
          <i class="bi bi-clipboard fs-2"></i>
        </div>
        <div class="card-footer text-white-50 small">+3.16% From last month</div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6>Pending Orders</h6>
            <h3>15</h3>
            <small>Orders</small>
          </div>
          <i class="bi bi-hourglass-split fs-2 text-warning"></i>
        </div>
        <div class="card-footer text-success small">+3.16% From last month</div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h6>Completed Orders</h6>
            <h3>10</h3>
          </div>
          <i class="bi bi-check-circle fs-2 text-primary"></i>
        </div>
        <div class="card-footer text-success small">+2.24% From last month</div>
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
        <h5>Order Volume</h5>
        <p><strong>3K</strong> <span class="text-success">+2.1%</span> vs Last Week</p>
        <canvas id="salesChart2" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Notifications & Top Products -->
  <div class="row mt-4 g-3">
    <div class="col-lg-6 col-sm-12">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-white fw-bold">Notifications</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <small class="text-muted">Feb 11</small><br>
            Juan Dela Cruz ordered 10kg of hybrid corn seeds. Please confirm availability.
          </li>
          <li class="list-group-item">
            <small class="text-muted">Feb 11</small><br>
            [IMPORTANT] Update to API Endpoint Limit
          </li>
          <li class="list-group-item">
            <small class="text-muted">Feb 07</small><br>
            Juan Dela Cruz ordered 20kg Tomatoes. Prepare for delivery by July 21.
          </li>
        </ul>
        <div class="card-footer d-flex justify-content-between">
          <button class="btn btn-outline-secondary btn-sm">&lt;</button>
          <button class="btn btn-outline-secondary btn-sm">&gt;</button>
        </div>
      </div>
    </div>

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
                  <th>Total Sold</th>
                </tr>
              </thead>
              <tbody>
                <tr class="bg-success bg-opacity-10">
                  <td>1</td>
                  <td>Carrot</td>
                  <td>20</td>
                </tr>
                <tr class="bg-secondary bg-opacity-10">
                  <td>2</td>
                  <td>Eggplant</td>
                  <td>15</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Potato</td>
                  <td>10</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Cabbage</td>
                  <td>5</td>
                </tr>
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

include_once "layout/layout_foot.php";
?>
