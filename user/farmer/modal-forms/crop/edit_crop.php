
<!-- Modal -->
<div class="modal fade" id="update-crop-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" id="cropForm">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Crop details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              <input type="hidden" name="action" value='update'>
              <input type="hidden" name="id" value='<?php echo $row['id'];?>'>
              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Crop Name</label>
                  <input type="text" name="crop_name" class="form-control" required value='<?php echo $row['crop_name'];?>'>
                </div>


                <div class="col-md-6">
                  <label>Date Planted</label>
                  <input type="date" id="date_planted" name="date_planted" class="form-control" required placeholder="" value='<?php echo $row['date_planted'];?>'>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Estimated Harvest Date</label>
                    <input type="date" id="estimated_harvest_date" name="estimated_harvest_date" class="form-control" value='<?php echo $row['estimated_harvest_date'];?>'>
                </div>
                <div class="col-md-6">
                    <label>
                      Yield/Plant (kg) 
                    </label>
                    <input type="text" name="kilo_per_plant" value='<?php echo $row['yield'];?>' class="form-control" >
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Cultivated Area</label>
                    <input type="number"
                    name="cultivated_area"
                    class="form-control"
                    onchange="
                      if (this.value < 50) { alert('Minimum cultivated area size is 50 sqm'); this.value = 50; }
                      if (this.value > 5000) { alert('Maximum cultivated area size is 5000 sqm'); this.value = 5000; }" value='<?php echo $row['cultivated_area'];?>'>
                </div>
                  <div class="col-md-6">
                    <label>No. of plants (Estimated)</label>
                    <input type="number"  name="plant_count" class="form-control" value='<?php echo $row['plant_count'];?>'>
                </div>
                <?php if ($row['crop_status'] == "harvested") {
                  
                }else{?>
                  <div class="col-md-6  mt-3">
                    <label class="text-nowrap">Mark this crop as Harvested?</label>
                        <input class="form-check-input" type="radio" name="mark_crop" id="harvestedYes" value="harvested">
                          <label class="form-check-label" for="harvestedYes">
                              Yes
                          </label>
                        <input class="form-check-input square-radio" type="radio" name="mark_crop" id="harvestedNo" value="crop_planted" checked>
                        <label class="form-check-label" for="harvestedNo">No</label>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

          <?php if ($row['crop_status'] == "harvested") {
            echo "<button type='' disabled class='btn btn-primary'>Save changes</button>";
          } else{
            echo "<button type='submit' class='btn btn-primary'>Save changes</button>";
          }
          ?>
          
        </div>

      </form>
      <!-- Form ends here -->

    </div>
  </div>
</div>

