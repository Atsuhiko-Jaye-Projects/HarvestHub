<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        
        <div class="modal-header d-block">
          <h5 class="modal-title" id="exampleModalLabel">
            <i class="bi bi-plus-square me-2"></i> <!-- add icon -->
            New Farm Input
          </h5>
          <small class="text-muted">
            <i class="bi bi-info-circle me-1"></i> <!-- optional info icon -->
            Enter all information needed to record this expense.
          </small>
        </div>



        <div class="modal-body">
          <div class="mb-3 row">
            <div class="col-md-12">
              <label class="form-label">Expense Record Title</label>
              <input type="text" name="record_name" id="item_name" class="form-control" required>
              <hr>
              
            </div>
            <div class="col-md-6">
              <label class="form-label">Land Prep. Expense</label>
              <input type="number"  step="0.1"name="land_prep_expense_cost" id="item_name" class="form-control" value="0">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nursery / Seedling Prep.</label>
              <input type="number" step="0.1" name="nursery_seedling_prep_cost" id="item_name" class="form-control" value="0">
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Transplanting</label>
              <input type="number" step="0.1" name="transplanting_cost" class="form-control" value="0">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Crop Care & Maintenance</label>
              <input type="number" step="0.1" name="crop_maintenance_cost" class="form-control" value="0">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Input(Seeds, Fertilizer, etc)</label>
              <input type="number" step="0.1" name="input_seed_fertilizer_cost" class="form-control" value="0">
            </div>

            <div class="col-md-6 mb-3">
              <label  class="form-label">Harvesting</label>
              <input type="number"  step="0.1" name="harvesting_cost" class="form-control" value="0">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Post-Harvest / Transport</label>
              <input type="number" step="0.1" name="post_harvest_transport_cost" class="form-control" value="0">
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
