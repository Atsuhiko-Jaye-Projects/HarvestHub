<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Farm Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              <input type="hidden" name="action" value="create">
              <div class="row mb-3">
                <div class="col-md-6">    
                    <label>Product Name</label>
                  <input type="text" name="product_name" class="form-control" required placeholder="">
                </div>

                
                <div class="col-md-6">
                  <label>Date Planted</label>
                  <input type="date" name="date_planted" class="form-control" required placeholder="">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Estimated Harvest Date</label>
                    <input type="date" name="estimated_harvest_date" class="form-control" required placeholder="">
                </div>
                <div class="col-md-6">
                    <label>Yield(kg)</label>
                    <input type="text" name="yield" class="form-control" required placeholder="">
                </div>
              </div>
                <div class="col-md-6">
                    <label>Suggested Price</label>
                    <input type="number" name="suggested_price" class="form-control" required placeholder="">
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
