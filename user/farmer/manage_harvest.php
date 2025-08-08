<?php
include_once "../../config/core.php";
$require_login=true;
include_once "../../login_checker.php";

$page_title = "Manage Harvest";
include_once "layout_head.php";

?>

<div class="container-xl mt-3">
    <div class="d-flex gap-3">
  <!-- Card 1 -->
  <div class="card text-white bg-success flex-fill">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h6 id="location"></h6>
          <h2 id="temperature"></h2>
          <small id="desc"></small>
        </div>
        <div>
          <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
        </div>
      </div>
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
</div>

<div class="container">
<?php include_once "modal-forms/add-product.php"; ?>
<div class="mb-3 mt-3 dropdown">
  <button 
    class="btn btn-success px-4 py-2 dropdown-toggle" 
    type="button" 
    id="dropdownMenuButton" 
    data-bs-toggle="dropdown" 
    aria-expanded="false">
    <span><i class="bi bi-tools"></i></span>   Manage Harvest
  </button>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <li><a href="farm_resource.php" class="dropdown-item">Farm Input</a></li>
    <li><a href="manage_product.php" class="dropdown-item">Farm Product</a></li>
  </ul>
</div>
<h2><?php echo $page_title; ?></h2>

	<!-- Table -->
	<?php
		if ($num>0) {
	?>
	<div class="table-responsive">
		<table class="table align-middle">
			<thead class="table-light">
			<tr>
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
			<?php
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					echo "<tr>";
						echo "<td>{$product_name}</td>";
						echo "<td>{$category}</td>";
						echo "<td>{$price_per_unit}</td>";
						echo "<td>{$unit}</td>";
						echo "<td>{$lot_size}</td>";
						echo "<td>{$created_at}</td>";
						echo "<td>";
							echo "<button class='btn btn-primary me-2'>Edit</button>";
							echo "<button class='btn btn-warning me-2'>View</button>";
							echo "<button class='btn btn-danger me-2'>Remove</button>";
						echo "</td>";
					echo "</tr>";
				}			
			?>
			</tbody>
		</table>
	</div>
	<?php
	}else{
		echo "<div class='alert alert-danger'>No Resources Found</div>";
	}
	?>
</div>



<?php include_once "layout_foot.php"; ?>