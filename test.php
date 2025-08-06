<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Philippine Location Selector</title>
</head>
<body>
  <h2>Select Your Location</h2>
  <form>
    <label for="province">Province:</label><br>
    <select id="province" required>
      <option selected disabled>Loading provinces...</option>
    </select><br><br>

    <label for="municipality">City/Municipality:</label><br>
    <select id="municipality" required>
      <option selected disabled>Select Province First</option>
    </select><br><br>

    <label for="barangay">Barangay:</label><br>
    <select id="barangay" required>
      <option selected disabled>Select Municipality First</option>
    </select><br><br>

    <input type="submit" value="Submit">
  </form>
</body>
</html>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const provinceSelect = document.getElementById("province");
      const municipalitySelect = document.getElementById("municipality");
      const barangaySelect = document.getElementById("barangay");

      const MARINDUQUE_CODE = "1740"; // PSGC code for Marinduque

      // Load Provinces
      fetch("https://psgc.gitlab.io/api/provinces/")
        .then(res => res.json())
        .then(data => {
          provinceSelect.innerHTML = "<option disabled>Select Province</option>";

          data.forEach(province => {
            const option = document.createElement("option");
            option.value = province.code;
            option.textContent = province.name;
            provinceSelect.appendChild(option);
          });

          // Preselect Marinduque
          provinceSelect.value = MARINDUQUE_CODE;

          // Trigger change to load Marinduque's municipalities
          provinceSelect.dispatchEvent(new Event("change"));
        });

      // Load Cities/Municipalities when province changes
      provinceSelect.addEventListener("change", function () {
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
              municipalitySelect.appendChild(option);
            });
          });
      });

      // Load Barangays when municipality changes
      municipalitySelect.addEventListener("change", function () {
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
              barangaySelect.appendChild(option);
            });
          });
      });
    });
  </script>
