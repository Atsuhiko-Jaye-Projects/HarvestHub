<div class="modal fade" id="edit-farm-resource-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="item_id" value="<?php echo $id;?>">
        <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                <i class="bi bi-pencil-square me-2"></i> Update Farm Input
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3 row">
            <div class="col-md-6">
            <label for="type" class="form-label">Resource Type</label>
            <select name="type" id="type" class="form-select">
                <option value="machine" <?php echo ($type == 'machine') ? 'selected' : ''; ?>>Machine</option>
                <option value="fertilizer" <?php echo ($type == 'fertilizer') ? 'selected' : ''; ?>>Fertilizer</option>
                <option value="seeds" <?php echo ($type == 'seeds') ? 'selected' : ''; ?>>Seeds</option>
                
            </select>
            </div>
            <div class="col-md-6">
              <label for="item_name" class="form-label">Item</label>
              <input type="text" name="item_name" id="item_name" class="form-control" required value="<?php echo $item_name; ?>">
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-6">
              <label for="cost1" class="form-label">Resource Cost</label>
              <input type="number" name="cost" class="form-control" required min="0" max="200000" onchange="if(this.value > 200000) this.value = 200000;" value="<?php echo $cost; ?>">
            </div>
            <div class="col-md-6">
              <label for="cost2" class="form-label">Date Acquired</label>
              <input
                type="date"
                name="date"
                class="form-control"
                required
                value="<?php echo $date; ?>"
                max="<?php echo date('Y-m-d'); ?>"
                placeholder="Date">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-arrow-repeat me-1"></i> Update Resource
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Close
           </button>
        </div>
      </form>
    </div>
  </div>
</div>
