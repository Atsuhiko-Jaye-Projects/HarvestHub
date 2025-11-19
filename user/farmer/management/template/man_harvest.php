<div class="container py-3">

  <?php include_once "../modal-forms/product/add_product.php";?>

  <!-- ✅ Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-box-seam text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Products </h6>
          <h4 id=""><?php echo $count_total_product; ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-cart-check text-primary fs-2 mb-2"></i>
          <h6 class="text-muted">Posted Products</h6>
          <h4 id="postedProducts"><?php echo $count_posted_product; ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-hourglass-split text-warning fs-2 mb-2"></i>
          <h6 class="text-muted">Pending Products</h6>
          <h4 id="pendingProducts"><?php echo $count_pending_product; ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-cash-stack text-danger fs-2 mb-2"></i>
          <h6 class="text-muted">Avg. Price (/KG)</h6>
          <h4 id="avgPrice"><?php echo "₱". number_format($avg_price,2);?></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- ✅ Weather Suggestions -->
  <div class="alert alert-light border shadow-sm mb-3">
    <div class="row align-items-center">
      <div class="col-md-4">
        <h6 class="mb-0"><i class="bi bi-cloud-sun text-warning me-2"></i>Weather-Based Crop Suggestions</h6>
      </div>
      <div class="col-md-8 text-end">
        <button class='btn btn-outline-success btn-sm me-2'>Potato</button>
        <button class='btn btn-outline-success btn-sm me-2'>Carrot</button>
        <button class='btn btn-outline-success btn-sm me-2'>Ampalaya</button>
        <button class='btn btn-outline-success btn-sm'>Sitaw</button>
      </div>
    </div>
  </div>

  <!-- ✅ Page Header -->
  <div class="p-3 bg-light rounded shadow-sm d-flex justify-content-between align-items-center mb-3">
    <div>
      <h5 class="mb-0"><i class="bi bi-basket-fill text-success"></i> <?php echo $page_title; ?></h5>
      <small class="text-muted">Update and manage your harvest inventory</small>
    </div>
    <button class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <i class="bi bi-plus-circle me-2"></i>New Product
    </button>
  </div>

  <!-- ✅ Search and Filter -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="input-group w-50">
      <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
      <input type="text" id="searchProduct" class="form-control" placeholder="Search product...">
    </div>
    <div>

    </div>
  </div>

  <!-- ✅ Product Table -->
  <div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle mb-0" id='userTable'>
      <thead class="table-success">
        <tr>
          <th>Product</th>
          <th>Category</th>
          <th>Price (/KG)</th>
          <th>Unit</th>
          <th>EST Stocks</th>
          <th>Lot Size</th>
          <th>Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody id='harvest_product'>
        <?php
          // Existing PHP fetch logic (keep your original structure)
          // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          //   extract($row);
          //   echo "<tr>";
          //   echo "<td>{$product_name}</td>";
          //   echo "<td>{$category}</td>";
          //   echo "<td>{$price_per_unit}</td>";
          //   echo "<td>{$unit}</td>";
          //   echo "<td>{$lot_size}</td>";
          //   echo "<td>{$is_posted}</td>";
          //   echo "<td class='text-center'>";
          //   echo "<button class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#edit-harvest-modal-$id'><i class='bi bi-pencil-square'></i></button>";
          //   echo "<button class='btn btn-sm btn-success' data-bs-toggle='modal' data-bs-target='#post-harvest-modal-$id'><i class='bi bi-upload'></i></button>";
          //   echo "</td></tr>";
          // }
        ?>
      </tbody>
    </table>
  </div>

  <!-- ✅ Pagination -->
  <div id="harvest_product_pagination" class="mt-3 d-flex justify-content-center"></div>

  <!-- ✅ Modal Container -->
  <div id="modalContainer"></div>

  <?php include_once "../modal-forms/crop/add_crop.php"; ?>
</div>

<!-- ✅ JS Enhancement -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Tooltip initialization
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


    // Simulated dashboard data (for now)
    setTimeout(() => {
      document.getElementById("totalProducts").innerText = "";
      document.getElementById("postedProducts").innerText = "";
      document.getElementById("pendingProducts").innerText = "";
      document.getElementById("avgPrice").value = price;
    }, 1000);

    // ✅ Search filter
    const searchInput = document.getElementById("searchProduct");
    searchInput.addEventListener("input", () => {
      const filter = searchInput.value.toLowerCase();
      document.querySelectorAll("#harvest_product tr").forEach(row => {
        const match = row.innerText.toLowerCase().includes(filter);
        row.style.display = match ? "" : "none";
      });
    });

    // ✅ Status filter
    const statusFilter = document.getElementById("statusFilter");
    statusFilter.addEventListener("change", () => {
      const value = statusFilter.value.toLowerCase();
      document.querySelectorAll("#harvest_product tr").forEach(row => {
        const status = row.cells[5]?.innerText.toLowerCase() || "";
        row.style.display = !value || status.includes(value) ? "" : "none";
      });
    });
  });
</script>
