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
                <div class="col-md-4">
                  <input type="number" name="plant_count" class="form-control" required placeholder="No. of Plants">
                </div>
                <div class="col-md-4">
                  <input type="number" name="kilo_per_plant" class="form-control" required placeholder="KG/Plant">
                </div>
                  <div class="col-md-4">
                    <input 
                      type="number" 
                      name="lot_size" 
                      class="form-control" 
                      required 
                      placeholder="Lot Size"
                      min="50" 
                      max="5000"
                      onchange="
                        if (this.value < 50) { alert('Minimum lot size is 50 sqm'); this.value = 50; }
                        if (this.value > 5000) { alert('Maximum lot size is 5000 sqm'); this.value = 5000; }">
                  </div>
              </div>

              <div class="mb-3">
                <label for="">Description</label>
                <textarea name="product_description" class="form-control"></textarea>
              </div>


              <div class="mb-3">
                <label for="">Owned Farm Land (SQM)</label>
                <input type="text" name="farm_size_sqm" class="form-control" value="<?php echo number_format($farm_lot);?>" readonly>
              </div>

              <div class="mb-3">
                <label for="">Overall Plant Expense</label>
                
                <input type="Number" 
                name="total_plant_expense" 
                class="form-control danger" 
                placeholder= "₱0.00" 
                min="1000" max="200000"
                onchange=
                "if (this.value < 1000) { alert('Minimum expense amount is ₱1,000'); this.value = 1000; }
                if (this.value > 200000) { alert('Maximum expense amount is ₱200,000'); this.value = 200000; }">
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
