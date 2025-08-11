<?php
include_once "../../config/core.php";
include_once "../../config/database.php";
include_once "../../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Feedback";
include_once "layout_head.php";

$product->user_id = $_SESSION['user_id'];
$stmt = $product->readAllProduct();
$num = $stmt->rowCount();

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
							echo "<a href='review.php?id={$id}' class='btn btn-primary me-2 >Edit</button></a>";
							echo "<button class='btn btn-warning me-2'>View Review</button>";
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