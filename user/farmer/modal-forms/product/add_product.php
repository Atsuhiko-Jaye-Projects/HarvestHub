<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              
              <div class="row mb-3">
                <div class="col-md-6">    
                  
                  <select name="category" class='form-select' id="" required>
                    <option value="">Select Category...</option>
                    <option value="Vegetable">Vegetable</option>
                    <option value="Fruit">Fruit</option>
                  </select>
                  <input type="hidden" name="action" value="create">
                </div>
                <div class="col-md-6">
                  <input type="text" name="product_name" class="form-control" required placeholder="Product Name">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <input type="text" name="unit" class="form-control" required placeholder="Unit" value='KG' readonly>
                </div>
                <div class="col-md-6">
                  <input type="number" 
                  name="lot_size" 
                  class="form-control" 
                  required 
                  placeholder="Lot Size" 
                  min="0" 
                  max="5000"
                  oninput="if(this.value > 5000) this.value = 5000;">
                </div>
              </div>

              <div class="mb-3">
                <label for="">Description</label>
                <textarea name="product_description" class="form-control"></textarea>
              </div>


              <div class="mb-3">
                <label for="">Owned Farm Land (SQM)</label>
                <input type="text" name="product_name" class="form-control" value="<?php echo $farm_lot;?>" readonly>
              </div>

              <div class="mb-3">
                <label for="">Images</label>
                <input type="file" name="product_image" class="form-control" required>
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
