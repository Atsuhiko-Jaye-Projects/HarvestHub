
<div class="container">

	<!-- Table -->
     
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
        </div>
    </nav>

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
						 echo "<div class='btn-group' role='group'>";
						echo "<span data-bs-toggle='tooltip' title='Edit'>
								<button class='btn btn-outline-primary me-2' data-bs-toggle='modal' data-bs-target='#edit-product-modal-$id'><span><i class='bi bi-pencil-square'></i></span></button>
								</span>";
						echo "<span data-bs-toggle='tooltip' title='Remove'>
								<a href='#' data-delete-id='{$id}' class='btn btn-outline-danger me-2 delete-object'>
									<i class='bi bi-trash'></i>
								</a>
							</span>";

						echo "</div>";
						echo "</td>";
					echo "</tr>";
				}			
			?>
			</tbody>
		</table>
	</div>
	<?php
    include_once "paging.php";
	}else{
		echo "<div class='alert alert-danger mt-3' >No products Found</div>";
	}
	?>
</div>