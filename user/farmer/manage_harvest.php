<?php
ob_start();
include_once "../../config/core.php";
include_once "../../config/database.php";
include_once "../../objects/harvest_product.php";

$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Manage Harvest";
include_once "layout_head.php";

$page_url = "{$home_url}user/farmer/manage_harvest.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$harvest_product->user_id = $_SESSION['user_id'];
$stmt = $harvest_product->readAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $harvest_product->countAll();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    include_once "../../config/database.php";
    include_once "../../objects/harvest_product.php";

    $database = new Database();
    $db = $database->getConnection();
    $harvest_product = new HarvestProduct($db);

    // ===== CREATE =====
    if ($_POST['action'] == 'create') {
        $farm_product->product_name = $_POST['product_name'];
        $farm_product->date_planted = $_POST['date_planted'];
        $farm_product->estimated_harvest_date = $_POST['estimated_harvest_date'];
        $farm_product->yield = $_POST['yield'];
        $farm_product->suggested_price = $_POST['suggested_price'];

        if ($farm_product->createFarmProduct()) {
            echo "<div class='container'><div class='alert alert-success'>Product Info Saved!</div></div>";
        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not saved.</div></div>";
        }
    }

    // ===== UPDATE =====
    elseif ($_POST['action'] == 'update') {

        $harvest_product->id = $_POST['product_id']; // Make sure your form has this hidden input
        $harvest_product->product_name = $_POST['product_name'];
        $harvest_product->price_per_unit = $_POST['price_per_unit'];
        $harvest_product->category = $_POST['category'];
        $harvest_product->unit = $_POST['unit'];
        $harvest_product->product_description = $_POST['product_description'];
		$harvest_product->lot_size = $_POST['lot_size'];

        if ($harvest_product->updateHarvestProduct()) {
						
            header("location:{$home_url}user/farmer/manage_harvest.php?r=pu");

			//echo "<div class='container'><div class='alert alert-success'>Harvest Product Info Updated!</div></div>";

        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not updated.</div></div>";
        }
    }
}

// include the stats cards
include_once "stats.php";
?>
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
	<div class="p-3 bg-light rounded">
  <h5 class="mb-0"><i class="bi bi-basket-fill text-success"></i> <?php echo $page_title; ?></h5>
  <small class="text-muted">Update and manage your harvest inventory</small>
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


	<!-- Table -->
	<?php
		if ($num>0) {
	?>
	<div class="table-responsive">
		<table class="table table-hover table-bordered align-middle shadow">
			<thead class="table-light">
			<tr>
				<th>Product</th>
				<th>Category</th>
				<th>Price</th>
				<th>Unit</th>
				<th>Lot Size</th>
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
						echo "<td>";
						 echo "<div class='btn-group' role='group'>";
						echo "<span data-bs-toggle='tooltip' title='Edit'>
								<button class='btn btn-primary me-2' data-bs-toggle='modal' data-bs-target='#edit-harvest-modal-$id'><span><i class='bi bi-pencil-square'></i></span></button>
								</span>";
						echo "<span data-bs-toggle='tooltip' title='View'>
								<button class='btn btn-warning me-2' data-bs-toggle='modal' data-bs-target='#view-harvest-modal-$id'><span><i class='bi bi-eye-fill'></i></span></button>
								</span>";
						echo "</div>";
						echo "</td>";
					echo "</tr>";
					include "modal-forms/edit_harvest.php";
					include "modal-forms/view_harvest.php";
				}		
			?>
			</tbody>
		</table>
	</div>
	<?php
	include_once "modal-forms/edit_harvest.php";
	include_once "paging.php";
	}else{
		echo "<div class='alert alert-danger'>No Resources Found</div>";
		
	}
	?>
</div>

<?php include_once "layout_foot.php"; ?>