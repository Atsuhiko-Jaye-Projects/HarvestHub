<!-- Modal -->

<div class="modal fade" id="view-product-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
              
              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Product Name</Label>
                  <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>" disabled>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Date Planted</Label>
                  <input type="date" name="unit" value="<?php echo $date_planted; ?>" class="form-control" required placeholder="Unit" disabled>
                </div>
                <div class="col-md-6">
                  <Label>Estimated Harvest Date</Label>
                  <input type="date" name="" value="<?php echo $estimated_harvest_date; ?>" class="form-control" disabled>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Yeild</Label>
                  <input type="number" name="" value="<?php echo $yield; ?>" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                  <Label>Suggested Price</Label>
                  <input type="text" name="" value="<?php echo "₱{$suggested_price}.00"; ?>" class="form-control" disabled>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

      </form>
      <!-- Form ends here -->

    </div>
  </div>
</div>
