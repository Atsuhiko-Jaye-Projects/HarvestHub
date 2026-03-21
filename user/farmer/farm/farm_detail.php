<div class="d-flex justify-content-center align-items-center min-vh-100 px-3 py-5" 
     style="background: radial-gradient(circle at top right, #f8fafc, #f1f5f9); font-family: 'Inter', system-ui, -apple-system, sans-serif;">
    
    <div class="col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7">
        <div class="card shadow-lg border-0" 
             style="border-radius: 32px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.4);">
            
            <div class="card-header bg-dark text-white py-4 px-4" style="border-radius: 32px 32px 0 0; border-bottom: none; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; right: 0; width: 150px; height: 100%; background: linear-gradient(90deg, transparent, rgba(25, 135, 84, 0.2));"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="bg-success rounded-3 p-2 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; transform: rotate(-5deg); box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                        <i class="bi bi-person-badge-fill text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold tracking-tight">Farmer Profile</h5>
                        <p class="text-secondary mb-0 small opacity-75">Complete your agricultural land registration</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="farmForm">
                    
                    <!-- hidden location of user -->

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Last Name</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 fw-semibold shadow-none" 
                                   value="<?php echo $_SESSION['lastname']; ?>" disabled style="border-radius: 12px; font-size: 0.9rem; height: 48px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">First Name</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 fw-semibold shadow-none" 
                                   value="<?php echo $_SESSION['firstname']; ?>" disabled style="border-radius: 12px; font-size: 0.9rem; height: 48px;">
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Province</label>
                            <select name="province" id="province" class='form-select border-0 bg-light py-2 shadow-none' required style="border-radius: 12px; height: 48px;">
                                <option value="" hidden>Select...</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Municipality</label>
                            <select name="municipality" id="municipality" class='form-select border-0 bg-light py-2 shadow-none' required style="border-radius: 12px; height: 48px;">
                                <option value="" hidden>Select...</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Barangay</label>
                            <select name="barangay" id="barangay" class='form-select border-0 bg-light py-2 shadow-none' required style="border-radius: 12px; height: 48px;">
                                <option value="" hidden>Select...</option>
                            </select>
                        </div>
                    </div>




                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Ownership Status</label>
                            <select name="farm_ownership" class="form-select border-0 bg-light py-2 shadow-none" style="border-radius: 12px; height: 48px;" required>
                                <option value="" hidden>Choose type...</option>
                                <option value="owned">Fully Owned</option>
                                <option value="rented">Rented / Leased</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Farm Area Coverage</label>
                            <div class="input-group">
                                <input type="number" name="lot_size" class="form-control border-0 bg-light py-2 shadow-none text-center" 
                                       value="50" min="50" style="border-radius: 12px 0 0 12px; height: 48px;">
                                <span class="input-group-text border-0 bg-success text-white px-4 fw-bold" style="border-radius: 0 12px 12px 0;">m²</span>
                            </div>
                        </div>
                    </div>

                    <input type="text" name="latitude" id="latitude">
                    <input type="text" name="longitude" id="longitude">
                    <input type="hidden" name="province_name" id="province_name">
                    <input type="hidden" name="municipality_name" id="municipality_name">
                    <input type="hidden" name="barangay_name" id="barangay_name">

                    <div class="row g-3">
                        <div class="col-md-3 order-2 order-md-2">
                        </div>
                        <div class="col-md-6 order-1 order-md-3">
                            <button type="button" onclick="getLocation()" class="btn btn-success w-100 py-3 fw-bold shadow-sm" 
                                    style="border-radius: 18px; background: linear-gradient(135deg, #166534, #22c55e); border: none;">
                                <i class="bi bi-check2-circle me-2"></i>Save Farm Details
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
// PSGC API Engine (Handles Province/City/Barangay)
document.addEventListener("DOMContentLoaded", function () {
    const provinceSelect = document.getElementById("province");
    const municipalitySelect = document.getElementById("municipality");
    const barangaySelect = document.getElementById("barangay");
    const pInput = document.getElementById("province_name");
    const mInput = document.getElementById("municipality_name");
    const bInput = document.getElementById("barangay_name");

    const fetchData = (url, targetSelect) => {
        fetch(url).then(res => res.json()).then(data => {
            data.sort((a, b) => a.name.localeCompare(b.name));
            targetSelect.innerHTML = `<option disabled selected>Select...</option>`;
            data.forEach(item => {
                let opt = document.createElement("option");
                opt.value = item.code;
                opt.textContent = item.name;
                opt.dataset.name = item.name;
                targetSelect.appendChild(opt);
            });
        });
    };

    fetchData("https://psgc.gitlab.io/api/provinces/", provinceSelect);

    provinceSelect.onchange = function() {
        pInput.value = this.selectedOptions[0].dataset.name;
        municipalitySelect.innerHTML = "<option disabled selected>Loading...</option>";
        fetchData(`https://psgc.gitlab.io/api/provinces/${this.value}/cities-municipalities/`, municipalitySelect);
    };
    municipalitySelect.onchange = function() {
        mInput.value = this.selectedOptions[0].dataset.name;
        barangaySelect.innerHTML = "<option disabled selected>Loading...</option>";
        fetchData(`https://psgc.gitlab.io/api/cities-municipalities/${this.value}/barangays/`, barangaySelect);
    };
    barangaySelect.onchange = function() {
        bInput.value = this.selectedOptions[0].dataset.name;
    };
});
</script>