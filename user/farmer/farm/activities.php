<?php
ob_start();
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/farm-resource.php";
include_once "../../../objects/farm_activities.php";
include_once "../../../objects/farm.php";


$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);
$farm_activity = new FarmActivity($db);
$farm  = new Farm($db);

$page_title = "Farm Inputs";
$require_login = true;
include_once "../../../login_checker.php";
include_once "../layout/layout_head.php";


// --- POST handler ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
  include_once "../../../config/database.php";
	include_once "../../../objects/farm-resource.php";

	$database = new Database();
	$db = $database->getConnection();

	$farm_resource = new FarmResource($db);


	if ($_POST["action"]=="create") {
		
        // the input record title
        $farm_resource->record_name = $_POST['record_name'];
        $farm_resource->user_id = $_SESSION['user_id'];
        $farm_resource->crop_name = $_POST['crop_name'];


        if ($farm_resource->checkRecordName()) {
            header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=record_name_taken");
            exit;
        }else if($farm_resource->checkCropName()){
            header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=crop_name_taken");
            exit;
        }else if($farm->isLotSizeExceeded($_POST['planted_area_sqm'])) {
            header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=farm_size_exceeded");
            exit;
        }else{
            $resource_id = 'FID' . preg_replace('/[^0-9]/', '', uniqid());
            
            // bind the values first to variable
            $activity_names = $_POST['activity_name'];
            $farm_activity_type = $_POST['farm_activity_type'];
            $other_farm_activity = $_POST['other_activity'];
            $activity_cost = $_POST['activity_cost'] ?? [];
            $additional_info = $_POST['additional_info'];
            $activity_date = $_POST['activity_date'];

            // compute total expense
            $activity_cost = array_map('floatval', $activity_cost);

            $grand_total = array_sum($activity_cost);

            for ($i = 0; $i < count($activity_names); $i++) {

                // Skip empty rows
                if (
                    empty($activity_names[$i]) &&
                    empty($farm_activity_type[$i]) &&
                    empty($activity_cost[$i])
                ) {
                    continue;
                }

                $farm_activity->record_name = $_POST['record_name'];
                $farm_activity->activity_name = $activity_names[$i] ?? '';
                $farm_activity->farm_activity_type = $farm_activity_type[$i] ?? '';
                $farm_activity->activity_cost = $activity_cost[$i] ?? 0;
                $farm_activity->additional_info = !empty($additional_info[$i]) 
                ? $other_farm_activity[$i] 
                : null;
                $farm_activity->additional_info = !empty($additional_info[$i]) ? $additional_info[$i] : null;
                $farm_activity->activity_date = $activity_date[$i] ?? null;
                $farm_activity->farm_resource_id = $resource_id;

                $farm_activity->createFarmActivity();
            }

            $farm_resource->farm_resource_id = $resource_id;
            $farm_resource->record_name = $_POST['record_name'];
            $farm_resource->crop_name = $_POST['crop_name'];
            $farm_resource->grand_total = $grand_total;
            $farm_resource->user_id = $_SESSION['user_id'];
            $farm_resource->date = $_POST['activity_date'];
            $farm_resource->planted_area_sqm = $_POST['planted_area_sqm'];
            $farm_resource->average_yield_per_plant = $_POST['average_yield_per_plant'];
            $farm_resource->plant_count = $_POST['plant_count'];

            if ($farm_resource->createFarmResource()) {
                header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=success");
                exit;
            }
        }
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">

            <div class="modal-header d-block">
                <h4 class="modal-title mb-3">
                    <i class="bi bi-plus-square mb-3"></i>
                    New Farm Input
                </h4>
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Enter all activities information needed to record this expense.
                </small>
            </div>
            <hr>

            <div class="modal-body">
                <div class="mb-3 row">
                  <div class="col-md-6 mb-3">
                    <label for="record_name" class="form-label fw-bold col-md-6">Record Title:</label>
                    <input type="text" name="record_name" id="record_name" class="form-control border border-3 border-dark" required>
                  </div>
                
                  <div class="col-md-6 mb-3">
                    <label for="record_name" class="form-label fw-bold col-md-6">Date of Activity:</label>                    
                    <input type="date" name="activity_date" id="activity_date" value="<?php echo date('Y-m-d'); ?>"
                          class="form-control border border-3 border-dark"
                          max="<?php echo date('Y-m-d'); ?>"
                          required>
                  </div>
                  <hr>
                  <div class="col-md-3 mb-3">
                    <label for="record_name" class="form-label fw-bold col-md-4">Seed Type:</label>
                    <input type="text" name="crop_name" id=""
                          class="form-control border border-3 border-dark"
                          required>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="record_name" class="form-label fw-bold col-md-4 text-nowrap">Total Plants Planted:</label>
                    <input type="number" name="plant_count" id="" class="form-control border border-3 border-dark" required>
                  </div>

                    <div class="col-md-3 mb-3">
                    <label for="record_name" class="form-label fw-bold text-nowrap">
                        Average Yield per Plant (kg)
                    </label>
                    <input type="number" step="0.1" name="average_yield_per_plant" class="form-control border border-3 border-dark" required>
                    </div> 

                    <div class="col-md-3 mb-3">
                    <label for="record_name" class="form-label fw-bold text-nowrap">
                       Total Planted Area (sqm) 
                    </label>
                    <input type="number" step="0.1" name="planted_area_sqm" class="form-control border border-3 border-dark" required>
                    </div>  
                </div>

                <div id="dynamic-fields-frame" class="frame bg-light">
                    <div id="dynamic-fields"></div>
                </div>

              <div class="row align-items-center mt-3">
                  <div class="col-md-6 col-sm-6">
                      <button type="button" class="btn btn-primary" onclick="addDynamicField()">+ Add Field</button>
                  </div>

                  <div class="col-md-6 col-sm-6 text-end">
                      <div id="total-cost" class="floating-total d-inline-block">
                          Total Cost: ₱<span id="total-value">0.00</span>
                      </div>
                  </div>
              </div>
            </div>

            <div class="modal-footer">
              <a href="../farm_resource.php" class="btn btn-secondary m-2">
                  <i class="bi bi-x-circle me-1"></i> Cancel
              </a>

              <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-circle me-1"></i> Save
              </button>
            </div>
        </form>
    </div>


</div>

<?php include_once "../layout/layout_foot.php"; ?>

<script>
const activityTemplates = {
  land_prep: [
    "Land clearing",
    "Removal of previous crop residues",
    "Manual plowing",
    "Tractor plowing",
    "Harrowing",
    "Land leveling",
    "Raised bed formation",
    "Furrow / ridge making",
    "Compost or manure incorporation",
    "Field marking & row layout"
  ],

  nursery_seedling: [
    "Seed selection & sorting",
    "Seed soaking / pre-germination",
    "Seed treatment",
    "Seed tray preparation",
    "Soil mix preparation",
    "Sowing seeds",
    "Watering seedlings",
    "Shade net installation",
    "Seedling hardening",
    "Seedling inspection"
  ],

  transplanting: [
    "Seedling pulling",
    "Root trimming",
    "Seedling transport",
    "Spacing & hole marking",
    "Transplanting seedlings",
    "Initial watering",
    "Replanting missing hills",
    "Starter fertilizer application",
    "Mulching after transplant",
    "Plant stand inspection"
  ],

  irrigation: [
    "Initial field watering",
    "Manual watering",
    "Drip irrigation setup",
    "Sprinkler irrigation",
    "Canal cleaning",
    "Pump operation",
    "Fuel cost for irrigation",
    "System maintenance",
    "Emergency watering",
    "Drainage control"
  ],

  fertilizer_application: [
    "Basal fertilizer application",
    "Side-dress fertilizing",
    "Foliar spraying",
    "Organic fertilizer application",
    "Compost application",
    "Lime application",
    "Micronutrient application",
    "Fertilizer mixing",
    "Fertilizer transport",
    "Fertilizer handling"
  ],

  weeding: [
    "Manual weeding",
    "Mechanical weeding",
    "Herbicide spraying",
    "Grass cutting",
    "Mulch replacement",
    "Border clearing",
    "Inter-row cultivation",
    "Volunteer plant removal",
    "Weed inspection",
    "Weed disposal"
  ],

  pest_control: [
    "Pest scouting",
    "Manual pest removal",
    "Insecticide spraying",
    "Fungicide spraying",
    "Biological control",
    "Trap installation",
    "Infected plant removal",
    "Sprayer cleaning",
    "Protective gear usage",
    "Damage assessment"
  ],

  harvesting: [
    "Harvest scheduling",
    "Manual harvesting",
    "Mechanical harvesting",
    "Sorting & cleaning",
    "Temporary storage",
    "Harvest labor cost",
    "Harvest tools preparation",
    "Yield recording",
    "Harvest transport",
    "Post-harvest inspection"
  ],

  packing: [
    "Product washing",
    "Grading & sorting",
    "Packing materials prep",
    "Packaging",
    "Labeling",
    "Weight measurement",
    "Storage preparation",
    "Quality inspection",
    "Loading",
    "Transport preparation"
  ]
};
</script>


<script>
let activityCount = 0;



function addDynamicField() {
    activityCount++;
    const frame = document.getElementById("dynamic-fields");

    const div = document.createElement("div");
    div.className = "item-block mb-3 border-bottom pb-2";

    div.innerHTML = `
        <div class="d-flex align-items-center justify-content-between p-2 mb-2">
            <h5 class="mb-0">Activity No. ${activityCount}</h5>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                <i class="bi bi-x-circle"></i>
            </button>
        </div>

        <div class="row g-2 align-items-center">

            <!-- ACTIVITY TYPE (FIRST) -->
            <div class="col-md-4">
                <label>Activity Type</label>
                <select name="farm_activity_type[]" 
                        class="form-select border border-2 border-dark activity-type">
                    <option value="" disabled selected>Select activity</option>
                    <option value="land_prep">Land Preparation</option>
                    <option value="nursery_seedling">Nursery / Seedling Prep</option>
                    <option value="transplanting">Transplanting</option>
                    <option value="irrigation">Irrigation</option>
                    <option value="fertilizer_application">Fertilizer Application</option>
                    <option value="weeding">Weeding</option>
                    <option value="pest_control">Pest / Disease Control</option>
                    <option value="harvesting">Harvesting</option>
                    <option value="packing">Packing / Grading</option>
                    <option value="others">Others</option>
                </select>
            </div>

            <!-- ACTIVITY NAME (SECOND) -->
            <div class="col-md-4">
                <label>Activity Name</label>
                <select name="activity_name[]" 
                        class="form-select border border-2 border-dark activity-name">
                    <option value="">Select activity name</option>
                </select>

                <!-- Appears only if Activity Type = others -->
                <input type="text" 
                       name="other_activity[]" 
                       class="form-control mt-2 d-none border border-2 border-dark"
                       placeholder="Enter other activity">
            </div>

            <!-- COST -->
            <div class="col-md-4">
                <label>Cost (₱)</label>
                <input type="number" 
                       name="activity_cost[]" 
                       class="form-control activity-cost border border-2 border-dark">
            </div>

            <!-- ADDITIONAL INFO -->
            <div class="col-md-4">
                <label>Additional Details or Other Information</label>
                <textarea name="additional_info[]" 
                          class="form-control border border-2 border-dark" 
                          rows="3"
                          placeholder="Enter additional details"></textarea>
            </div>

            <!-- DATE -->
            <div class="col-md-4">
                <label>Date Done (or Date Performed)</label>
                <input type="date" 
                       name="activity_date[]" 
                       class="form-control border border-2 border-dark">
            </div>

        </div>
    `;

    frame.appendChild(div);

    const typeSelect = div.querySelector(".activity-type");
    const nameSelect = div.querySelector(".activity-name");
    const otherInput = div.querySelector("input[name='other_activity[]']");

    // When activity type changes
    typeSelect.addEventListener("change", function () {
        const type = this.value;

        nameSelect.innerHTML = "";
        otherInput.classList.add("d-none");
        otherInput.value = "";

        // Default option
        const defaultOpt = document.createElement("option");
        defaultOpt.value = "";
        defaultOpt.textContent = "Select activity name";
        nameSelect.appendChild(defaultOpt);

        if (activityTemplates[type]) {
            activityTemplates[type].forEach((item, index) => {
                const opt = document.createElement("option");
                opt.value = item;
                opt.textContent = item;
                nameSelect.appendChild(opt);

                // ✅ Auto-select FIRST item
                if (index === 0) {
                    opt.selected = true;
                }
            });
        }

        // Others option
        if (type === "others") {
            otherInput.classList.remove("d-none");
            nameSelect.innerHTML = "";
        }
    });

    // Cost listener
    div.querySelector(".activity-cost").addEventListener("input", updateTotal);

    updateItemNumbers();
}



function removeItem(button) {
    button.closest('.item-block').remove();
    updateItemNumbers();
    updateTotal();
}

function updateItemNumbers() {
    const labels = document.querySelectorAll('.item-block h5');
    labels.forEach((label, index) => {
        label.textContent = "Activity No. " + (index + 1);
    });
}

function toggleOtherInput(selectElement) {
    const otherInput = selectElement.nextElementSibling;
    if (selectElement.value === "others") {
        otherInput.classList.remove("d-none");
        otherInput.required = true;
    } else {
        otherInput.classList.add("d-none");
        otherInput.required = false;
    }
}

function updateTotal() {
    const costInputs = document.querySelectorAll('.activity-cost');
    let total = 0;
    costInputs.forEach(input => total += parseFloat(input.value) || 0);
    document.getElementById('total-value').textContent = total.toFixed(2);
}

// Add 5 default rows
document.addEventListener("DOMContentLoaded", () => {
    for (let i = 0; i < 2; i++) addDynamicField();
});
</script>

<?php if (isset($_GET['status'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    <?php if ($_GET['status'] == 'success'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Resource Info Saved!',
            showConfirmButton: false,
            timer: 1800
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'record_name_taken'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Record Name is already taken.',
            showConfirmButton: false,
            timer: 1800
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'crop_name_taken'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Crop Name is already taken.',
            showConfirmButton: false,
            timer: 1800
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'error'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Failed to Save Resource Info',
            text: 'Please try again.',
            showConfirmButton: true
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'farm_size_exceeded'): ?>
    Swal.fire({
        icon: 'warning',
        title: 'Farm Area Exceeded',
        text: 'Your planted area exceeds the remaining farm lot size.',
        showConfirmButton: true
    });
    <?php endif; ?>


    <?php if ($_GET['status'] == 'update_success'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Resource Info Updated!',
            showConfirmButton: false,
            timer: 1800
        });
    <?php endif; ?>

    <?php if ($_GET['status'] == 'error'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Failed to Update Resource Info',
            text: 'Please try again.',
            showConfirmButton: true
        });
    <?php endif; ?>

});
</script>
<?php endif; ?>

<script>
if (window.history.replaceState) {
    const url = new URL(window.location);
    url.searchParams.delete('status');
    window.history.replaceState({}, document.title, url.pathname);
}
</script>
