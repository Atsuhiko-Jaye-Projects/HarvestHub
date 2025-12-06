<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Farm Input</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3 row">
            <div class="col-md-12">
              <label for="item_name" class="form-label">Expense Record Title:</label>
              <input type="text" name="item_name" id="item_name" class="form-control" required placeholder="">
              <hr>
            </div>
            <div class="col-md-6">
              <label for="type" class="form-label">Resource Type</label>
              <select name="type" id="type" class="form-select">
                <option value="machine">Machine</option>
                <option value="fertilizer">Fertilizer</option>
                <option value="seeds">Seeds</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="item_name" class="form-label">Item</label>
              <input type="text" name="item_name" id="item_name" class="form-control" required placeholder="">
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-6">
              <label for="cost1" class="form-label">Resource Cost</label>
              <input type="number" name="cost" class="form-control" required min="0" max="200000" onchange="if(this.value > 200000) this.value = 200000;">
            </div>
            <div class="col-md-6">
              <label for="cost2" class="form-label">Date Acquired</label>
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
