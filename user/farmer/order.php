<?php 
include_once '../../config/core.php';
include_once '../../config/database.php';
include_once '../../objects/order.php'; 

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

$order->user_id = $_SESSION['user_id'];
$stmt = $order->readAllOrder();
$num = $stmt->rowCount();

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Order Info";
include_once "layout_head.php";

?>

<div class="container">
    <nav class="navbar bg-body-tertiary mt-3">
        <div class="container-fluid">

            <!-- Search Form with Dropdown beside -->
            <form class="d-flex w-75 align-items-center" role="search">
                <div class="input-group">
                    <span class="input-group-text" id="search-icon">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        class="form-control" 
                        type="search" 
                        placeholder="Search" 
                        aria-label="Search" 
                        aria-describedby="search-icon"
                    />
                </div>
                <button class="btn btn-outline-success ms-2" type="submit">Search</button>

                <!-- Dropdown beside Search -->
                <div class="dropdown ms-2">
                    <button 
                        class="btn btn-outline-success px-4 py-2 dropdown-toggle align-items-center gap-2 d-flex <?= $page == 'manage_harvest.php' ? 'active bg-success' : '' ?>" 
                        type="button" 
                        id="dropdownMenuButton" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                        <i class="bi bi-tools"></i> Sort
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a href="order.php?order_type=pending" class="dropdown-item">Pending</a></li>
                        <li><a href="manage_harvest.php" class="dropdown-item">Cancel</a></li>
                        <li><a href="farm_resource.php" class="dropdown-item">Completed</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </nav>
    <h2><?php echo $page_title; ?></h2>
    	<?php
		if ($num>0) {
	?>
	<div class="table">
		<table class="table align-middle table-bordered text-center">
			<thead class="table-light">
			<tr>
				<th>Order ID</th>
				<th>Contact Number</th>
				<th>Address</th>
                <th>Total Price</th>
                <th>MOP</th>
                <th>Lot Size</th>
                <th>Date of Order</th>
                <th>Status</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					echo "<tr w-20>";
						echo "<td>{$order_id}</td>";
						echo "<td>{$contact_number}</td>";
						echo "<td>{$address}</td>";
						echo "<td>{$total_price}</td>";
                        echo "<td>{$mode_of_payment}</td>";
                        echo "<td>{$lot_size}</td>";
                        echo "<td>{$order_date}</td>";
                        echo "<td>{$status}</td>";
						echo "<td>";
							echo "<button class='btn btn-primary me-2'>Edit</button>";
							echo "<button class='btn btn-warning me-2'>View</button>";
						echo "</td>";
					echo "</tr>";
				}			
			?>
			</tbody>
		</table>
	</div>
	<?php
	}else{
		echo "<div class='alert alert-danger'>No order Found</div>";
	}
	?>
</div>



<?php include_once "layout_foot.php"; ?>