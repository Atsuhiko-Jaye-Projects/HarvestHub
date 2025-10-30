<?php
include_once "../../config/core.php";
$require_login=true;
include_once "../../login_checker.php";

$page_title = "Index";
include_once "layout/layout_head.php";



if ($_SESSION['is_farm_registered'] == 0 ) {


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
            echo "<div class='alert alert-success'><span><i class='bi bi-clipboard2-check-fill'></i></span> Farm Details is saved. Thank you!</div>";
        }else{
            echo "<div class='alert alert-danger'><span><i class='bi bi-clipboard2-x'></i></span> Failed to save your Details, Please Try again!</div>";
        }

    }
    include_once "farm/farm_detail.php";


}else{
?>



<div class="container-fluid mt-3">
    <div class="d-flex gap-3">
  <!-- Card 1 -->
  <div class="card text-white bg-success flex-fill">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h6>Total Sales</h6>
          <h2>₱30,137.00</h2>
          <small></small>
        </div>
        <div>
          <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
        </div>
      </div>
      <small class="text-success text-white">+3.16% From last month</small>
    </div>
  </div>

  <!-- Card 2 -->
  <div class="card flex-fill">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h6>Pending Orders</h6>
          <h2>15</h2>
          <small>Orders</small>
        </div>
        <div>
          <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
        </div>
      </div>
      <small class="text-success">+3.16% From last month</small>
    </div>
  </div>

  <!-- Card 3 -->
  <div class="card flex-fill">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h6>Completed Orders</h6>
          <h2>10</h2>
          <small></small>
        </div>
        <div>
          <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
        </div>
      </div>
      <small class="text-success">+2.24% From last month</small>
    </div>
  </div>
</div>

<?php include_once "modal-forms/product/add_product.php";?>

</div>

<div class="row">
  <div class="col-lg-6">
    <div class="container mt-4">
      <div class="card p-3 shadow-sm">
        <h5>Sales Summary</h5>
        <p><strong>3K</strong> <span class="text-success">+2.1%</span> vs Last Week</p>
        <canvas id="salesChart" height="200"></canvas>
      </div>
    </div>
  </div>


    <div class="col-lg-6">
    <div class="container mt-4">
      <div class="card p-3 shadow-sm">
        <h5>Order Volume</h5>
        <p><strong>3K</strong> <span class="text-success">+2.1%</span> vs Last Week</p>
        <canvas id="salesChart2" height="200"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-white fw-bold">Notifications</div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <small class="text-muted">Feb 11</small><br>
        Juan Dela Cruz ordered 10kg of hybrid corn seeds on February 11, 2025. Please confirm availability.
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
  </div>

    <div class="col-lg-6">
    <div class="container mt-4">
      <div class="card shadow-sm">
          <div class="card-header bg-white fw-bold">Top Products</div>
          <div class="card-body p-0">
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

<?php
}

include_once "layout/layout_foot.php";
?>
