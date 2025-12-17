<!-- Modal -->
<div class="modal fade" id="new-crop-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" id="cropForm">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a New Crop</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              <input type="hidden" name="action" value="create">
              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Crop Name</label>
                    <select name="crop_name" id="cropSelect" class="form-select">
                        <?php
                        $farm_resource->user_id = $_SESSION['user_id'];
                        $stmt = $farm_resource->getCropName();
                        $num = $stmt->rowCount();

                        if ($num > 0) {
                            // show once
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



                <div class="col-md-6">
                  <input type="hidden" name="crop_name" id="crop_name" class="form-control">
                  <input type="hidden" name="farm_resource_id" id="farmresourceid">
                  <label>Date Planted</label>
                  <input type="date" id="date_planted" name="date_planted" class="form-control" required placeholder="" value="<?php echo date('Y-m-d'); ?>">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Estimated Harvest Date</label>
                    <?php $futureDate = date('Y-m-d', strtotime('+45 days')); ?>
                    <input type="date" id="estimated_harvest_date" name="estimated_harvest_date" class="form-control"  value="<?php echo $futureDate; ?>">
                </div>
                <div class="col-md-6">
                    <label>
                      KG/Plant (Average Yield) 
                    </label>
                    <input type="number" step="0.01" name="kilo_per_plant" id="avgyeild" class="form-control">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Cultivated Area</label>
                    <input type="number"
                    name="cultivated_area"
                    id="area"
                    class="form-control"
                    onchange="
                      if (this.value < 50) { alert('Minimum cultivated area size is 50 sqm'); this.value = 50; }
                      if (this.value > 5000) { alert('Maximum cultivated area size is 5000 sqm'); this.value = 5000; }" value="50">
                </div>
                  <div class="col-md-6">
                    <label>
                      No. of plants (Estimated)
                    </label>
                    <input type="number" name="plant_count" id="plantCount" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>
      <!-- Form ends here -->

    </div>
  </div>
</div>

<script>
  document.getElementById("cropSelect").addEventListener("change", function(){
    const cropId = this.value;
    const selectedOption = this.options[this.selectedIndex];
    const cropName = selectedOption.dataset.name;
    const farmResourceId = selectedOption.dataset.farmresourceId;
    

    if(!cropId){
      document.getElementById("avgyeild").value = "";
      document.getElementById("plantCount").value = "";
      document.getElementById("area").value = "";
      document.getElementById("farmresourceid").value = "";
      return;
    } 

    fetch("../../../js/user/farmer/api/fetch_crop_details.php?id=" + cropId)
    .then(res => res.json())
    .then(data => {
      document.getElementById("avgyeild").value = data.average_yield_per_plant;
      document.getElementById("plantCount").value = data.plant_count;
      document.getElementById("area").value = data.planted_area_sqm;
    });
    
    document.getElementById("crop_name").value = cropName;
    document.getElementById("farmresourceid").value = farmResourceId;
  });
</script>
