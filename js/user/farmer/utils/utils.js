function loadTableData(page = 1) {
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
        $('#tableData').html("<tr><td colspan='7' class='text-center'>No products found.</td></tr>");
        $('#pagination').html('');
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

      $('#tableData').html(rows);
      $('#modalContainer').html(edit_modal + postProduct_modal);
      renderPagination(response.current_page, response.total_pages);
    },
    error: function() {
      alert('Failed to load table data');
    }
  });
}

function renderPagination(current, total){
  let paginationHTML = '';

  if (total > 1) {
    paginationHTML +=`
      <nav>
        <ul class = "pagination justify-content-center">
          <li class="page-item ${current === 1} ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadTableData(${current - 1})">Prev</a>
          </li>
    `;
    for (let i = 1; i <= total; i++){
      paginationHTML += `
            <li class="page-item ${i===current ? 'active' : ''}"
              <a class="page-link" href="#" onclick="loadTableData(${i})"${i}</a>
            </li>
            `;
        }
        paginationHTML +=`
        <li class="page-item ${current === total ? 'disabled' : ''}">
          <a class="page-link" href="#" onclick="loadTableData(${current + 1})">Next</a>
        </li>
      </ul>
    </nav>
    `;
  }
  $('#pagination').html(paginationHTML);
}

// Load when page opens
$(document).ready(function() {
  loadTableData();
});
