<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/farm-resource.php";

$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);


$page_title = "Farm Resources & supplies";
$require_login=true;
include_once "../../../login_checker.php";
include_once "../layout/layout_head.php";
?>


<div class="">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        
        <div class="modal-header d-block">
          <h4 class="modal-title mb-3 ">
            <i class="bi bi-plus-square mb-3"></i> <!-- add icon -->
            New Farm Input
          </h4>
          <small class="text-muted">
            <i class="bi bi-info-circle me-1"></i> <!-- optional info icon -->
            Enter all activities information needed to record this expense.
          </small>
        </div>
        <hr>


        <div class="modal-body">
          <div class="mb-3 row">
            <div class="col-md-12 mt-3">
              <label class="form-label fw-bold">Expense Record Title:</label>
              <input type="text" name="record_name" id="item_name" class="form-control border border-2 border-dark" required>
              <hr>
              
            </div>
            <div id="dynamic-fields">
            </div>
          </div>

          <div class="col-md-12">
            <button type="button" class="btn btn-primary" onclick="addDynamicField()">+ Add Field</button>
          </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
      </form>
    </div>
    <div id="total-cost" class="floating-total">
    Total Cost: ₱<span id="total-value">0.00</span>
</div>
</div>



<?php include_once "../layout/layout_foot.php"; ?>

<script>


function addDynamicField(){
    const frame = document.getElementById("dynamic-fields");
    const div = document.createElement("div");
    div.className = "dynamic-row";
    div.innerHTML = `
        <div id="items-container">

        <div class="item-block">
            <h4 class="item-label">Activity No. 1</h4>

            <div class="row mb-3 align-items-center">
                <div class="col-3 col-md-3 mt-3">
                    <label class="l">Activity Name:</label>
                    <input type="text" name="record_name[]" class="form-control border border-2 border-dark" required>
                </div>
                <div class="col-3 col-md-3 mt-3">
                    <label class="">Activity No. 1</label>
                      <select name="farm_activity[]" class="form-select border border-2 border-dark" required onchange="toggleOtherInput(this)" >
                        <option value="" disabled selected>Select activity</option>
                        <option value="land_prep">Land Prep. Expense</option>
                        <option value="nursery_seedling">Nursery / Seedling Prep.</option>
                        <option value="transplanting">Transplanting</option>
                        <option value="crop_maintenance">Crop Care & Maintenance</option>
                        <option value="input_seed_fertilizer">Input (Seeds, Fertilizer, etc.)</option>
                        <option value="harvesting">Harvesting</option>
                        <option value="post_harvest_transport">Post-Harvest / Transport</option>
                        <option value="irrigation">Irrigation / Watering</option>
                        <option value="pest_control">Pest / Disease Control</option>
                        <option value="pruning">Pruning / Trimming</option>
                        <option value="mulching">Mulching</option>
                        <option value="fertilizer_application">Fertilizer Application</option>
                        <option value="soil_testing">Soil Testing / Analysis</option>
                        <option value="weeding">Weeding / Grass Removal</option>
                        <option value="packing">Packing / Grading</option>

                        <option value="others">Others</option>
                    </select>
                    <input type="text" name="other_activity[]" class="form-control mt-2 d-none" placeholder="Enter other activity">
                </div>
                <div class="col-3 col-md-3 mt-3">
                    <label class="">Cost</label>
                    <input type="number" name="activity_cost[]" class="form-control border border-2 border-dark activity-cost" required>
                </div>
                <div class="col-2 col-md-2 mt-3">
                    <label class="">Date</label>
                    <input type="date" name="record_name[]" class="form-control border border-2 border-dark" required>
                </div>

                <div class="col-1 col-md-1 mt-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">X</button>
                </div>
            </div>

            <hr class="mt-3">
        </div>

        </div>
    `;
    frame.appendChild(div);
    updateItemNumbers();
    div.querySelector('.activity-cost').addEventListener('input', updateTotal);
}

    function updateTotal() {
    const costInputs = document.querySelectorAll('.activity-cost');
    let total = 0;
    costInputs.forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('total-value').textContent = total.toFixed(2);
}

function updateItemNumbers() {
    const items = document.querySelectorAll(".item-block .item-label");
    items.forEach((label, index) => {
        label.textContent = "Activity No. " + (index + 1);
    });
}

function removeItem(button) {
    button.closest(".item-block").remove();
    updateItemNumbers();
}

/* Auto-number existing items on page load */
document.addEventListener("DOMContentLoaded", updateItemNumbers);

function toggleOtherInput(selectElement) {
    const otherInput = selectElement.nextElementSibling;
    if (selectElement.value === "others") { // "Others" selected
        otherInput.classList.remove("d-none");
        otherInput.required = true;
    } else {
        otherInput.classList.add("d-none");
        otherInput.required = false;
    }
}
</script>