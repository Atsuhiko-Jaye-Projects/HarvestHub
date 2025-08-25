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

    <?php include_once "../modal-forms/harvest/add_harvest.php"; ?>

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
						echo "<span data-bs-toggle='tooltip' title='Post'>
								<button class='btn btn-success me-2' data-bs-toggle='modal' data-bs-target='#post-harvest-modal-$id'><span><i class='bi bi-box-arrow-up'></i></span></button>
								</span>";
						echo "</div>";
						echo "</td>";
					echo "</tr>";
					include "../modal-forms/harvest/edit_harvest.php";
					include "../modal-forms/harvest/view_harvest.php";
					include "../modal-forms/harvest/post_harvest.php";
				}		
			?>
			</tbody>
		</table>
	</div>
	<?php
	include_once "paging.php";
	}else{
		echo "<div class='alert alert-danger'>No Resources Found</div>";
		
	}
	?>
</div>
