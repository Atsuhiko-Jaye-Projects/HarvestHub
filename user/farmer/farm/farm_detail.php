<div class="d-flex justify-content-center align-items-center min-vh-100 px-3">
  <div class="col-12 col-sm-10 col-md-8 col-lg-6">
    <div class="card mx-auto">
      <div class="card-header bg-dark text-white">
        <i class="bi bi-clipboard-check me-2"></i> Submit Your Farm Details
      </div>
      <div class="card-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <input type="hidden" name="province_name" id="province_name">
          <input type="hidden" name="municipality_name" id="municipality_name">
          <input type="hidden" name="barangay_name" id="barangay_name">

          <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3 mb-md-0">
              <label class="form-label">Last Name</label>
              <input type="text" name="lastname" class="form-control" required placeholder="Last Name" value="<?php echo $_SESSION['lastname']; ?>" disabled>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">First Name</label>
              <input type="text" name="firstname" class="form-control" required value="<?php echo $_SESSION['firstname']; ?>" disabled>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
              <label class="form-label">Province</label>
              <select name="province" id="province" class='form-select' required>
                <option value="" hidden>Select ...</option>
              </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
              <label class="form-label">Municipality</label>
              <select name="municipality" id="municipality" class='form-select' required>
                <option value="" hidden>Select...</option>
              </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-3 mb-md-0">
              <label class="form-label">Barangay</label>
              <select name="barangay" id="barangay" class='form-select' required>
                <option value="" hidden>Select...</option>
              </select>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <label class="form-label">Street</label>
              <input type="text" name="purok" class="form-control">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Type of farm ownership</label>
            <select name="farm_ownership" class="form-select">
              <option value="" hidden>Please select..</option>
              <option value="rented">Rented</option>
              <option value="owned">Owned</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Farmland Size (SQM)</label>
            <input type="number"
              name="lot_size"
              class="form-control"
              onchange="
                if (this.value < 50) { alert('Minimum farm area size is 50 sqm'); this.value = 50; }
                if (this.value > 50000) { alert('Maximum farm area size is 50,000 sqm'); this.value = 50000; }" value="50">
          </div>

          <div class="mb-3 text-center">
            <input type="submit" class="btn btn-primary w-50">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


  <script>
document.addEventListener("DOMContentLoaded", function () {
  const provinceSelect = document.getElementById("province");
  const municipalitySelect = document.getElementById("municipality");
  const barangaySelect = document.getElementById("barangay");

  const provinceInput = document.getElementById("province_name");
  const municipalityInput = document.getElementById("municipality_name");
  const barangayInput = document.getElementById("barangay_name");

  // Load Provinces
  fetch("https://psgc.gitlab.io/api/provinces/")
    .then(res => res.json())
    .then(data => {
      provinceSelect.innerHTML = "<option disabled selected>Select Province</option>";

      data.forEach(province => {
        const option = document.createElement("option");
        option.value = province.code;         // Code for logic
        option.textContent = province.name;  // Display
        option.dataset.name = province.name; // Store name
        provinceSelect.appendChild(option);
      });
    });

  // When province changes
  provinceSelect.addEventListener("change", function () {
    const selectedOption = this.selectedOptions[0];
    provinceInput.value = selectedOption.dataset.name; // Pass name to input

    const provinceCode = this.value;
    municipalitySelect.innerHTML = "<option selected disabled>Loading...</option>";
    barangaySelect.innerHTML = "<option selected disabled>Select Municipality First</option>";

    fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`)
      .then(res => res.json())
      .then(data => {
        municipalitySelect.innerHTML = "<option selected disabled>Select Municipality</option>";
        data.forEach(muni => {
          const option = document.createElement("option");
          option.value = muni.code;
          option.textContent = muni.name;
          option.dataset.name = muni.name; // Store name
          municipalitySelect.appendChild(option);
        });
      });
  });

  // When municipality changes
  municipalitySelect.addEventListener("change", function () {
    const selectedOption = this.selectedOptions[0];
    municipalityInput.value = selectedOption.dataset.name; // Pass name to input

    const muniCode = this.value;
    barangaySelect.innerHTML = "<option selected disabled>Loading...</option>";

    fetch(`https://psgc.gitlab.io/api/cities-municipalities/${muniCode}/barangays/`)
      .then(res => res.json())
      .then(data => {
        barangaySelect.innerHTML = "<option selected disabled>Select Barangay</option>";
        data.forEach(barangay => {
          const option = document.createElement("option");
          option.value = barangay.code;
          option.textContent = barangay.name;
          option.dataset.name = barangay.name; // Store name
          barangaySelect.appendChild(option);
        });
      });
  });

  // When barangay changes
  barangaySelect.addEventListener("change", function () {
    const selectedOption = this.selectedOptions[0];
    barangayInput.value = selectedOption.dataset.name; // Pass name to input
  });
});

  </script>