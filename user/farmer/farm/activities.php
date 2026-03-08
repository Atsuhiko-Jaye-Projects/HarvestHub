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
    
    $farm_resource->record_name = $_POST['record_name'];
    $farm_resource->user_id = $_SESSION['user_id'];
    $farm_resource->crop_name = $_POST['crop_name'];

    if ($farm_resource->checkRecordName()) {
        header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=record_name_taken");
        exit;
    } else if($farm_resource->checkCropName()){
        header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=crop_name_taken");
        exit;
    } else if($farm->isLotSizeExceeded($_POST['planted_area_sqm'])) {
        header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=farm_size_exceeded");
        exit;
    } else {
        $resource_id = 'FID' . preg_replace('/[^0-9]/', '', uniqid());
        
        $activity_names = $_POST['activity_name'] ?? [];
        $farm_activity_types = $_POST['farm_activity_type'] ?? [];
        $activity_costs = $_POST['activity_cost'] ?? [];
        $additional_infos = $_POST['additional_info'] ?? [];
        $activity_dates = $_POST['activity_date'] ?? [];

        $activity_costs_numeric = array_map('floatval', $activity_costs);
        $grand_total = array_sum($activity_costs_numeric);

        for ($i = 0; $i < count($activity_names); $i++) {
            if (empty($activity_names[$i]) && empty($farm_activity_types[$i])) continue;

            $farm_activity->record_name = $_POST['record_name'];
            $farm_activity->activity_name = $activity_names[$i];
            $farm_activity->farm_activity_type = $farm_activity_types[$i];
            $farm_activity->activity_cost = $activity_costs[$i] ?? 0;
            $farm_activity->additional_info = !empty($additional_infos[$i]) ? $additional_infos[$i] : null;
            $farm_activity->activity_date = !empty($activity_dates[$i]) ? $activity_dates[$i] : $_POST['activity_date_main'];
            $farm_activity->farm_resource_id = $resource_id;
            
            $farm_activity->createFarmActivity();
        }

        $farm_resource->farm_resource_id = $resource_id;
        $farm_resource->record_name = $_POST['record_name'];
        $farm_resource->crop_name = $_POST['crop_name'];
        $farm_resource->grand_total = $grand_total;
        $farm_resource->user_id = $_SESSION['user_id'];
        $farm_resource->date = $_POST['activity_date_main'];
        $farm_resource->planted_area_sqm = $_POST['planted_area_sqm'];
        $farm_resource->average_yield_per_plant = $_POST['average_yield_per_plant'];
        $farm_resource->plant_count = $_POST['plant_count'];

        if ($farm_resource->createFarmResource()) {
            header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=success");
            exit;
        } else {
            header("LOCATION:{$base_url}user/farmer/farm/activities.php?status=error");
            exit;
        }
    }
}
?>

