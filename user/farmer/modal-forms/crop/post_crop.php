<!-- Modal -->
<div class="modal fade" id="post-crop-modal-<?php echo $id;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" id="cropForm" onsubmit="return confirmPost(this)">

        <div class="modal-header d-block">
          <h5 class="modal-title" id="exampleModalLabel">
            <i class="bi bi-check2-square me-2"></i> <!-- optional icon -->
            Post this crop details to Pre-Order?
          </h5>
          <small class="text-muted">
            Confirm the crop information before sending it to the pre-order list.
          </small>
        </div>


        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              <input type="hidden" name="action" value='post_crop'>
              <input type="hidden" name="id" value='<?php echo $row['id']; ?>'>
              <input type="hidden" class="fri" value='<?php echo $row['farm_resource_id']; ?>'>
              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Crop Name:</label>
                  <input type="text" name="crop_name" class="form-control" required value='<?php echo $row['crop_name']; ?>'>
                </div>


                <div class="col-md-6">
                    <label>Estimated Harvest Date:</label>
                    <input type="date" id="estimated_harvest_date" name="estimated_harvest_date" class="form-control" value='<?php echo $row['estimated_harvest_date']; ?>'>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                    <label>Stocks:</label>
                    <input type="text" name="stocks" value='<?php echo $row['stocks']; ?>' class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label>
                      KG/Plant (Estimated):
                    </label>
                    <input type="text" name="kilo_per_plant" value='<?php echo $row['yield']; ?>' class="form-control" >
                </div>
              </div>
              <div class="row mb-3">
                    <div class="col-md-6">
                        <label>No. of plants (Estimated):</label>
                        <input type="number"  name="plant_count" class="form-control" value='<?php echo $row['plant_count']; ?>'>
                    </div>

                    <div class="col-md-6">
                        <label>Crop Category:</label>
                        <select class='form-select' name='category' required>
                            <option value ='' hidden>Please Select category</option>
                            <option value ='fruit'>Fuit</option>
                            <option value ='vegetable'>Vegetable</option>
                        </select>    
                    </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-12">
                    <label>Crop Image:</label>
                    <input type="file" name="crop_image" class="form-control" required="">
                </div>
              </div>

                <hr>

                <h4>Expenses for this crop:</h4>
                <div class="row mb-3">
                  <div class="col-md-12">
                        <label>Crop expense</label>
                        <input type="number" id="expense" name="crop_expense" class="form-control" 
                        style="border: 2px solid red; outline: none; box-shadow: none;" 
                        value="" required placeholder='₱ 0.00'>
                  </div>
              </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label>Price per Kilo (est)</label>
                        <input type="number"  name="price_per_unit" class="form-control"
                        style="border: 2px solid #0d6efd; outline: none; box-shadow: none;" 
                        value=""readonly placeholder='₱ 0.00'>
                    </div>

                  <div class="col-md-6">
                    <label>Total product value</label>
                        <input type="number"  name="product_value" class="form-control"
                        style="border: 2px solid green; outline: none; box-shadow: none;" 
                        value="" readonly placeholder='₱ 0.00'>
                    </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Post crop</button>
        </div>

      </form>
      <!-- Form ends here -->

    </div>
  </div>
</div>


<script>

document.addEventListener("input", function (e) {
  const modal = e.target.closest(".modal");
  if (!modal) return;

  computeModal(modal);
});

document.addEventListener("shown.bs.modal", function (e) {
    console.log("MODAL OPENED", e.target.id);
    const modal = e.target;
    const friInput = modal.querySelector(".fri");
    const expenseInput = modal.querySelector("input[name='crop_expense']");

    if (!friInput || !expenseInput) return;

    const resource_id = friInput.value;
    if (!resource_id) return;

    fetch("../../../js/user/farmer/api/fetch_crop_expense.php?id=" + resource_id)
        .then(res => res.json())
        .then(data => {
            
            expenseInput.value = data.grand_total ?? 0;
             document.getElementById("expense").value = data.grand_total;
            // trigger recalculation after fetch
            computeModal(modal);

  
        })

        
});



function confirmPost(form) {
  // Prevent default submission
  event.preventDefault();

  Swal.fire({
    title: 'Post this crop?',
    text: "Are you sure you want to post this crop to Pre-Order?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Post it!',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#198754', // green
    cancelButtonColor: '#6c757d'   // gray
  }).then((result) => {
    if (result.isConfirmed) {
      form.submit(); // submit form if user confirms
    }
  });

  return false; // prevent default submission until user confirms
}



function computeModal(modal) {
  if (!modal) return;

  const kiloPerPlant = modal.querySelector("input[name='kilo_per_plant']");
  const plantCount   = modal.querySelector("input[name='plant_count']");
  const expense      = modal.querySelector("input[name='crop_expense']");
  const pricePerUnit = modal.querySelector("input[name='price_per_unit']");
  const productValue = modal.querySelector("input[name='product_value']");
  const stocks       = modal.querySelector("input[name='stocks']");

  const markup = 0.20; // ✅ 20% markup

  const kpp = parseFloat(kiloPerPlant?.value) || 0;
  const pc  = parseFloat(plantCount?.value)   || 0;
  const exp = parseFloat(expense?.value)      || 0;

  // Total kilos
  const totalKilos = kpp * pc;

  if (stocks) stocks.value = totalKilos.toFixed(2);

  // Cost per kg
  const costPerKg = totalKilos > 0 ? exp / totalKilos : 0;

  // ✅ Apply 20% markup
  const sellingPrice = costPerKg * (1 + markup);

  // Update the fields
  if (pricePerUnit) pricePerUnit.value = sellingPrice.toFixed(2);
  if (productValue) productValue.value = (sellingPrice * totalKilos).toFixed(2);
}




</script>