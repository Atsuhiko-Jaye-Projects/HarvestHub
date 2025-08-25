<!-- Modal -->
<div class="modal fade" id="post-harvest-modal-<?php echo $id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <input type="hidden" name="action" value="product_post">

              <div class="row mb-3">
                <div class="col-md-6">
                  <label>Product</label>
                  <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>" readonly>
                </div>
                <div class="col-md-6">
                  <label>Category</label>
                  <input type="text" name="category" value="<?php echo $category; ?>" class="form-control" >
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label>Price</label>
                  <input type="text" name="price_per_unit" value="<?php echo $price_per_unit; ?>" class="form-control" >
                </div>
                <div class="col-md-6">
                  <label>Unit</label>
                  <input type="text" name="unit" value="<?php echo $unit; ?>" class="form-control" >
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label>Description Price</label>
                  <textarea name="product_description" class="form-control" required ><?php echo $product_description; ?></textarea>
                </div>
                <div class="col-md-6">
                  <label>Lot Size</label>
                  <input type="text" name="lot_size" value="<?php echo $lot_size; ?>" class="form-control" >
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label>Image</label>
                  <img  class="img-fluid border rounded" src="<?php echo $base_url; ?>uploads/<?php echo $_SESSION['user_id']; ?>/products/<?php echo $product_image ?: 'default.png'; ?>" alt="Product Image">
                  <input name = "product_image" type="text" value = "<?php echo $product_image ?>" hidden>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Post</button>
        </div>

      </form>
      <!-- Form ends here -->

    </div>
  </div>
</div>
