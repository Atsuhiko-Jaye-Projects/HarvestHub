<div class="container-fluid">

  <?php //include_once "../modal-forms/product/add_product.php"; ?>

  <!-- ✅ Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-4">
      <div class="card border-1 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
          <i class="bi bi-box-seam text-primary fs-2 mb-2"></i>
          <h6 class="text-muted">Crops Stocks (KG)</h6>
          <h4 id="crop_stocks"><?php echo number_format($farm_stats['plant_stocks']); ?></h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="card border-1 shadow-sm h-100 rounded-4">
        <div class="card-body text-center">
         <i class="bi bi-tree text-success fs-2 mb-2"></i>
          <h6 class="text-muted">Total Planted Crops</h6>
          <h4 id="planted_crop_count"><?php echo number_format($farm_stats['planted_crops']); ?></h4>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4">
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
  <!-- <div class="alert alert-light border-1   shadow-sm rounded-4 mb-4">
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
  </div> -->

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

  <!-- tab window content here -->
  <div class="row">
      <div class="col-12">
          <div class="analytics-container p-4 shadow-sm bg-white">
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                  <div>
                      <h4 class="fw-bold mb-1 text-dark">Crop Overview</h4>
                      <p class="text-muted small mb-0">Summary of your farm produce and availability</p>
                  </div>
                  
                  <ul class="nav nav-pills gap-2 bg-light p-1 rounded-3" id="analyticsTabs" role="tablist">
                      <li class="nav-item">
                          <button class="nav-link active" id="planted-tab" data-bs-toggle="tab" data-bs-target="#planted_tab" type="button">
                              <i class="bi bi-grid-1x2 me-2"></i>Planted Crops
                          </button>
                      </li>
                      <li class="nav-item">
                          <button class="nav-link" id="preorder-tab" data-bs-toggle="tab" data-bs-target="#preorder_tab" type="button">
                              <i class="bi bi-seedling me-2"></i>Pre-Order Crops
                          </button>
                      </li>
                  </ul>
              </div>

              <div class="tab-content" id="analyticsTabContent">

                  <!-- Planted Crops -->
                  <div class="tab-pane fade show active" id="planted_tab" role="tabpanel">
                      <div class="p-2">
                          <?php include_once "tab_windows/planted_crop.php"; ?>
                      </div>
                  </div>

                  <!-- Pre-Order Crops -->
                  <div class="tab-pane fade" id="preorder_tab" role="tabpanel">
                      <div class="p-2">
                          <?php include_once "tab_windows/pre_order_crop.php"; ?>
                      </div>
                  </div>

              </div>
          </div>
      </div>
  </div>
   
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.dataset.id;
    const farm_resource_id = btn.dataset.farmResourceId;
    const cultivated_area = btn.dataset.carea;
    const user_id = btn.dataset.uid;

    const formData = new FormData();
    formData.append("id", id);
    formData.append("farm_resource_id", farm_resource_id);
    formData.append("cultivated_area", cultivated_area);
    formData.append("user_id", user_id);

    Swal.fire({
        title: "Delete this item?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it"
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch("template/delete_crop.php", {
            method: "POST",
            body: formData // ✅ just body, no headers
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Deleted!",
                    timer: 1200,
                    showConfirmButton: false
                });

                // remove row smoothly
                btn.closest("tr")?.remove();
            } else {
                Swal.fire("Error", data.message, "error");
            }
        })
        .catch(() => {
            Swal.fire("Error", "Server error", "error");
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
