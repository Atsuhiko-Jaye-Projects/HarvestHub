// =====================
// PRODUCT TABLE SECTION
// =====================
document.addEventListener('DOMContentLoaded', function() {
  window.loadProductTable = function(page = 1) {
    $.ajax({
      url: '../../../js/user/farmer/api/fetch_farm_product.php',
      type: 'GET',
      data: { page: page },
      dataType: 'json',
      success: function(response) {
        let rows = '';
        let edit_modal = '';
        let postProduct_modal = '';

        if (!response.records || response.records.length === 0) {
          $('#harvest_product').html("<tr><td colspan='7' class='text-center'>No products found.</td></tr>");
          $('#harvest_product_pagination').html('');
          return;
        }

        response.records.forEach(row => {
          rows += `
            <tr>
              <td>${row.product_name}</td>
              <td>${row.unit}</td>
              <td>${row.category}</td>
              <td>${row.price_per_unit}</td>
              <td>${row.lot_size}</td>
              <td>${row.is_posted}</td>
              <td>
                <button class='btn btn-primary me-2' data-bs-toggle='modal' data-bs-target='#edit-harvest-modal-${row.id}'>
                  <i class='bi bi-pencil-square'></i>
                </button>
                <button class='btn btn-success me-2' data-bs-toggle='modal' data-bs-target='#post-harvest-modal-${row.id}'>
                  <i class='bi bi-box-arrow-up'></i>
                </button>
              </td>
            </tr>
          `;
          edit_modal += editHarvestProduct(row);
          postProduct_modal += postHarvestProduct(row);
        });

        $('#harvest_product').html(rows);
        $('#modalContainer').html(edit_modal + postProduct_modal);
        renderProductPagination(response.current_page, response.total_pages);
      },
      error: function() {
        alert('Failed to load product data');
      }
    });
  };

  function renderProductPagination(current, total) {
    let paginationHTML = '';

    if (total > 1) {
      paginationHTML += `
        <nav>
          <ul class="pagination">
            <li class="page-item ${current === 1 ? 'disabled' : ''}">
              <a class="page-link" href="#" onclick="loadProductTable(${current - 1})">Prev</a>
            </li>
      `;

      for (let i = 1; i <= total; i++) {
        paginationHTML += `
          <li class="page-item ${i === current ? 'active' : ''}">
            <a class="page-link" href="#" onclick="loadProductTable(${i})">${i}</a>
          </li>
        `;
      }

      paginationHTML += `
            <li class="page-item ${current === total ? 'disabled' : ''}">
              <a class="page-link" href="#" onclick="loadProductTable(${current + 1})">Next</a>
            </li>
          </ul>
        </nav>
      `;
    }

    $('#harvest_product_pagination').html(paginationHTML);
  }

  // Load product data when page opens
  loadProductTable();
});


// =====================
// CROP TABLE SECTION
// =====================
document.addEventListener('DOMContentLoaded', function() {
  window.loadCropTable = function(page = 1) {
    $.ajax({
      url: '../../../js/user/farmer/api/fetch_farm_crop.php',
      type: 'GET',
      data: { page: page },
      dataType: 'json',
      success: function(response) {
        let rows = '';
        let update_crop_modal = '';

        if (!response.records || response.records.length === 0) {
          $('#crop_table').html("<tr><td colspan='7' class='text-center'>No crops found.</td></tr>");
          $('#crop_pagination').html('');
          return;
        }

        response.records.forEach(row => {
          const planted = new Date(row.date_planted);
          const harvest = new Date(row.estimated_harvest_date);
          let duration = '-';

          if (row.estimated_harvest_date) {
            const diffTime = harvest - planted;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            duration = diffDays + " Days";
          }

          rows += `
            <tr>
              <td>${row.crop_name}</td>
              <td>${row.yield}</td>
              <td>${row.cultivated_area}</td>
              <td>${row.date_planted}</td>
              <td>${row.estimated_harvest_date || '-'}</td>
              <td>${duration}</td>
              <td>
                <button class='btn btn-primary me-2' data-bs-toggle='modal' data-bs-target='#update-crop-modal-${row.id}'>
                  <i class='bi bi-pencil-square'></i>
                </button>
              </td>
            </tr>
          `;
          update_crop_modal += updateFarmCrop(row);
        });

        // Show total records count
        document.getElementById('recordCount').textContent = response.records.length;
        $('#crop_table').html(rows);
        $('#modalContainer').html(update_crop_modal);
        renderCropPagination(response.current_page, response.total_pages);
      },
      error: function() {
        alert('Failed to load crop data');
      }
    });
  };

  function renderCropPagination(current, total) {
    let paginationHTML = '';

    if (total > 1) {
      paginationHTML += `
        <nav>
          <ul class="pagination">
            <li class="page-item ${current === 1 ? 'disabled' : ''}">
              <a class="page-link" href="#" onclick="loadCropTable(${current - 1})">Prev</a>
            </li>
      `;

      for (let i = 1; i <= total; i++) {
        paginationHTML += `
          <li class="page-item ${i === current ? 'active' : ''}">
            <a class="page-link" href="#" onclick="loadCropTable(${i})">${i}</a>
          </li>
        `;
      }

      paginationHTML += `
            <li class="page-item ${current === total ? 'disabled' : ''}">
              <a class="page-link" href="#" onclick="loadCropTable(${current + 1})">Next</a>
            </li>
          </ul>
        </nav>
      `;
    }

    $('#crop_pagination').html(paginationHTML);
  }

  // Load crop data when page opens
  loadCropTable();
});

// // check the estimation of plant Date
document.addEventListener('DOMContentLoaded', function(){
  document.getElementById('cropForm').addEventListener('submit', function(e) {
    const datePlanted = new Date(document.getElementById('date_planted').value);
    const harvestDate = new Date(document.getElementById('estimated_harvest_date').value);

    if (harvestDate <= datePlanted) {
      e.preventDefault();
      bootbox.alert({
        title: "Invalid Dates ❌",
        message: "Estimated harvest date must be after the date planted.",
        backdrop: false
      });
      return;
    }

    const diffTime = harvestDate - datePlanted;
    const diffDays = diffTime / (1000 * 60 * 60 * 24);

    if (diffDays < 45) {
      e.preventDefault();
      bootbox.alert({
        title: "Too Soon 🌱",
        message: "The estimated harvest date must be at least 45 days after planting.",
      });
      return;
    }

    if (diffDays > 365) {
      e.preventDefault();
      bootbox.alert({
        title: "Too Far ⚠️",
        message: "The harvest date seems too far. Please check the date.",
      });
      return;
    }
  });
});
