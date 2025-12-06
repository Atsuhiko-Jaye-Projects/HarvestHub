<div class="modal fade" id="edit-farm-resource-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="record_id" value="<?php echo $id;?>">

        <div class="modal-header d-block">
          <h5 class="modal-title" id="exampleModalLabel">
            <i class="bi bi-pencil-square me-2"></i> <!-- icon added -->
            Update Farm Input
          </h5>
          <small class="text-muted">
            <i class="bi bi-info-circle me-1"></i> <!-- optional info icon -->
            Update the necessary details for this expense.
          </small>
        </div>



        <div class="modal-body">
          <div class="mb-3 row">
            <div class="col-md-12">
              <label class="form-label">Expense Record Title:</label>
              <input type="text" name="record_name" id="item_name" class="form-control" required value="<?php echo $record_name; ?>">
              <hr>
              
            </div>
            <div class="col-md-6">
              <label class="form-label">Land Prep. Expense</label>
              <input type="number"  step="0.1"name="land_prep_expense_cost" id="item_name" class="form-control" value="<?php echo $land_prep_expense_cost; ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nursery / Seedling Prep.</label>
              <input type="number" step="0.1" name="nursery_seedling_prep_cost" id="item_name" class="form-control" value="<?php echo $nursery_seedling_prep_cost; ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Transplanting</label>
              <input type="number" step="0.1" name="transplanting_cost" class="form-control" value="<?php echo $transplanting_cost; ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Crop Care & Maintenance</label>
              <input type="number" step="0.1" name="crop_maintenance_cost" class="form-control" value="<?php echo $crop_maintenance_cost; ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Input(Seeds, Fertilizer, etc)</label>
              <input type="number" step="0.1" name="input_seed_fertilizer_cost" class="form-control" value="<?php echo $input_seed_fertilizer_cost; ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label  class="form-label">Harvesting</label>
              <input type="number"  step="0.1" name="harvesting_cost" class="form-control" value="<?php echo $harvesting_cost; ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Post-Harvest / Transport</label>
              <input type="number" step="0.1" name="post_harvest_transport_cost" class="form-control" value="<?php echo $post_harvest_transport_cost; ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label for="cost2" class="form-label">Date</label>
              <input
                type="date"
                name="date"
                class="form-control"
                required
                value="<?php echo date('Y-m-d'); ?>"
                max="<?php echo date('Y-m-d'); ?>"
                placeholder="Date">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-repeat me-1"></i> Update Record
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Close
           </button>
        </div>
      </form>
    </div>
  </div>
</div>
