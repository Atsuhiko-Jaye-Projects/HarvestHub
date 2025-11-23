<div class="container py-4">

  <?php //include_once "../modal-forms/product/add_product.php"; ?>

  <!-- ✅ Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-box-seam text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Crop Type</h6>
          <h4 id="recordCounts"></h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-box-seam text-primary fs-2 mb-2"></i>
          <h6 class="text-muted">Crops Stocks (KG)</h6>
          <h4 id="crop_stocks">0</h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
         <i class="bi bi-tree text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Planted Crops</h6>
          <h4 id="planted_crop_count">0</h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-cash-stack text-danger fs-2 mb-2"></i>
          <h6 class="text-muted">Avg. Yield (kg)</h6>
          <h4 id="avg_Yields"><span>Kg</span></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Weather Suggestions -->
  <div class="alert alert-light border shadow-sm rounded-4 mb-4">
    <div class="row align-items-center">
      <div class="col-12 col-md-4 mb-2 mb-md-0">
        <h6 class="mb-0"><i class="bi bi-cloud-sun text-warning me-2"></i>Weather-Based Crop Suggestions</h6>
      </div>
      <div class="col-12 col-md-8 text-md-end">
        <button class='btn btn-outline-success btn-sm me-2 mb-1 mb-md-0'>Potato</button>
        <button class='btn btn-outline-success btn-sm me-2 mb-1 mb-md-0'>Carrot</button>
        <button class='btn btn-outline-success btn-sm me-2 mb-1 mb-md-0'>Ampalaya</button>
        <button class='btn btn-outline-success btn-sm mb-1 mb-md-0'>Sitaw</button>
      </div>
    </div>
  </div>

  <!-- Page Header -->
  <div class="p-3 bg-light rounded shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <div>
      <h5 class="mb-1"><i class="bi bi-basket-fill text-success"></i> <?php echo $page_title; ?></h5>
      <small class="text-muted">Manage your crops and keep your farm data organized</small>
    </div>
    <button class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#new-crop-modal">
      <i class="bi bi-plus-circle me-2"></i> Add Crop
    </button>
  </div>

  <?php include_once "../modal-forms/crop/add_crop.php"; ?>
  <div id="modalContainer"></div>
  <div id="modalCropContainer"></div>

  <!-- Search and Filter -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <input type="text" id="searchCrop" class="form-control w-100 w-md-50" placeholder="Search crop...">

  </div>

  <!-- Crop Table -->
  <div class="table-responsive shadow-sm rounded-4">
    <table class="table table-hover table-bordered align-middle mb-0">
      <thead class="table-success text-uppercase text-center ">
        <tr>
          <th>Crop Name</th>
          <th>KG/Plant</th>
          <th>Cultivated Area (sqm)</th>
          <th>Harvest Stocks (EST.)</th>
          <th>Planted Crops</th>
          <th>Date Planted</th>
          <th>Harvest Est.</th>
          <th>Duration</th>
          <th>Crop Age</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="crop_table" class="table-group-divider">
        <tr>
          <td colspan="9" class="text-center py-5 text-muted" id="loadingState">
            <div class="spinner-border text-success" role="status"></div>
            <div class="mt-2">Loading data...</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div id="crop_pagination" class="mt-4 d-flex justify-content-center"></div>

</div>


<!-- JS Enhancements -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Simulate fetching data
  setTimeout(() => {
    document.getElementById("loadingState").outerHTML = `
      <tr>
        <td>Tomato</td>
        <td>150</td>
        <td>250</td>
        <td>2025-10-01</td>
        <td>2025-11-15</td>
        <td>45 days</td>
        <td>20 days</td>
        <td><span class="badge bg-success">Posted</span></td>
        <td class="text-center">
          <button class="btn btn-sm btn-primary me-2"><i class="bi bi-pencil-square"></i></button>
          <button class="btn btn-sm btn-success"><i class="bi bi-upload"></i></button>
        </td>
      </tr>`;
    
    document.getElementById("totalCrops").innerText = "14";
    document.getElementById("postedCrops").innerText = "8";
    document.getElementById("pendingCrops").innerText = "6";
    document.getElementById("avgYield").innerText = "42.5";
  }, 1000);

  // Search functionality
  const searchInput = document.getElementById("searchCrop");
  searchInput.addEventListener("input", () => {
    const filter = searchInput.value.toLowerCase();
    document.querySelectorAll("#crop_table tr").forEach(row => {
      const match = row.innerText.toLowerCase().includes(filter);
      row.style.display = match ? "" : "none";
    });
  });

  // Status filter
  const statusSelect = document.getElementById("statusFilter");
  statusSelect.addEventListener("change", () => {
    const status = statusSelect.value.toLowerCase();
    document.querySelectorAll("#crop_table tr").forEach(row => {
      if (!status) {
        row.style.display = "";
      } else {
        const rowStatus = row.cells[7]?.innerText.toLowerCase();
        row.style.display = rowStatus === status ? "" : "none";
      }
    });
  });
});
</script>

<style>
/* Hover & button effects */
.table-hover tbody tr:hover {
  background-color: #e9f7ef;
  transition: background-color 0.3s ease;
}
.btn-group .btn:hover {
  transform: translateY(-2px);
  transition: transform 0.2s ease;
}

/* Small screen table */
@media (max-width: 768px) {
  .table-responsive {
    overflow-x: auto;
  }
  .table thead {
    font-size: 0.8rem;
  }
  .table tbody td {
    font-size: 0.85rem;
  }
}
</style>
