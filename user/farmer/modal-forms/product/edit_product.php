<!-- Modal -->

<div class="modal fade" id="edit-product-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>



        <div class="modal-body">
          <div class="card-body">
            <div class="container">

              <div class="text-center mb-3">
                <img src="<?php echo $image_path; ?>" 
                    class="img-fluid rounded border" 
                    style="max-height: 200px; object-fit: cover;">
              </div>

              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
              <input type="hidden" name="action" value="update">
              
              <div class="row mb-3">

                <div class="col-md-6">
                  <Label>Product Name</Label>
                  <input type="text" 
                  name="product_name" 
                  class="form-control" 
                  value="<?php echo $product_name; ?>" 
                  required placeholder="Product Name" readonly>
                </div>

                <div class="col-md-6">
                  <Label>Price Per KG (₱)</Label>
                  <input type="hidden" name="current_price" value="<?php echo $price_per_unit; ?>">
                  <input type="number" 
                  name="price_per_unit" 
                  step="0.01"
                  min="0"
                  value="<?php echo number_format($price_per_unit,2); ?>" 
                  class="form-control" required 
                  min
                  placeholder="Price/KG">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Add New Stock (KG)</Label>
                      <input type="number" 
                      name="add_stock" 
                      class="form-control" 
                      min="0" 
                      placeholder="Enter additional stock">
                </div>

                <div class="col-md-6">
                  <Label>Available Stocks (KG)</Label>
                  <input type="number" 
                  name="available_stocks" 
                  value="<?php echo $available_stocks; ?>" 
                  class="form-control" readonly>
                </div>

              </div>

              <div class="row mb-3">
                <div class="col-md-6">

                  <Label>Product Category</Label>
                  <select name="product_type" class="form-select" required>
                    <option value="harvest" 
                        <?php if($product_type == 'harvest') echo 'selected'; ?>>
                        Harvest Product
                    </option>

                    <option value="preorder" 
                        <?php if($product_type == 'preorder') echo 'selected'; ?>>
                        Preorder Product
                    </option>
                  </select>
                </div>

                <div class="col-md-6">
                  <Label>Description</Label>
                  <textarea name="description" 
                  class="form-control" 
                  style="height:120px;"
                  required

                  placeholder="Lot Size"><?php echo htmlspecialchars($product_description); ?></textarea>
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
