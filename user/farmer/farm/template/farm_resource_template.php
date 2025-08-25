<div class="container">

	<?php include_once "../modal-forms/resource/add_resource.php"; ?>
        <nav class="navbar bg-body-tertiary mt-3">
    
        <div class="container-fluid">
            <!-- Search Form with Dropdown beside -->
            <form class="d-flex w-30 align-items-center" role="search" action="search.php">
                <div class="input-group">
                    <span class="input-group-text" id="search-icon">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        class="form-control" 
                        type="search" 
                        <?php echo $search_value=isset($search_term) ? "value='{$search_term}'" : "";?>
                        name="s"
                        placeholder="Search" 
                        aria-label="Search" 
                        aria-describedby="search-icon"
                        required
                    />
                </div>
                <button class="btn btn-outline-success ms-2" type="submit">Search</button>
            </form>
            <div class="mb-3 mt-3 float-end">
                <span data-bs-toggle='tooltip' title='New'>
                    <button class="btn btn-success px-4 py-2 " data-bs-toggle="modal" data-bs-target="#exampleModal"><span><i class="bi bi-plus-circle"></i></span></button>
                </span>
	        </div>

        </div>
    </nav>
    
    <div class="p-3 bg-light rounded">
        <h5 class="mb-0"><i class="bi-journal-text text-success"></i> <?php echo $page_title; ?></h5>
        <small class="text-muted">Update and manage your farm supplies and resources</small>
    </div>
	
	<?php
		if ($num>0) {
	?>
	<div class="table">
		<table class="table table-hover table-bordered align-middle">
			<thead class="table-light">
			<tr>
				<th>Type</th>
				<th>Name</th>
				<th>Cost</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			<?php
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					echo "<tr w-20>";
						echo "<td>{$type}</td>";
						echo "<td>{$item_name}</td>";
						echo "<td>{$cost}</td>";
						echo "<td>{$date}</td>";
						echo "<td>";
						echo "<span data-bs-toggle='tooltip' title='Edit'>
								<button class='btn btn-primary me-2' data-bs-toggle='modal' data-bs-target='#edit-farm-resource-modal-$id'><span><i class='bi bi-pencil-square'></i></span></button>
								</span>";
						echo "<span data-bs-toggle='tooltip' title='View'>
								<button class='btn btn-warning me-2' data-bs-toggle='modal' data-bs-target='#view-farm-resource-modal-$id'><span><i class='bi bi-eye-fill'></i></span></button>
								</span>";
						echo "</td>";
					echo "</tr>";
					include "../modal-forms/farm/farm-resource.php";
					include "../modal-forms/harvest/view_harvest.php";
				}			
			?>
			</tbody>
		</table>
	</div>
	<?php
	// include the pagination
	include_once "../paging.php";

	}else{
		echo "<div class='alert alert-danger'>No products Found</div>";
	}
	?>
</div>