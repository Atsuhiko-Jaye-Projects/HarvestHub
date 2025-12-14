<?php
$farm_resource_id = isset($_GET['fid']) ? $_GET['fid'] : null;
ob_start();
include_once "../../../../config/core.php";
include_once "../../../../config/database.php";
include_once "../../../../objects/farm-resource.php";
include_once "../../../../objects/farm_activities.php";

$database = new Database();
$db = $database->getConnection();

$farm_resource = new FarmResource($db);
$farm_activity = new FarmActivity($db);

$page_title = "Edit Activities";
$require_login = true;
include_once "../../../../login_checker.php";
include_once "../../layout/layout_head.php";

// Get resource record info
$farm_resource->farm_resource_id = $farm_resource_id;
$farm_resource->getRecordTitle();

// Get activities under this resource
$farm_activity->farm_resource_id = $farm_resource_id;
$stmt = $farm_activity->readActivity();
$record_num = $stmt->rowCount();

// --- POST handler ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {

    $farm_resource_id = $_POST['farm_resource_id'];

    $activity_names   = $_POST['activity_name'] ?? [];
    $activity_types   = $_POST['farm_activity_type'] ?? [];
    $activity_costs   = array_map('floatval', $_POST['activity_cost'] ?? []);
    $additional_info  = $_POST['additional_info'] ?? [];
    $other_activity   = $_POST['other_activity'] ?? [];
    $activity_dates   = $_POST['activity_date'] ?? [];

    $grand_total = array_sum($activity_costs);

    $existing_activities = $farm_activity->readActivity();
    $existing_count = $existing_activities->rowCount();
    $activity_ids = $_POST['activity_id'] ?? [];

    foreach ($activity_names as $key => $name) {

        if (empty($name) && empty($activity_costs[$key])) continue;

        $farm_activity->farm_resource_id = $farm_resource_id;
        $farm_activity->activity_name = $name;
        $farm_activity->farm_activity_type = $activity_types[$key] ?? '';
        $farm_activity->activity_cost = $activity_costs[$key] ?? 0;
        $farm_activity->activity_date = substr($activity_dates[$key], 0, 10);

        if ($farm_activity->farm_activity_type === 'others') {
            $farm_activity->additional_info = $other_activity[$key] ?? '';
        } else {
            $farm_activity->additional_info = $additional_info[$key] ?? null;
        }

        if (!empty($activity_ids[$key])) {
            // Update
            $farm_activity->id = $activity_ids[$key];
            if ($farm_activity->updateFarmActivity()) {                     ;
                echo "Update Success";

            }else{
                echo "Update Failed";
            }

        } else {
            // Insert
            
            $farm_activity->createFarmActivity();
            echo "Inserted Data";
        }
    }

    // Update farm resource record
    $farm_resource->farm_resource_id = $farm_resource_id;
    $farm_resource->grand_total      = $grand_total;
    $farm_resource->updateFarmResource();

    header("Location: edit_activities.php?fid={$farm_resource_id}&status=update_success");
    exit;
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?fid={$farm_resource_id}");?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="farm_resource_id" value="<?= htmlspecialchars($farm_resource_id) ?>">


            <div class="modal-header d-block">
                <h4 class="modal-title mb-3">
                    <i class="bi bi-pencil-square"></i>
                    Update Farm Input
                </h4>
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Update all activities information needed to record this expense.
                </small>
            </div>
            <hr>

            <div class="modal-body">
                <div class="mb-3 row">
                    <div class="col-md-6 mb-3">
                        
                        <label class="form-label fw-bold col-md-4">Expense Record Title:</label>
                        <input type="text" name="record_name" class="form-control border border-3 border-success" readonly value="<?= htmlspecialchars($farm_resource->record_name) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold col-md-4">Date of Activity:</label>
                        <input type="date" name="activity_date" class="form-control border border-3 border-warning" max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime($farm_resource->date)) ?>" required>
                    </div>
                    <hr>
                </div>

                <div id="dynamic-fields-frame" class="frame bg-light">
                    <div id="dynamic-fields">
                        <?php
                        if ($record_num>0) {
                            $activityCount = 1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <div class="item-block mb-3 border-bottom pb-2">
                            <div class="d-flex align-items-center justify-content-between p-2 mb-2">
                                <input type="hidden" name="activity_id[]" value="<?= $row['id']; ?>">
                                <h5 class="mb-0">Activity No. <?= $activityCount ?></h5>
                            </div>

                            <div class="row g-2 align-items-center">
                                <div class="col-md-4">
                                    <label>Activity Name</label>
                                    <input type="text" name="activity_name[]" class="form-control border border-2 border-dark" value="<?= htmlspecialchars($row['activity_name']) ?>">
                                </div>

                                <div class="col-md-4">
                                    <label>Activity Type</label>
                                    <select name="farm_activity_type[]" class="form-select border border-2 border-dark" onchange="toggleOtherInput(this)">
                                        <option value="" disabled>Select activity</option>
                                        <?php
                                        $activityTypes = [
                                            'land_prep'=>'Land Prep. Expense','nursery_seedling'=>'Nursery / Seedling Prep.',
                                            'transplanting'=>'Transplanting','crop_maintenance'=>'Crop Care & Maintenance',
                                            'input_seed_fertilizer'=>'Input (Seeds, Fertilizer, etc.)','harvesting'=>'Harvesting',
                                            'post_harvest_transport'=>'Post-Harvest / Transport','irrigation'=>'Irrigation / Watering',
                                            'pest_control'=>'Pest / Disease Control','pruning'=>'Pruning / Trimming',
                                            'mulching'=>'Mulching','fertilizer_application'=>'Fertilizer Application',
                                            'soil_testing'=>'Soil Testing / Analysis','weeding'=>'Weeding / Grass Removal',
                                            'packing'=>'Packing / Grading','others'=>'Others'
                                        ];
                                        foreach ($activityTypes as $val => $label) {
                                            $sel = ($row['farm_activity_type'] === $val) ? 'selected' : '';
                                            echo "<option value=\"$val\" $sel>$label</option>";
                                        }
                                        ?>
                                    </select>

                                    <input type="text" name="other_activity[]" class="form-control mt-2 <?= $row['farm_activity_type']==='others' ? '' : 'd-none' ?>" placeholder="Enter other activity" value="<?= htmlspecialchars($row['additional_info']) ?>">
                                </div>

                                <div class="col-md-4">
                                    <label>Cost (₱)</label>
                                    <input type="number" name="activity_cost[]" class="form-control activity-cost border border-2 border-dark" value="<?= $row['activity_cost'] ?>">
                                </div>

                                <div class="col-md-4">
                                    <label>Additional Info</label>
                                    <textarea name="additional_info[]" class="form-control border border-2 border-dark" rows="3"><?= htmlspecialchars($row['additional_info']) ?></textarea>
                                </div>

                                <div class="col-md-4">
                                    <label>Date Done</label>
                                    <input type="date" name="activity_date[]" class="form-control border border-2 border-dark" value="<?= date('Y-m-d', strtotime($row['activity_date'])) ?>">
                                </div>
                            </div>
                        </div>
                        <?php
                            $activityCount++;
                            endwhile;
                        }
                        ?>
                    </div>
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
                <a href="farm_resource.php" class="btn btn-secondary m-2"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Save</button>
            </div>
        </form>
    </div>
