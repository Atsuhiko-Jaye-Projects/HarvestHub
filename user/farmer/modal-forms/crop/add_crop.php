<style>
    #new-crop-modal .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        overflow: hidden;
    }
    #new-crop-modal .modal-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }
    #new-crop-modal .modal-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    #new-crop-modal .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }
    #new-crop-modal .modal-body {
        padding: 2rem;
        background-color: #fcfdfd;
    }
    #new-crop-modal .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    #new-crop-modal .form-control, 
    #new-crop-modal .form-select {
        border-radius: 12px;
        padding: 0.65rem 1rem;
        border: 1px solid #e2e8f0;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    #new-crop-modal .form-control:focus, 
    #new-crop-modal .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }
    #new-crop-modal .input-group-text {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        border-radius: 12px;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
    }
    /* Section Divider Style */
    .form-section-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 1.25rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-section-title::after {
        content: "";
        height: 1px;
        background: #e2e8f0;
        flex: 1;
    }
    .modal-footer {
        background-color: #f8fafc;
        border-top: 1px solid #f1f5f9;
        padding: 1.25rem 2rem;
    }
    .btn-save-crop {
        background: #10b981;
        border: none;
        padding: 0.7rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-save-crop:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
</style>

<div class="modal fade" id="new-crop-modal" tabindex="-1" aria-labelledby="newCropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" id="cropForm">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="newCropModalLabel">
                        <i class="bi bi-patch-plus"></i> Add New Plantation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="crop_name" id="crop_name">
                    <input type="hidden" name="farm_resource_id" id="farmresourceid">

                    <div class="form-section-title">Planting Information</div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label"><i class="bi bi-search text-success"></i> Select Crop</label>
                            <select name="crop_name_id" id="cropSelect" class="form-select shadow-sm" required>
                                <?php
                                $farm_resource->user_id = $_SESSION['user_id'];
                                $stmt = $farm_resource->getCropName();
                                if ($stmt->rowCount() > 0) {
                                    echo "<option value='' selected disabled>-- Select from Resources --</option>";
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
                           <label class="form-label">
                              <i class="bi bi-calendar-check text-success"></i> Date Planted
                            </label>
                            <input type="date" name="date_planted" class="form-control" value="<?= date('Y-m-d'); ?>" 
                            >
                        </div>
                    </div>

                    <div class="form-section-title">Harvest & Yield Estimates</div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Estimated Harvest Date</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-range"></i></span>
                                <input type="date" id="estimated_harvest_date" name="estimated_harvest_date" class="form-control" value="<?php echo date('Y-m-d', strtotime('+45 days')); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Avg. Yield per Plant</label>
                            <div class="input-group shadow-sm">
                                <input type="number" step="0.01" name="kilo_per_plant" id="avgyeild" class="form-control" value="2.5" readonly>
                                <span class="input-group-text">KG</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title">Field & Scale Details</div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Total No. of Plants</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                <input type="number" name="plant_count" id="plantCount" class="form-control" placeholder="Input quantity" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cultivated Area Size</label>
                            <div class="input-group shadow-sm">
                                <input type="number" name="cultivated_area" id="area" class="form-control" step="0.01" value="50" readonly>
                                <span class="input-group-text">SQM</span>
                            </div>
                            <div class="form-text mt-2 ps-1" style="font-size: 0.75rem;">
                                <i class="bi bi-info-circle me-1"></i>  Standard: 50 - 5000 sqm
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted fw-bold me-auto" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary btn-save-crop shadow-sm">
                        <i class="bi bi-save2 me-2"></i> Save Plantation Detail
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const cropSelect = document.getElementById("cropSelect");
    
    cropSelect.addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        const cropId = this.value;
        const cropName = selectedOption.dataset.name;
        const farmResourceId = selectedOption.dataset.farmresourceId;

        // Populate hidden fields
        document.getElementById("crop_name").value = cropName || "";
        document.getElementById("farmresourceid").value = farmResourceId || "";

        if (!cropId) {
            resetFields();
            return;
        }

        // Fetch additional details from API
        fetch("../../../js/user/farmer/api/fetch_crop_details.php?id=" + cropId)
        .then(res => res.json())
        .then(data => {
            if (data) {
                document.getElementById("avgyeild").value = data.average_yield_per_plant || 2.5;
                document.getElementById("plantCount").value = data.plant_count || "";
                document.getElementById("area").value = data.planted_area_sqm || 50;
            }
        })
        .catch(err => {
            console.error("Error fetching crop details:", err);
        });
    });

    // Validation for Area Input
    const areaInput = document.getElementById("area");
    areaInput.addEventListener("change", function() {
        let val = parseInt(this.value);
        if (val < 50) {
            alert('Minimum cultivated area size is 50 sqm');
            this.value = 50;
        } else if (val > 5000) {
            alert('Maximum cultivated area size is 5000 sqm');
            this.value = 5000;
        }
    });

    function resetFields() {
        document.getElementById("avgyeild").value = "2.5";
        document.getElementById("plantCount").value = "";
        document.getElementById("area").value = "50";
        document.getElementById("farmresourceid").value = "";
    }
});
</script>