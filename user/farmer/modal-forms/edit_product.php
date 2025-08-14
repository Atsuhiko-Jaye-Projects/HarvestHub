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
              <input type="hidden" name="product_id" value="<?php echo $id; ?>">
              <input type="hidden" name="action" value="update">
              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Product Name</Label>
                  <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>" required placeholder="Product Name">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Date Planted</Label>
                  <input type="date" name="date_planted" value="<?php echo $date_planted; ?>" class="form-control" required placeholder="Unit">
                </div>
                <div class="col-md-6">
                  <Label>Estimated Harvest Date</Label>
                  <input type="date" name="estimated_harvest_date" value="<?php echo $estimated_harvest_date; ?>" class="form-control" required placeholder="Lot Size">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Yeild</Label>
                  <input type="number" name="yield" value="<?php echo $yield; ?>" class="form-control" required placeholder="Lot Size">
                </div>
                <div class="col-md-6">
                  <Label>Suggested Price</Label>
                  <input type="number" name="suggested_price" value="<?php echo $suggested_price; ?>" class="form-control" required placeholder="Lot Size">
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
