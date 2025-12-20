<div class="container-fluid">

  <?php //include_once "../modal-forms/product/add_product.php"; ?>

  <!-- ✅ Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card border-1 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-box-seam text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Crop Type</h6>
          <h4 id="recordCounts"></h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-1 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-box-seam text-primary fs-2 mb-2"></i>
          <h6 class="text-muted">Crops Stocks (KG)</h6>
          <h4 id="crop_stocks"><?php echo number_format($farm_stats['plant_stocks']); ?></h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-1 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
         <i class="bi bi-tree text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Planted Crops</h6>
          <h4 id="planted_crop_count"><?php echo number_format($farm_stats['planted_crops']); ?></h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-1 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-cash-stack text-danger fs-2 mb-2"></i>
          <h6 class="text-muted">Avg. Yield (kg)</h6>
          <h4 id="avg_Yields"><?php echo number_format($farm_stats['avg_yield'], 2); ?><span> Kg</span></h4>
        </div>
      </div>
    </div>
  </div>

  <!-- Weather Suggestions -->
  <div class="alert alert-light border-1   shadow-sm rounded-4 mb-4">
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
  <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mb-3 gap-2">
    <input type="text" id="searchCrop" class="form-control w-100 w-md-50" placeholder="Search crop...">

  </div>

  <!-- Crop Table -->
  <div class="table-responsive shadow-sm rounded-2">
    <table class="table table-hover table-bordered align-middle mb-0 ">
      <thead class="table-success text-uppercase text-center">
        <tr>
          <th><i class="bi bi-flower1 me-1"></i> </i> Crop Name</th>
          <th><i class="bi bi-bar-chart-line me-1"></i> Yield/Plant (kg)</th>
          <th><i class="bi bi-signpost-split me-1"></i> Cultivated Area (sqm)</th>
          <th><i class="bi bi-box-seam me-1"></i> Harvest Stocks (EST.)</th>
          <th><i class="bi bi-clipboard-data me-1"></i> Planted Crops</th>
          <th><i class="bi bi-calendar-plus me-1"></i> Date Planted</th>
          <th><i class="bi bi-calendar-check me-1"></i> Harvest Est.</th>
          <th><i class="bi bi-clock me-1"></i> Duration</th>
          <th><i class="bi bi-calendar3 me-1"></i> Crop Age</th>
          <th class="text-center"><i class="bi bi-gear me-1"></i> Action</th>
        </tr>
      </thead>
      <tbody id="crop_table" class="table-group-divider text-center">
        <?php
        if ($crop_num > 0) {
          while ($row = $crop_stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $datePlanted = new DateTime($row['date_planted']);
            $harvestEst  = new DateTime($row['estimated_harvest_date']);
            $today       = new DateTime(); // current date

            // Duration: from planted to estimated harvest
            $duration = $datePlanted->diff($harvestEst);
            $durationDays = $duration->days;

            // Crop Age: from planted to today
            $age = $datePlanted->diff($today);
            $ageDays = $age->days;

            echo "<tr>";
              echo "<td class='text-nowrap'>{$row['crop_name']}</td>";
              echo "<td>{$row['yield']} KG/Plant</td>";
              echo "<td>{$row['cultivated_area']}</td>";
              echo "<td>{$row['stocks']}</td>";
              echo "<td>{$row['plant_count']}</td>";
              echo "<td>{$row['date_planted']}</td>";
              echo "<td>{$row['estimated_harvest_date']}</td>";
              echo "<td>{$durationDays} days</td>";
              echo "<td>{$ageDays} days</td>";
              echo "<td class='text-nowrap'>
                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#update-crop-modal-{$row['id']}'>
                    <i class='bi bi-pencil-square'></i>
                </button>
                <button class='btn btn-success ms-1' data-bs-toggle='modal' data-bs-target='#post-crop-modal-{$row['id']}'>
                  <i class='bi bi-cloud-upload-fill'></i>
                </button>
                  </td>";
            echo "</tr>";
            include "../modal-forms/crop/edit_crop.php";
            include "../modal-forms/crop/post_crop.php";
          }
        
        }else{
          echo "<tr>
            <td colspan='11' class='text-center'>No Crop found</td>
          </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php include_once "../../../paging.php"; ?>
  <!-- Pagination -->
  <!-- <div id="crop_pagination" class="mt-4 d-flex justify-content-center"></div> -->
   
</div>


<!-- JS Enhancements -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Simulate fetching data
  setTimeout(() => {
    const loading = document.getElementById("loadingState");
    if (loading) loading.outerHTML = ``;
    
    document.getElementById("totalCrops").innerText = "14";
    document.getElementById("postedCrops").innerText = "8";
    document.getElementById("pendingCrops").innerText = "6";
    document.getElementById("avgYield").innerText = "42.5";
  }, 1000);

  // Search functionality
  const searchInput = document.getElementById("searchCrop");
  if (searchInput) {
    searchInput.addEventListener("input", () => {
      const filter = searchInput.value.toLowerCase();
      document.querySelectorAll("#crop_table tr").forEach(row => {
        const match = row.innerText.toLowerCase().includes(filter);
        row.style.display = match ? "" : "none";
      });
    });
  }

  // Status filter
  const statusSelect = document.getElementById("statusFilter");
  if (statusSelect) {
    statusSelect.addEventListener("change", () => {
      const status = statusSelect.value.toLowerCase();
      document.querySelectorAll("#crop_table tr").forEach(row => {
        if (!status) {
          row.style.display = "";
        } else {
          const rowStatus = row.cells[9]?.innerText.toLowerCase(); // correct index
          row.style.display = rowStatus === status ? "" : "none";
        }
      });
    });
  }
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
