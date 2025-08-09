<?php
include_once "../../config/core.php";
include_once "../../config/database.php";
include_once "../../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Manage Harvest";
include_once "layout_head.php";

$product->user_id = $_SESSION['user_id'];
$stmt = $product->readAllProduct();
$num = $stmt->rowCount();

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

    <div class="alert alert-secondary mt-2">
        <div class="row align-items-center">
            <div class="col-4">
                <p class="mb-0">Weather Based Crop Suggestions</p>
            </div>
            <div class="col-8">
                <button class='btn btn-success me-2'>Potato</button>
                <button class='btn btn-success me-2'>Carrot</button>
                <button class='btn btn-success me-2'>Ampalaya</button>
                <button class='btn btn-success me-2'>Sitaw</button>
            </div>
        </div>
    </div>

    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <form class="d-flex w-50" role="search">
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
        </form>
    </div>
    </nav>

    <?php include_once "modal-forms/add-product.php"; ?>

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