</div>

</div>
</div>
</div>
</div>

<!-- CORE js Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.4/bootbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let activityCount = <?= $record_num>0 ? $record_num : 0 ?>;
// // const params = new URLSearchParams(window.location.search);
// // const farm_resource_id = params.get('fid'); // STRING

// console.log('FID:', farm_resource_id);

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
            <div class="col-md-4"><label>Activity Name</label><input type="text" name="activity_name[]" class="form-control border border-2 border-dark"></div>
            <div class="col-md-4">
                <label>Activity Type</label>
                <select name="farm_activity_type[]" class="form-select border border-2 border-dark" onchange="toggleOtherInput(this)">
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
                <input type="text" name="other_activity[]" class="form-control mt-2 d-none border border-2 border-dark" placeholder="Enter other activity">
            </div>
            <div class="col-md-4"><label>Cost (₱)</label><input type="number" name="activity_cost[]" class="form-control activity-cost border border-2 border-dark"></div>
            <div class="col-md-4"><label>Additional Info</label><textarea name="additional_info[]" class="form-control border border-2 border-dark" rows="3"></textarea></div>
            <div class="col-md-4"><label>Date Done</label><input type="date" name="activity_date[]" class="form-control border border-2 border-dark"></div>
        </div>
    `;
    frame.appendChild(div);
    div.querySelector('.activity-cost').addEventListener('input', updateTotal);
    updateItemNumbers();
}

function removeItem(btn){ 
    btn.closest('.item-block').remove(); 
    updateItemNumbers(); 
    updateTotal(); 
}

function updateItemNumbers(){ 
    document.querySelectorAll('.item-block h5').forEach((label,i)=>label.textContent="Activity No. "+(i+1)); 
}
function toggleOtherInput(sel){ 
    const inp=sel.nextElementSibling; 
    if(sel.value==='others'){
        inp.classList.remove('d-none'); 
        inp.required=true;
    }else{
        inp.classList.add('d-none'); 
        inp.required=false;
}}
function updateTotal(){ 
    let t = 0;
    document.querySelectorAll('.activity-cost').forEach(i => {
        t += parseFloat(i.value) || 0;
    });
    document.getElementById('total-value').textContent = t.toFixed(2);
}

// auto-detect any cost change (existing + new)
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('activity-cost')) {
        updateTotal();
    }
});

// initial scan
document.addEventListener('DOMContentLoaded', function () {
    updateTotal();
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

    <?php if ($_GET['status'] == 'error'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Failed to Save Resource Info',
            text: 'Please try again.',
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
