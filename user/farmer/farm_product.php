<?php
include_once "../../config/core.php";
include_once "../../config/database.php";
include_once "../../objects/farm-product.php";	

$database = new Database();
$db = $database->getConnection();

$farm_product = new FarmProduct($db);

$require_login=true;
include_once "../../login_checker.php";

$page_title = "Farm Products";
include_once "layout_head.php";

$page_url = "{$home_url}user/farmer/farm_product.php?";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;


$farm_product->user_id = $_SESSION['user_id'];
$stmt = $farm_product->readAllProduct($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $farm_product->countAll();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    include_once "../../config/database.php";
    include_once "../../objects/farm-resource.php";

    $database = new Database();
    $db = $database->getConnection();
    $farm_product = new FarmProduct($db);

    // ===== CREATE =====
    if ($_POST['action'] == 'create') {
        $farm_product->user_id = $_SESSION['user_id'];
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
        $farm_product->id = $_POST['product_id']; // Make sure your form has this hidden input
        $farm_product->product_name = $_POST['product_name'];
        $farm_product->date_planted = $_POST['date_planted'];
        $farm_product->estimated_harvest_date = $_POST['estimated_harvest_date'];
        $farm_product->yield = $_POST['yield'];
        $farm_product->suggested_price = $_POST['suggested_price'];

        if ($farm_product->updateFarmProduct()) {
            echo "<div class='container'><div class='alert alert-success'>Product Info Updated!</div></div>";
        } else {
            echo "<div class='container'><div class='alert alert-danger'>ERROR: Product info not updated.</div></div>";
        }
    }
}


//include stats card
include_once "stats.php";
?>

<div class="container">

<?php include_once "modal-forms/add-farm-product.php"; ?>

	<!-- Add Product Button -->
	<div class="mb-3 mt-3 float-end">
	<span data-bs-toggle='tooltip' title='New'>
	<button class="btn btn-success px-4 py-2 "  data-bs-toggle="modal" data-bs-target="#exampleModal"><span><i class="bi bi-plus-circle"></i></span></button>
	</span>
	</div>

	<div class="p-3 bg-light rounded">
		<h5 class="mb-0"><i class="bi bi-basket-fill text-success"></i> <?php echo $page_title; ?></h5>
		<small class="text-muted">Manage your harvest records and pricing</small>
	</div>

	<!-- Table -->
	<?php
		if ($num>0) {
	?>
	<div class="table">
		<table class="table table-hover table-bordered align-middle">
			<thead class="table-secondary">
			<tr>
				<th><i class="bi bi-box"></i> Product</th>
				<th><i class="bi bi-calendar-event"></i> Harvest Date</th>
				<th><i class="bi bi-graph-up"></i> Yield(kg)</th>
                <th><i class="bi bi-cash"></i> Price(₱)</th>
				<th><i class="bi bi-gear"></i> Actions</th>
			</tr>
			</thead>
			<tbody>
			<?php
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					echo "<tr w-20>";
						echo "<td>{$product_name}</td>";
						echo "<td>{$estimated_harvest_date}</td>";
						echo "<td>{$yield}</td>";
                        echo "<td>₱{$suggested_price}.00</td>";
						echo "<td>";
						 echo "<div class='btn-group' role='group'>";
						echo "<span data-bs-toggle='tooltip' title='Edit'>
								<button class='btn btn-primary me-2' data-bs-toggle='modal' data-bs-target='#edit-product-modal-$id' title='Edit'><span><i class='bi bi-pencil-square'></i></span></button>
								</span>";
						echo "<span data-bs-toggle='tooltip' title='Edit'>
								<button class='btn btn-warning me-2' data-bs-toggle='modal' data-bs-target='#view-product-modal-$id' title='Edit'><span><i class='bi bi-eye-fill'></i></span></button>
								</span>";
						echo "</div>";
						echo "</td>";
					echo "</tr>";
					include "modal-forms/edit_product.php";
					include "modal-forms/view_product.php";
				}
			?>
			</tbody>
		</table>

	</div>
	<?php
	include_once "paging.php";	
	}else{
		echo "<div class='alert alert-danger'>No products Found</div>";
	}
	?>
</div>

<?php include_once "layout_foot.php"; ?>