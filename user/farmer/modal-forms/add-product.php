<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-6">    
                            <input type="text" name="lastname" class="form-control" required placeholder="Category">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="firstname" class="form-control" required placeholder="Product Name">
                        </div>
                    </div>
                

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" name="purok" class="form-control" required placeholder="Unit">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="baranggay" class="form-control" required placeholder="Lot Size">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" name="baranggay" class="form-control" required placeholder="Total Stock">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="baranggay" class="form-control" required placeholder="Price Per Unit">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="">Description</label>
                        <textarea name="" class="form-control" id="">
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label for="">Images</label>
                        <input type="file" name="baranggay" class="form-control" required placeholder="Price Per Unit">
                    </div>
                </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>