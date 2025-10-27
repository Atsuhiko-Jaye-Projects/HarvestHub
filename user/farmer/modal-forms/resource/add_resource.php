<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Resource</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              
              <div class="row mb-3">
                <div class="col-md-6">    
                  <select name="type" id="" class="form-select">
                    <option value="machine">Machine</option>
                    <option value="machine">Fertilizer</option>
                    <option value="machine">Seeds</option>
                    <option value="machine">Others</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="item_name" class="form-control" required placeholder="Item Name">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <input type="number" 
                  name="cost" 
                  class="form-control" 
                  required 
                  placeholder="Cost" 
                  min="0" 
                  max="5000"
                  oninput="if(this.value > 5000) this.value = 5000;">
                </div>
                <div class="col-md-6">
                  <input 
                    type="date" 
                    name="date" 
                    class="form-control" 
                    required 
                    value="<?php echo date('Y-m-d'); ?>" 
                    placeholder="Date">

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>
      <!-- Form ends here -->

    </div>
  </div>
</div>
