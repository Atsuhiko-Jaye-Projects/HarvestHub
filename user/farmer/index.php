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
    include_once "farm_detail.php";


}else{
?>

<div class="container-xl mt-3">
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

<?php include_once "modal-forms/add-product.php";?>

<!-- Table -->
<div class="table-responsive">
  <table class="table align-middle">
    <thead class="table-light">
      <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Unit</th>
        <th>Lot Size</th>
        <th>Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>#2456JL</td>
        <td>Carrot</td>
        <td>High Valued Crops</td>
        <td>₱200.00</td>
        <td>kg</td>
        <td>10kg/Lot</td>
        <td>Feb 12, 12:23 pm</td>
        <td>
          <button class="btn btn-primary rounded-pill px-3">Edit</button>
        </td>
      </tr>
      <tr>
        <td>#5435DF</td>
        <td>Mango</td>
        <td>Fruit</td>
        <td>₱200.00</td>
        <td>kg</td>
        <td>10kg/Lot</td>
        <td>Feb 01, 01:13 pm</td>
        <td>
          <button class="btn btn-primary rounded-pill px-3">Edit</button>
        </td>
      </tr>
      <tr>
        <td>#9876XC</td>
        <td>Egg Plant</td>
        <td>High Valued Crops</td>
        <td>₱200.00</td>
        <td>kg</td>
        <td>10kg/Lot</td>
        <td>Jan 20, 09:08 am</td>
        <td>
          <button class="btn btn-primary rounded-pill px-3">Edit</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

</div>


<!-- other contents will be here -->





<?php 
}

include_once "layout/layout_foot.php"; 
?>