<style>
    :root { --primary-green: #2ecc71; --dark-bg: #1a1a1a; }
    @media (min-width: 1200px) { .modal-xl { max-width: 95% !important; } }
    
    .modal-content { border-radius: 12px; overflow: hidden; border: none; }
    .custom-card { border: 1px solid #dee2e6; border-radius: 10px; background: #fff; }
    .section-title { font-size: 0.85rem; letter-spacing: 1px; color: #6c757d; font-weight: 800; }
    .form-control-custom { border: 2px solid #eee; border-radius: 8px; padding: 10px; font-weight: 500; }
    .form-control-custom:focus { border-color: var(--primary-green); box-shadow: none; }
    .calc-box { background: #f8f9fa; border: 1px solid #eee; padding: 12px; border-radius: 8px; height: 100%; }
    .expense-display-card { border: 2px dashed #dc3545; border-radius: 10px; background: #fff5f5; }
</style>

<div class="modal-dialog modal-xl">
    <div class="modal-content shadow-lg">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="farmForm">
            <input type="hidden" name="action" value="create">

            <div class="modal-header bg-dark text-white p-4 border-0">
                <h4 class="mb-0 fw-bold"><i class="bi bi-journal-plus me-2 text-success"></i>FARM RESOURCE INPUT</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                
                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="custom-card p-4 h-100 shadow-sm">
                            <p class="section-title mb-3 text-uppercase">General Information</p>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="small fw-bold">Project / Record Name</label>
                                    <input type="text" name="record_name" class="form-control form-control-custom" placeholder="Batch #001 - Marubay" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold">Record Date</label>
                                    <input type="date" name="activity_date_main" value="<?php echo date('Y-m-d'); ?>" class="form-control form-control-custom" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="expense-display-card p-4 h-100 d-flex flex-column align-items-center justify-content-center shadow-sm">
                            <p class="section-title mb-1 text-danger text-uppercase">Total Expenses</p>
                            <h1 class="fw-bold text-danger mb-0">₱ <span id="display-total-expenses">0.00</span></h1>
                        </div>
                    </div>
                </div>

                <div class="custom-card p-4 mb-4 shadow-sm border-top border-4 border-success">
                    <p class="section-title mb-3 text-uppercase">Yield Computation</p>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="small fw-bold">Seed Type</label>
                            <input type="text" name="crop_name" id="crop_name" class="form-control form-control-custom" placeholder="Crop name" required>
                        </div>
                        <div class="col-md-2">
                            <label class="small fw-bold">Total Area (SQM)</label>
                            <input type="number" step="0.1" name="planted_area_sqm" id="planted_area_sqm" class="form-control form-control-custom" required>
                        </div>
                        <div class="col-md-2">
                            <div class="calc-box">
                                <label class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Ave Yield/Plant</label>
                                <div class="d-flex align-items-center">
                                    <input type="number" step="0.01" name="average_yield_per_plant" id="average_yield" class="form-control-plaintext fw-bold p-0" value="0.00" readonly>
                                    <span class="small fw-bold ms-1">kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                             <div class="calc-box">
                                <label class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Total Plants</label>
                                <input type="number" name="plant_count" id="plant_count" class="form-control-plaintext fw-bold p-0" value="0" readonly>
                             </div>
                        </div>
                        <div class="col-md-4">
                             <div class="calc-box border-success bg-white" style="border-width: 2px !important;">
                                <label class="small fw-bold text-success text-uppercase">Est. Total Yield (KG)</label>
                                <h3 class="fw-bold text-success mb-0" id="display-total-yield">0.00</h3>
                                <input type="hidden" id="total_average_yield" step="0.01">
                             </div>
                        </div>
                    </div>
                </div>

                <div class="custom-card p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="section-title mb-0 text-uppercase">Activity Breakdown</p>
                        <button type="button" class="btn btn-outline-dark btn-sm fw-bold" onclick="addDynamicField()">
                            <i class="bi bi-plus-circle me-1"></i> ADD ACTIVITY
                        </button>
                    </div>
                    
                    <div id="dynamic-fields-container" style="max-height: 350px; overflow-y: auto;">
                        </div>
                </div>

            </div>

            <div class="modal-footer bg-white p-4 border-0">
                <button type="button" class="btn btn-light px-4 fw-bold text-muted" data-bs-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">SAVE RECORD</button>
            </div>
        </form>
    </div>
</div>

<?php include_once "../layout/layout_foot.php"; ?>

<script>
const templates = {
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

// --- FORMULA LOGIC (ADVISER) ---
function runCalculations() {
    const sqm = parseFloat(document.getElementById("planted_area_sqm").value) || 0;
    const yieldPlant = parseFloat(document.getElementById("average_yield").value) || 0;

    const totalPlants = Math.round(sqm * yieldPlant);
    const totalAveKg = (totalPlants * yieldPlant).toFixed(2);

    document.getElementById("plant_count").value = totalPlants;
    document.getElementById("display-total-yield").innerText = totalAveKg;
    document.getElementById("total_average_yield").value = totalAveKg;
}

document.getElementById("planted_area_sqm").addEventListener("input", runCalculations);

document.getElementById("crop_name").addEventListener("blur", async function () {
    const name = this.value.trim();
    if (!name) return;
    try {
        const response = await fetch("/HarvestHub/js/user/farmer/api/get_average_yield.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "plant_name=" + encodeURIComponent(name)
        });
        const data = await response.json();
        if (data.success) {
            document.getElementById("average_yield").value = data.average_yield_per_plant;
            runCalculations();
        }
    } catch (e) { console.error(e); }
});

// --- DYNAMIC EXPENSES LOGIC ---
function addDynamicField() {
    const container = document.getElementById("dynamic-fields-container");
    const div = document.createElement("div");
    div.className = "row g-2 mb-2 align-items-center p-2 border rounded bg-white";
    div.innerHTML = `
        <div class="col-md-3">
            <select name="farm_activity_type[]" class="form-select form-control-custom activity-type" required style="padding: 5px 10px;">
                <option value="" disabled selected>Category</option>
                <option value="land_prep">Land Prep</option>
                <option value="nursery_seedling">Nursery</option>
                <option value="transplanting">Transplanting</option>
                <option value="irrigation">Irrigation</option>
                <option value="weeding">Weeding</option>
                <option value="fertilizer_application">Fertilizer</option>
                <option value="pest_control">Pest Control</option>
                <option value="harvesting">Harvesting</option>
                <option value="packing">Packing</option>
                <option value="others">Others</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="activity_name[]" class="form-select form-control-custom activity-name" style="padding: 5px 10px;"></select>
            <input type="text" name="other_activity[]" class="form-control form-control-custom d-none" placeholder="Specify activity">
        </div>
        <div class="col-md-2">
            <input type="number" name="activity_cost[]" class="form-control form-control-custom activity-cost text-end" placeholder="₱ 0.00" required style="padding: 5px 10px;">
        </div>
        <div class="col-md-2">
            <input type="date" name="activity_date[]" class="form-control form-control-custom" value="<?php echo date('Y-m-d'); ?>" style="padding: 5px 10px;">
        </div>
        <div class="col-md-1">
            <input type="text" name="additional_info[]" class="form-control form-control-custom" placeholder="Notes" style="padding: 5px 10px;">
        </div>
        <div class="col-md-1 text-center">
            <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="this.closest('.row').remove(); updateTotal();"><i class="bi bi-trash"></i></button>
        </div>
    `;
    container.appendChild(div);

    const typeSel = div.querySelector(".activity-type");
    const nameSel = div.querySelector(".activity-name");
    const otherInp = div.querySelector("input[name='other_activity[]']");

    typeSel.addEventListener("change", function() {
        nameSel.innerHTML = "";
        if(templates[this.value] && this.value !== "others") {
            otherInp.classList.add("d-none");
            nameSel.classList.remove("d-none");
            templates[this.value].forEach(n => nameSel.add(new Option(n, n)));
        } else {
            otherInp.classList.remove("d-none");
            nameSel.classList.add("d-none");
        }
    });
    div.querySelector(".activity-cost").addEventListener("input", updateTotal);
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.activity-cost').forEach(i => total += (parseFloat(i.value) || 0));
    document.getElementById('display-total-expenses').textContent = total.toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2});
}

document.addEventListener("DOMContentLoaded", () => addDynamicField());
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_GET['status'])): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const s = "<?php echo $_GET['status']; ?>";
        if(s === 'success') Swal.fire('Success', 'Record Saved!', 'success');
        if(s.includes('taken')) Swal.fire('Duplicate', 'Record or Crop name already exists.', 'error');
        if(s === 'farm_size_exceeded') Swal.fire('Warning', 'Planted area exceeds available lot size!', 'warning');
    });
</script>
<?php endif; ?>