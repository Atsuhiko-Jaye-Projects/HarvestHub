
<?php
$showHarvestOption = false;

if (!empty($row['date_planted']) && !empty($row['estimated_harvest_date'])) {

    $planted = new DateTime($row['date_planted']);
    $estimatedHarvest = new DateTime($row['estimated_harvest_date']);
    $today = new DateTime();

    $totalDays = $planted->diff($estimatedHarvest)->days;

    if ($totalDays > 0) {
        $remainingDays = $today->diff($estimatedHarvest)->days;
        $thresholdDays = ceil($totalDays * 0.15);

        if ($remainingDays <= $thresholdDays) {
            $showHarvestOption = true;
        }
    }
}
?>

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
              <input type="hidden" name="farm_resource_id" value='<?php echo $row['farm_resource_id'];?>'>

              <!-- get the expense amount -->
              <?php
                $farm_resource->farm_resource_id = $row['farm_resource_id'];
                $expense = $farm_resource->cropExpense();
              ?>
              <input type="hidden" id="expense" name="total_plant_expense" value='<?php echo $expense; ?>'>
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
                    <label> Harvest Date</label>
                    <input type="date" id="estimated_harvest_date" name="estimated_harvest_date" class="form-control" value='<?php echo $row['estimated_harvest_date'];?>'>
                  </div>
                  <div class="col-md-6">
                    <label>Est. No. of Plants (pc)</label>
                    <input type="number" id="est_plant_count" name="plant_count" class="form-control" value='<?php echo $row['plant_count'];?>' readonly>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label>Cultivated Area (SQM)</label>
                    <input type="number"
                    name="cultivated_area"
                    class="form-control"
                    onchange="
                      if (this.value < 50) { alert('Minimum cultivated area size is 50 sqm'); this.value = 50; }
                      if (this.value > 5000) { alert('Maximum cultivated area size is 5000 sqm'); this.value = 5000; }" value='<?php echo $row['cultivated_area'];?>' readonly>
                </div>
                <div class="col-md-6">
                    <label>
                      Yield/Plant (kg) 
                    </label>
                    <input type="number" name="kilo_per_plant" value='<?php echo $row['yield'];?>' class="form-control" >
                </div>
                <?php if ($row['crop_status'] == "harvested") {
                  
                }else{
                ?>
                <?php if ($showHarvestOption) { ?>
                    <div class="col-md-6 mt-3">
                      <label class="text-nowrap">Mark this crop as Harvested?</label><br>
                      
                      <input class="form-check-input" type="radio"
                            id="mark-harvested"
                            name="mark_crop"
                            value="harvested">
                      <label class="form-check-label">
                          Yes
                      </label>

                      <input class="form-check-input ms-2"
                            type="radio"
                            name="mark_crop"
                            value="crop_planted" checked>
                      <label class="form-check-label">
                          No
                      </label>
                    </div>
                  <?php } ?>
                <?php } ?>
                <!-- hidden inputs -->
                <div id="actual-inputs" hidden>
                  <hr class="mt-3 mb-3">
                  <h6 class="text-muted mb-3">Yield Summary</h6>
                  <div class="row mb-3" >
                    <div class="col-md-6">
                      <label>Est. Yield/Plant (KG)</label>
                      <input type="number" id="est_yield_plant" class="form-control mb-2" value='<?php echo $row['yield'];?>' readonly>
                    </div>
                    <div class="col-md-6">
                      <label>Actual Yield/Plant (KG)</label>
                      <input type="number" step = "0.1" id="actual_yield_per_plant" name="actual_yield_per_plant" class="form-control mb-2">
                    </div>
                    <div class="col-md-6">
                        <label>Est. Yield/KG</label>
                        <input type="number" id="est_yield" class="form-control mb-2" readonly>
                    </div>
                    <div class="col-md-6">
                      <label>Actual Harvest(KG)</label>
                      <input type="number" id="actual_harvested" name="actual_yield" class="form-control mb-2">
                    </div>
                    <div class="col-md-6">
                        <label>Profit Margin(%)</label>
                        <input type="number"  step="0.1" id="profit_margin" class="form-control mb-2">
                    </div>
                    <div class="col-md-6">
                      <label>Est. Selling Price</label>
                      <input type="number" step= "0.3" id="est_selling_price"name="selling_price" class="form-control mb-2">
                    </div>
                  </div>
                </div>
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

<script>
document.addEventListener("change", function (e) {

  if (e.target.name !== "mark_crop") return;

  const actualInputs = document.getElementById("actual-inputs");

  actualInputs.hidden = (e.target.value !== "harvested");
});
</script>



<script>
function calculateEstimatedSellingPrice() {
  const profitMarginInput = document.getElementById("profit_margin");
  const sellingPriceInput = document.getElementById("est_selling_price");
  const expenseInput = document.getElementById("expense");
  const actualHarvestedInput = document.getElementById("actual_harvested");

  if (!profitMarginInput || !sellingPriceInput || !expenseInput || !actualHarvestedInput) return;

  const profitMargin = parseFloat(profitMarginInput.value) || 0;
  const expense = parseFloat(expenseInput.value) || 0;
  let actualHarvested = parseFloat(actualHarvestedInput.value) || 0;

  const marginPercent = parseFloat(profitMarginInput.value) || 0;
  const marginDecimal = marginPercent / 100;

  // Prevent division by zero
  if (actualHarvested <= 0) {
    sellingPriceInput.value = "";
    return;
  }

  const costPerKg = expense / actualHarvested;
  const sellingPrice = costPerKg * (1 + marginDecimal);

  // No rounding — raw value
  sellingPriceInput.value = Number(sellingPrice.toFixed(2));
}


function calculateEstimatedYield() {
  const yieldPerPlantInput = document.getElementById("est_yield_plant");
  const plantCountInput = document.getElementById("est_plant_count");
  const estimatedYieldInput = document.getElementById("est_yield");


  if (!yieldPerPlantInput || !plantCountInput || !estimatedYieldInput ) return;

  const yieldPerPlant = parseFloat(yieldPerPlantInput.value) || 0;
  const plantCount = parseFloat(plantCountInput.value) || 0;
  const result = yieldPerPlant * plantCount;
  
  estimatedYieldInput.value = Number(result.toFixed(2));
}

// Run calculation when the modal loads or page loads
document.addEventListener("DOMContentLoaded", calculateEstimatedYield);

// Run calculation on input
document.addEventListener("DOMContentLoaded", calculateEstimatedSellingPrice);
document.addEventListener("input", function (e) {
  if (
    ["profit_margin", "expense", "actual_harvested"].includes(e.target.id)
  ) {
    calculateEstimatedSellingPrice();
  }
});
</script>




