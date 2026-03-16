<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">
                        <i class="bi bi-plus-circle-fill me-2"></i> Register New Plantation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 pb-4">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="farm_size_sqm" value="<?php echo $farm_lot; ?>">

                    <div class="form-group-title">1. Crop Selection</div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Product / Crop Name</label>
                            <?php if ($crop_num > 0): ?>
                                <select class="form-select shadow-sm" name="product_name" id="productSelect" required>
                                    <option value="" selected disabled>-- Select from your resources --</option>
                                    <?php 
                                    $product_stmt->execute(); // Ensure stmt is fresh
                                    while ($row = $product_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= htmlspecialchars($row['crop_name']) ?>"
                                                data-farm-resource-id="<?= $row['farm_resource_id'] ?>">
                                            <?= htmlspecialchars($row['crop_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                    <option value="other">Other / Manual Entry</option>
                                </select>
                            <?php else: ?>
                                <input type="text" name="product_name" class="form-control" placeholder="Enter crop name" required>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group-title">2. Planting Scale</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">No. of Plants</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-hash"></i></span>
                                <input type="number" name="plant_count" class="form-control" required placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Est. KG per Plant</label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="kilo_per_plant" class="form-control" required placeholder="0.0">
                                <span class="input-group-text bg-light text-muted">KG</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Lot Size Used</label>
                            <div class="input-group">
                                <input type="number" name="lot_size" class="form-control" required placeholder="50" min="50" max="5000">
                                <span class="input-group-text bg-light text-muted">SQM</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-title">3. Documentation & Expenses</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Link to Farm Expense</label>
                            <select id="overall_expense" name="total_plant_expense" class="form-select shadow-sm" required>
                                <option value="" selected disabled>-- Choose expense record --</option>
                                <?php
                                $farm_expense = new FarmResource($db);
                                $farm_expense->user_id = $_SESSION['user_id'];
                                $stmt = $farm_expense->getRecordExpense();

                                if ($stmt && $stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['grand_total']}' data-expense-id='{$row['farm_resource_id']}'>
                                                {$row['record_name']} (₱" . number_format($row['grand_total']) . ")
                                              </option>";
                                    }
                                } else {
                                    echo '<option disabled>No expenses found</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Reference Image</label>
                            <input type="file" name="product_image" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Plantation Notes / Description</label>
                            <textarea name="product_description" rows="2" class="form-control" placeholder="Optional notes about soil, weather, or variety..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-bold text-muted" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-save-fill me-2"></i> Save Plantation Detail
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>