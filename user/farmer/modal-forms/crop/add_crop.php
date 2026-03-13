<div class="modal fade" id="new-crop-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);">

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" id="cropForm">

        <div class="modal-header border-0 p-4 pb-0">
          <div class="d-flex align-items-center">
             <div class="bg-success-subtle p-3 rounded-4 me-3">
                <i class="bi bi-leaf-fill text-success fs-4"></i>
             </div>
             <div>
                <h5 class="modal-title fw-bold mb-0" id="exampleModalLabel">Add a New Crop</h5>
                <small class="text-muted">Register your current planting activity</small>
             </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <div class="container-fluid">
            <input type="hidden" name="action" value="create">
            <input type="hidden" name="crop_name" id="crop_name">
            <input type="hidden" name="farm_resource_id" id="farmresourceid">

            <div class="row g-4">
              <div class="col-md-6">
                  <div class="form-group mb-3">
                      <label class="form-label small fw-bold text-muted text-uppercase mb-2">Select Crop</label>
                      <select name="crop_name_id" id="cropSelect" class="form-select border-0 bg-light p-3 rounded-4 shadow-sm" required>
                          <?php
                          $farm_resource->user_id = $_SESSION['user_id'];
                          $stmt = $farm_resource->getCropName();
                          $num = $stmt->rowCount();

                          if ($num > 0) {
                              echo "<option value=''>-- Select Crop --</option>";
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['id']}'
                                      data-name='{$row['crop_name']}'
                                      data-farmresource-id='{$row['farm_resource_id']}'>
                                      {$row['crop_name']}
                                    </option>";
                              }
                          } else {
                              echo "<option value=''>No Crop found</option>";
                          }
                          ?>
                      </select>
                  </div>

                  <div class="form-group mb-3">
                      <label class="form-label small fw-bold text-muted text-uppercase mb-2">Date Planted</label>
                      <div class="input-group">
                          <span class="input-group-text border-0 bg-light rounded-start-4"><i class="bi bi-calendar-check"></i></span>
                          <input type="date" id="date_planted" name="date_planted" class="form-control border-0 bg-light p-3 rounded-end-4 shadow-sm" 
                                 readonly value="<?php echo date('Y-m-d'); ?>" style="cursor: not-allowed; opacity: 0.7;">
                      </div>
                  </div>

                  <div class="form-group mb-3">
                      <label class="form-label small fw-bold text-muted text-uppercase mb-2">Estimated Harvest Date</label>
                      <?php $futureDate = date('Y-m-d', strtotime('+45 days')); ?>
                      <div class="input-group">
                          <span class="input-group-text border-0 bg-light rounded-start-4"><i class="bi bi-calendar-event"></i></span>
                          <input type="date" id="estimated_harvest_date" name="estimated_harvest_date" class="form-control border-0 bg-light p-3 rounded-end-4 shadow-sm" value="<?php echo $futureDate; ?>">
                      </div>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group mb-3">
                      <label class="form-label small fw-bold text-muted text-uppercase mb-2">Estimated No. of Plants</label>
                      <input type="number" name="plant_count" id="plantCount" class="form-control border-0 bg-light p-3 rounded-4 shadow-sm" placeholder="e.g. 500">
                  </div>

                  <div class="form-group mb-3">
                      <label class="form-label small fw-bold text-muted text-uppercase mb-2"  >Cultivated Area (sqm)</label>
                      <input type="number" name="cultivated_area" id="area" class="form-control border-0 bg-light p-3 rounded-4 shadow-sm" 
                             readonly value="50" onchange="validateArea(this)">
                  </div>

                  <div class="form-group mb-3">
                      <label class="form-label small fw-bold text-muted text-uppercase mb-2">Avg. Yield (KG/Plant)</label>
                      <input type="number" step="0.01" name="kilo_per_plant" id="avgyeild" class="form-control border-0 bg-light p-3 rounded-4 shadow-sm" value="2.5">
                  </div>
              </div>
            </div>

            <div class="mt-4 p-3 rounded-4 border-0 d-flex align-items-center" style="background: #f0fdf4; color: #166534;">
                <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                <div class="small">
                    <strong>Note:</strong> Harvest potential is automatically calculated based on the <strong>Average Yield</strong> and <strong>Plant Count</strong> you provide.
                </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-0 p-4">
          <button type="button" class="btn btn-light px-4 py-2 rounded-pill fw-bold text-muted" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success px-5 py-2 rounded-pill fw-bold shadow-sm">
             <i class="bi bi-check2-circle me-1"></i> Save Crop Details
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
  // Validation for Area size
  function validateArea(el) {
    if (el.value < 50) { 
        alert('Minimum cultivated area size is 50 sqm'); 
        el.value = 50; 
    } else if (el.value > 5000) { 
        alert('Maximum cultivated area size is 5000 sqm'); 
        el.value = 5000; 
    }
  }

  // Fetching crop details when name is selected
  document.getElementById("cropSelect").addEventListener("change", function(){
    const cropId = this.value;
    const selectedOption = this.options[this.selectedIndex];
    const cropName = selectedOption ? selectedOption.dataset.name : "";
    const farmResourceId = selectedOption ? selectedOption.dataset.farmresourceId : "";
    
    if(!cropId){
      document.getElementById("avgyeild").value = "2.5";
      document.getElementById("plantCount").value = "";
      document.getElementById("area").value = "50";
      document.getElementById("farmresourceid").value = "";
      document.getElementById("crop_name").value = "";
      return;
    } 

    fetch("../../../js/user/farmer/api/fetch_crop_details.php?id=" + cropId)
    .then(res => res.json())
    .then(data => {
      // Logic for fallback values to prevent empty inputs
      document.getElementById("avgyeild").value = data.average_yield_per_plant || 2.5;
      document.getElementById("plantCount").value = data.plant_count || "";
      document.getElementById("area").value = data.planted_area_sqm || 50;
    })
    .catch(err => console.error("Error fetching crop details:", err));
    
    document.getElementById("crop_name").value = cropName;
    document.getElementById("farmresourceid").value = farmResourceId;
  });
</script>