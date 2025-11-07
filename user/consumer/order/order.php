<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/product.php";

// always make the page required is enabled
$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$product = new Product($db);

$page = "order.php";

$page_url = "{$home_url}user/farmer/management/manage_harvest.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// get the userId to get the order details
$order->customer_id = $_SESSION['user_id'];

$stmt = $order->readAllOrder($from_record_num, $records_per_page);
$num = $stmt->rowCount();

$page_title = "My Orders";
include_once "../layout/layout_head.php";

?>


<div class="container py-3">

  <!-- Filter Buttons -->
  <div class="d-flex flex-wrap gap-2 mb-3">
    <button class="btn btn-outline-success btn-sm">All</button>
    <button class="btn btn-outline-success btn-sm">In Progress</button>
    <button class="btn btn-outline-success btn-sm">Delivered</button>
    <button class="btn btn-outline-success btn-sm">Complete</button>
  </div>

  <!-- Page Header -->
  <div class="bg-success text-white p-3 rounded mb-3">
    <h5 class="mb-0"><i class="bi bi-basket-fill me-2"></i><?php echo $page_title; ?></h5>
    <small class="text-light">Track and manage your recent orders.</small>
  </div>

  <!-- Order Card Example -->
  <?php
  if ($num>0) {
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
      
      $product->product_id = $row['product_id'];
      $product->readProductName();
  ?>
    <div class="order-card p-3 border">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h6 class="mb-0 fw-semibold"><?php echo $row['status']; ?></h6>
        <h6 class="mb-0 fw-semibold">Invoice NO. <?php echo $row['invoice_number']; ?></h6>
        <small class="text-muted"><?php echo $row['created_at']; ?></small>
      </div>
      <!-- status must be base on the alert box -->
      <?php
        $status = "";
        if ($row['status'] == "Order Placed") {
          $status = "Preparing";
        }elseif ($row['status'] == "Prepared") {
          $status = "To Pick-Up";
        }elseif ($row['status'] == "In Transit"){
          $status = "In Transit";
        }else{
          $status = "Cancelled";
        }

        switch ($status) {
          case "Preparing": $class = "preparing"; break;
          case "To Pick-Up": $class = "pickup"; break;
          case "In Transit": $class = "transit"; break;
          case "Complete" : $class = "complete"; break;
          case "Cancelled": $class = "cancelled"; break;
        }

        echo "<span class='order-status $class'>$status</span>";
      ?>
    </div>

    <hr>

    <div class="row">
      <div class="col-md-8">
        <div class="d-flex align-items-center mb-3">
          <div class="me-4">
            <h6 class="mb-0 text-success">
               <?php 
                  $price = $product->price_per_unit; 
                  $quantity = $row['quantity'];
                  $total = $price * $quantity;

                  echo "₱" . number_format($total, 2);
                ?>
            </h6>
            <small class="text-muted"><strong><?php echo $row['mode_of_payment']; ?></strong></small>
          </div>
          <div>
            <h6 class="mb-0">
              <?php 
              $row['quantity'];
              if ($row['quantity'] > 0) {
                echo $row['quantity'] . " QTY.";
              }else{
                echo $row['quantity'] . " QTY.";
              }
              ?>
            </h6>
            <small class="text-muted"><strong><?php echo $product->product_name; ?></strong></small>
          </div>
        </div>

        <div class="order-images d-flex">
          <img src="<?php echo $base_url;?>libs/images/logo.png" alt="item">
          <img src="<?php echo $base_url;?>libs/images/logo.png" alt="item">
          <img src="<?php echo $base_url;?>libs/images/logo.png" alt="item">
        </div>
      </div>

      <div class="col-md-4 d-flex flex-column align-items-end justify-content-between">
        <a href="order_details.php" class="btn btn-outline-success btn-sm mb-2 w-100">
          View Order Details
        </a>
        <button class="btn btn-warning btn-sm w-100">
          Rate Order
        </button>
      </div>
    </div>
  </div>
<?php
    }
  }else{
    echo "<div class='alert alert-danger'>No Order found</div>";
  }
?>
</div>

<?php include_once "../layout/layout_foot.php"; ?>
