<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/harvest_product.php";

$database = new Database();
$db = $database->getConnection();

$harvest_product = new HarvestProduct($db);

$require_login=true;
include_once "../../../login_checker.php";

$page_title = "Feedback";
include_once "../layout/layout_head.php";

$harvest_product->user_id = $_SESSION['user_id'];

$page_url = "{$home_url}user/farmer/review/feedback.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $harvest_product->readAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $harvest_product->countAll();

// include the stats cards
include_once "../statistics/stats.php";
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

    <?php include_once "../modal-forms/add-product.php"; ?>

	<div class="p-3 bg-light rounded">
		<h5 class="mb-0"><i class="bi-pencil-square text-success"></i> <?php echo $page_title; ?></h5>
		<small class="text-muted">Keep your harvest details up to date</small>
	</div>

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
							echo "<a href='$base_ur/user/review/review.php?id={$id}' class='btn btn-primary me-2 >Edit</button></a>";
							echo "<button class='btn btn-warning me-2'>View Review</button>";
						echo "</td>";
					echo "</tr>";
				}			
			?>
			</tbody>
		</table>
	</div>
	<?php
	include_once "../paging.php";
	}else{
		echo "<div class='alert alert-danger'>No Resources Found</div>";
	}
	?>
</div>



<?php include_once "../layout/layout_foot.php"; ?>