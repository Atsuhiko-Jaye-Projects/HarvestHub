function updateFarmCrop(row){
return `
<!-- Modal -->
<div class="modal fade" id="update-crop-modal-${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" id="cropForm">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Crop details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              <input type="hidden" name="action" value="create">
              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Crop Name</label>
                  <input type="text" name="crop_name" class="form-control" required value="${row.crop_name}">
                </div>


                <div class="col-md-6">
                  <label>Date Planted</label>
                  <input type="date" id="date_planted" name="date_planted" class="form-control" required placeholder="" value="${row.date_planted}">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Estimated Harvest Date</label>
                    <input type="date" id="estimated_harvest_date" name="estimated_harvest_date" class="form-control" value="${row.estimated_harvest_date}">
                </div>
                <div class="col-md-6">
                    <label>
                      Yield <span class="badge bg-primary">General Yield 0.8</span>
                    </label>
                    <input type="text" name="yield" class="form-control" value="0.8" readonly>
                </div>
              </div>
                <div class="col-md-6">
                    <label>Cultivated Area</label>
                    <input type="number"
                    name="cultivated_area"
                    class="form-control"
                    onchange="
                      if (this.value < 50) { alert('Minimum cultivated area size is 50 sqm'); this.value = 50; }
                      if (this.value > 5000) { alert('Maximum cultivated area size is 5000 sqm'); this.value = 5000; }" value="${row.cultivated_area}">
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

  `;
}
