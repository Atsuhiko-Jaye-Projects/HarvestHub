<!-- edit resource Modal -->
<div class="modal fade" id="edit-farm-resource-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
              <input type="hidden" name="item_id" value="<?php echo $id; ?>">
              <input type="hidden" name="action" value="update">
              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Type</Label>
                  <input type="text" name="type" class="form-control" value="<?php echo $type; ?>" required placeholder="Type">
                </div>

                <div class="col-md-6">
                  <Label>Item</Label>
                  <input type="text" name="item_name" value="<?php echo $item_name; ?>" class="form-control" required placeholder="Item">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Cost</Label>
                  <input type="text" name="cost" value="<?php echo $cost; ?>" class="form-control" required placeholder="Cost">
                </div>

                <div class="col-md-6">
                  <Label>Date</Label>
                  <input type="date" name="date" value="<?php echo $date; ?>" class="form-control" required placeholder="Date">
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

<!-- view resource Modal -->
<div class="modal fade" id="view-farm-resource-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
                  <Label>Type</Label>
                  <input type="text" name="type" class="form-control" value="<?php echo $type; ?>" required placeholder="Type">
                </div>

                <div class="col-md-6">
                  <Label>Item</Label>
                  <input type="text" name="item_name" value="<?php echo $item_name; ?>" class="form-control" required placeholder="Item">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <Label>Cost</Label>
                  <input type="text" name="price_per_unit" value="<?php echo $cost; ?>" class="form-control" required placeholder="Cost">
                </div>

                <div class="col-md-6">
                  <Label>Date</Label>
                  <input type="text" name="price_per_unit" value="<?php echo $date; ?>" class="form-control" required placeholder="Cost">
                  
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
