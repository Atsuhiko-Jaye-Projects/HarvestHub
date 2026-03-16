<style>
    /* Modal Container */
    #post-crop-modal-<?php echo $row['id'];?> .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    /* Header Gradient */
    #post-crop-modal-<?php echo $row['id'];?> .modal-header {
        background: linear-gradient(135deg, #198754 0%, #28a745 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.2rem 1.5rem;
    }
    #post-crop-modal-<?php echo $row['id'];?> .btn-close { filter: brightness(0) invert(1); }

    /* Financial Sidebar (Right Column) */
    .financial-card {
        background: #f8fafc;
        border-left: 4px solid #198754;
        border-radius: 15px;
        padding: 1.5rem;
        height: 100%;
    }
    
    .financial-card label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 5px;
        display: block;
    }

    /* Stocks Highlight Field */
    .stocks-badge {
        background-color: #f0fdf4 !important;
        border: 2px dashed #10b981 !important;
        font-weight: 800 !important;
        color: #15803d !important;
        text-align: center;
        font-size: 1.1rem;
    }

    .form-label {
        font-weight: 700;
        color: #334155;
        font-size: 0.85rem;
    }

    /* Footer Button */
    .btn-post-final {
        background: #198754;
        border: none;
        padding: 10px 40px;
        border-radius: 50px;
        font-weight: 700;
        color: white;
        transition: 0.3s;
    }
    .btn-post-final:hover {
        background: #157347;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
    }
</style>

<div class="modal fade" id="post-crop-modal-<?php echo $row['id'];?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirmPost(this)">
                
                <div class="modal-header d-block">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="modal-title fw-bold m-0">
                            <i class="bi bi-megaphone-fill me-2"></i> Post to Pre-Order
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <p class="small mb-0 opacity-75">Review and finalize your pricing before publishing to marketplace.</p>
                </div>

                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="post_crop">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" class="fri" value="<?php echo $row['farm_resource_id']; ?>">

                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Crop Name</label>
                                    <input type="text" name="crop_name" class="form-control" required value="<?php echo $row['crop_name']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Estimated Harvest Date</label>
                                    <input type="date" name="estimated_harvest_date" class="form-control" value="<?php echo $row['estimated_harvest_date']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-success">Total Stocks (KG)</label>
                                    <input type="text" name="stocks" value="<?php echo $row['stocks']; ?>" class="form-control stocks-badge" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. of Plants</label>
                                    <input type="number" name="plant_count" class="form-control" value="<?php echo $row['plant_count']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">KG per Plant</label>
                                    <input type="text" name="kilo_per_plant" class="form-control" value="<?php echo $row['yield']; ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Product Showcase Image</label>
                                    <input type="file" name="crop_image" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="financial-card shadow-sm">
                                <div class="mb-4">
                                    <label class="text-danger">Crop Capital / Expense</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-danger">₱</span>
                                        <input type="number" name="crop_expense" class="form-control border-start-0 bg-white fw-bold text-danger fs-5" readonly value="0">
                                    </div>
                                    <small class="text-muted d-block mt-1">Total cost for this plantation.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="text-primary">Selling Price (20% Markup)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white border-0">₱</span>
                                        <input type="number" name="price_per_unit" class="form-control border-primary fw-bold text-primary fs-5 bg-white" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Suggested price per kilogram.</small>
                                </div>

                                <div class="mb-0">
                                    <label class="text-success">Est. Total Product Value</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white border-0">₱</span>
                                        <input type="number" name="product_value" class="form-control border-success fw-bold text-success fs-5 bg-white" readonly>
                                    </div>
                                    <small class="text-muted d-block mt-1">Projected total revenue.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 px-4">
                    <button type="button" class="btn btn-link text-secondary fw-bold text-decoration-none" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-post-final shadow">
                        <i class="bi bi-send-check me-2"></i> Publish Crop
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// I-trigger ang computation kapag binuksan ang modal
document.addEventListener("shown.bs.modal", function (e) {
    const modal = e.target;
    // Check kung ito yung tamang modal ID
    if (!modal.id.includes("post-crop-modal-")) return;

    const friInput = modal.querySelector(".fri");
    const expenseField = modal.querySelector("input[name='crop_expense']");

    if (friInput && expenseField) {
        const resource_id = friInput.value;
        // API Fetch
        fetch("../../../js/user/farmer/api/fetch_crop_expense.php?id=" + resource_id)
            .then(res => res.json())
            .then(data => {
                expenseField.value = data.grand_total ?? 0;
                computeModalLogic(modal); // Compute pagka-load
            })
            .catch(err => console.error("Error fetching capital:", err));
    }

    // Live update kapag nag-input ang user
    const dynamicInputs = modal.querySelectorAll("input[name='kilo_per_plant'], input[name='plant_count']");
    dynamicInputs.forEach(input => {
        input.addEventListener("input", () => computeModalLogic(modal));
    });
});

function computeModalLogic(modal) {
    const kiloPerPlant = modal.querySelector("input[name='kilo_per_plant']");
    const plantCount   = modal.querySelector("input[name='plant_count']");
    const expenseField = modal.querySelector("input[name='crop_expense']");
    const pricePerUnit = modal.querySelector("input[name='price_per_unit']");
    const productValue = modal.querySelector("input[name='product_value']");
    const stocksField  = modal.querySelector("input[name='stocks']");

    const kpp = parseFloat(kiloPerPlant?.value) || 0;
    const pc  = parseFloat(plantCount?.value)   || 0;
    const exp = parseFloat(expenseField?.value) || 0;
    const markup = 0.20; // 20% Markup

    // 1. Calculate Stocks (Total Kilos)
    const totalKilos = kpp * pc;
    if (stocksField) stocksField.value = totalKilos.toFixed(2);

    // 2. Calculate Suggested Selling Price
    const costPerKg = totalKilos > 0 ? exp / totalKilos : 0;
    const finalPrice = costPerKg * (1 + markup);

    // 3. Update UI
    if (pricePerUnit) pricePerUnit.value = finalPrice.toFixed(2);
    if (productValue) productValue.value = (finalPrice * totalKilos).toFixed(2);
}

// SweetAlert Confirmation
function confirmPost(form) {
    event.preventDefault();
    if (typeof Swal === 'undefined') {
        if(confirm("Are you sure you want to publish this crop?")) form.submit();
        return false;
    }

    Swal.fire({
        title: 'Publish Crop?',
        text: "This will be added to the marketplace for buyers to see.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Publish it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
    return false;
}
</script>