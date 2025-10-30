<!-- Modal -->
<div class="modal fade" id="edit-harvest-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              <input type="hidden" name="product_id" value="<?php echo $id; ?>">
              <input type="hidden" name="action" value="update">
              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Product</Label>
                  <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>" required placeholder="Product Name">
                </div>

                <div class="col-md-6">
                  <Label>Category</Label>
                  <input type="text" name="category" value="<?php echo $category; ?>" class="form-control" required placeholder="Unit">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Price</Label>
                  <input type="text" name="price_per_unit" readonly value="<?php echo $price_per_unit; ?>" class="form-control" required placeholder="Lot Size">
                </div>
                <div class="col-md-6">
                  <Label>Unit</Label>
                  <input type="text" name="unit" readonly value="<?php echo $unit; ?>" class="form-control" required placeholder="Lot Size">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Description Price</Label>
                  <textarea name="product_description" class="form-control" required><?php echo $product_description; ?></textarea>
                </div>
                <div class="col-md-6">
                    <Label>Lot Size</Label>
                    <input type="text" name="lot_size"  value="<?php echo $lot_size; ?>" class="form-control" readonly required placeholder="Lot Size">
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
