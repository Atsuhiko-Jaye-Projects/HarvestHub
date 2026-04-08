<?php
// PHP Calculation Logic
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

// Get the expense amount
$farm_resource->farm_resource_id = $row['farm_resource_id'];
$expense = $farm_resource->cropExpense();
?>

<style>
#update-crop-modal-<?php echo $id; ?> .modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}
#update-crop-modal-<?php echo $id; ?> .modal-header {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    padding: 1.2rem 1.5rem;
}
#update-crop-modal-<?php echo $id; ?> .btn-close { filter: brightness(0) invert(1); }

.status-badge-container {
    background: #f0fdf4;
    border: 1px solid #dcfce7;
    padding: 1.2rem;
    border-radius: 15px;
    margin-bottom: 1.5rem;
}

.harvest-section {
    background-color: #fffbeb;
    border: 2px dashed #fcd34d;
    border-radius: 15px;
    padding: 1.5rem;
    margin-top: 1rem;
    display: none;
    animation: slideDown 0.3s ease-out;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-label { font-weight: 700; color: #4b5563; font-size: 0.85rem; margin-bottom: 5px; }
.yield-box { background: white; border-radius: 12px; padding: 12px; border: 1px solid #e5e7eb; height: 100%; }
</style>

<div class="modal fade" id="update-crop-modal-<?php echo $id; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> Update Plantation Progress
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="farm_resource_id" value="<?php echo $row['farm_resource_id']; ?>">
                    <input type="hidden" name="total_plant_expense" id="expense-<?php echo $id; ?>" value="<?php echo $expense; ?>">
                    <input type="hidden" name="cultivated_area" value="<?php echo $row['cultivated_area']; ?>">
                    <input type="hidden" name="crop_image" value="<?php echo $row['crop_image']; ?>">
                    <input type="hidden" name="profit_margin" id="hidden-margin-<?php echo $id; ?>" value="">

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Crop Name</label>
                            <input type="text" name="crop_name" class="form-control shadow-sm" required value="<?php echo ucwords($row['crop_name']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date Planted</label>
                            <input type="date" name="date_planted" class="form-control shadow-sm" required value="<?php echo $row['date_planted'];?>" readonly>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Est. Harvest Date</label>
                            <input type="date" name="estimated_harvest_date" class="form-control shadow-sm" value="<?php echo $row['estimated_harvest_date'];?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Plants (pcs)</label>
                            <input type="number" id="est_plant_count-<?php echo $id; ?>" name="plant_count" class="form-control bg-light" value="<?php echo $row['plant_count'];?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Est. Yield/Plant (kg)</label>
                            <input type="number" step="0.1" name="kilo_per_plant" id="est_yield_plant-<?php echo $id; ?>" class="form-control shadow-sm" value="<?php echo $row['yield'];?>">
                        </div>
                    </div>

                    <?php if ($row['crop_status'] != "harvested"): ?>
                        <?php if ($showHarvestOption): ?>
                        <div class="status-badge-container shadow-sm">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <h6 class="mb-0 fw-bold text-success"><i class="bi bi-check2-circle"></i> Harvest Ready?</h6>
                                    <small class="text-muted">You have reached the 15% harvest threshold.</small>
                                </div>
                                <div class="btn-group shadow-sm" role="group">
                                    <input type="radio" class="btn-check" name="mark_crop" id="no-<?php echo $id; ?>" value="crop_planted" checked onchange="toggleHarvest(this, '<?php echo $id; ?>')">
                                    <label class="btn btn-outline-secondary px-4" for="no-<?php echo $id; ?>">No</label>

                                    <input type="radio" class="btn-check" name="mark_crop" id="yes-<?php echo $id; ?>" value="harvested" onchange="toggleHarvest(this, '<?php echo $id; ?>')">
                                    <label class="btn btn-outline-success px-4" for="yes-<?php echo $id; ?>">Yes, Harvested</label>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div id="actual-inputs-<?php echo $id; ?>" class="harvest-section">
                        <h6 class="fw-bold text-warning-emphasis mb-4"><i class="bi bi-basket2-fill me-2"></i> Final Harvest Summary</h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 rounded-5 bg-primary bg-opacity-10 border border-primary border-opacity-10">
                                    <small class="text-primary fw-bold d-block mb-1">TOTAL YIELD (est)</small>
                                    <h4 class="fw-bold mb-0 text-primary"><?php echo number_format($stocks); ?> KG</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-5 bg-danger bg-opacity-10 border border-danger border-opacity-10">
                                    <small class="text-danger fw-bold d-block mb-1">TOTAL EXPENSES</small>
                                    <h4 class="fw-bold mb-0 text-danger">₱<?php echo number_format($expense); ?></h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div id="net-card-<?php echo $row['id']?>" class="p-3 rounded-5 bg-dark text-white shadow-lg transition-all" style="transition: 0.3s;">
                                    <small class="opacity-75 fw-bold d-block mb-1">EST. NET INCOME</small>
                                    <h4 id="net-income-label-<?php echo $row['id']?>" class="fw-bold mb-0">₱0.00</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="yield-box border-warning shadow-sm">
                                    <label class="form-label text-warning-emphasis">Actual Total Harvest (KG)</label>
                                    <input type="number" step="0.1" id="actual_harvested-<?php echo $id; ?>" name="actual_yield" class="form-control form-control-lg border-warning" placeholder="0.0">
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="yield-box border-warning shadow-sm">
                                    <label class="form-label">Reserved (kg)</label>
                                    <input type="text" name="reserved_kg" id="reserved_kg" class="form-control shadow-sm" placeholder="e.g. 20" value="<?php echo $row['reserve_kg']; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="p-4 rounded-5 border-2 border-dashed border-success bg-success bg-opacity-10">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold text-success mb-2">Set Your Selling Price per KG</label>
                                            <div class="input-group input-group-lg shadow-sm">
                                                <span class="input-group-text border-0 bg-success text-white rounded-start-4">₱</span>
                                                <input type="number" step="0.01" name="selling_price" class="form-control border-0 rounded-end-4 fw-bold" id="selling-price-<?php echo $row['id']?>" placeholder="0.00" required>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-end mt-3 mt-md-0">
                                            <small class="text-muted d-block fw-bold mb-1">TOTAL ESTIMATED REVENUE</small>
                                            <h3 id="revenue-text-<?php echo $row['id']?>" class="fw-bold text-success mb-0">₱0.00</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div id="status-box-<?php echo $row['id']?>" class="p-3 rounded-4 bg-light d-flex justify-content-between align-items-center transition-all">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-white rounded-circle shadow-sm me-3" id="margin-icon-<?php echo $row['id']?>">
                                            <i class="bi bi-graph-up-arrow text-muted"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted fw-bold d-block">PROFIT MARGIN</small>
                                            <span id="margin-text-<?php echo $row['id']?>" class="fw-bold h5 mb-0">0%</span>
                                        </div>
                                    </div>
                                    <span id="market-status-<?php echo $row['id']?>" class="badge rounded-pill bg-secondary px-4 py-2">Waiting...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Close</button>
                    <?php if ($row['crop_status'] == "harvested"): ?>
                        <button type="button" disabled class="btn btn-secondary px-4 rounded-pill">Already Harvested</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill shadow">Save Changes</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ===============================
// FINANCIAL CALCULATIONS
// ===============================
function updateFinancials(id) {
    const expense = parseFloat(document.getElementById(`expense-${id}`)?.value) || 0;
    const harvest = parseFloat(document.getElementById(`actual_harvested-${id}`)?.value) || 0;
    const price   = parseFloat(document.getElementById(`selling-price-${id}`)?.value) || 0;

    const revenue = harvest * price;
    const net = revenue - expense;
    const margin = harvest > 0 ? (net / expense) * 100 : 0;

    // Update Revenue
    const revenueText = document.getElementById(`revenue-text-${id}`);
    if (revenueText) {
        revenueText.innerText = "₱" + revenue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    // Update Net Income
    const netLabel = document.getElementById(`net-income-label-${id}`);
    if (netLabel) {
        netLabel.innerText = "₱" + net.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    // Update Profit Margin UI
    const marginLabel = document.getElementById(`margin-text-${id}`);
    if (marginLabel) {
        marginLabel.innerText = margin.toFixed(1) + "%";
        if (margin > 0) marginLabel.style.color = "green";
        else if (margin === 0) marginLabel.style.color = "gray";
        else marginLabel.style.color = "red";
    }

    // Update Hidden Input for Form Submission
    const hiddenInput = document.getElementById(`hidden-margin-${id}`);
    if (hiddenInput) hiddenInput.value = margin.toFixed(2);

    // Update Market Status
    const marketStatus = document.getElementById(`market-status-${id}`);
    if (marketStatus) {
        if (margin >= 20) {
            marketStatus.innerText = "Compliant";
            marketStatus.className = "badge rounded-pill bg-success px-4 py-2";
        } else if (margin < 0) {
            marketStatus.innerText = "Overpriced";
            marketStatus.className = "badge rounded-pill bg-danger px-4 py-2";
        } else {
            marketStatus.innerText = "Waiting...";
            marketStatus.className = "badge rounded-pill bg-secondary px-4 py-2";
        }
    }
}

// Listen to inputs for actual harvest or selling price
document.addEventListener("input", function(e) {
    if (
        e.target.id.includes("actual_harvested-") ||
        e.target.id.includes("selling-price-")
    ) {
        const id = e.target.id.split("-").pop();
        updateFinancials(id);
    }
});

// Show harvest section and recalc when toggled
function toggleHarvest(radio, id) {
    const section = document.getElementById(`actual-inputs-${id}`);
    if (radio.value === "harvested") {
        section.style.display = "block";
        updateFinancials(id);
    } else {
        section.style.display = "none";
    }
}
</script>