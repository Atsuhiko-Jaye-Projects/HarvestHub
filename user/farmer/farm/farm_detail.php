<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="col-md-6">
    <div class="card text-center w-75 mx-auto">
      <div class="card-header bg-dark text-white">
        <span><i class="bi bi-clipboard-check"></i></span> Submit Your Farm Details
      </div>
      <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="container">
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" name="lastname" class="form-control" required placeholder="Last Name" value="<?php echo $_SESSION['lastname']; ?>" disabled>
              </div>
              <div class="col-md-6">
                <input type="text" name="firstname" class="form-control" required value="<?php echo $_SESSION['firstname']; ?>" disabled>
              </div>
            </div>

            <div class="mb-3">
              <select name="municipality" id="" class='form-select' required>
                <option value="" hidden>Select Municipality...</option>
                <option value="Mogpog">Mogpog</option>
                <option value="Boac">Boac</option>
                <option value="Gasan">Gasan</option>
                <option value="Torrijos">Torrijos</option>
                <option value="Santa Cruz">St.Cruz</option>
              </select>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" name="purok" class="form-control" required placeholder="Purok">
              </div>
              <div class="col-md-6">
                <input type="text" name="baranggay" class="form-control" required placeholder="Barangay">
              </div>
            </div>

            <div class="mb-3">
              <select name="farm_ownership"class="form-control caret">
                <option value="" hidden>Type of farm ownership</option>
                <option value="rented">Rented</option>
                <option value="owned">Owned</option>
              </select>
            </div>
            
            <div class="mb-3">
                <input type="number" 
                  name="lot_size" 
                  class="form-control" 
                  required 
                  placeholder="Farm size (sqm)" 
                  min="0" 
                  max="5000"
                  oninput="if(this.value > 10000) this.value = 10000;">
            </div>


            <div class="mb-3 text-center">
              <input type="submit" class="btn btn-primary w-50">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
