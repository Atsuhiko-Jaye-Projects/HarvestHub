function loadTableData() {
  $.ajax({
    url: '../../../js/user/farmer/api/fetch_farm_product.php', // your PHP file or API endpoint
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      let rows = '';
      let edit_modal = '';
      let postProduct_modal = '';

      response.forEach(row => {
        rows += `
          <tr>
            <td>${row.product_name}</td>
            <td>${row.unit}</td>
            <td>${row.price_per_unit}</td>
             <td>${row.lot_size}</td>
              <td>${row.lot_size}</td>
              <td>${row.is_posted}</td>
              <td>
              <span data-bs-toggle='tooltip' title='Edit'>
                  <button
                    class='btn btn-primary me-2'
                    data-bs-toggle='modal'
                    data-bs-target='#edit-harvest-modal-${row.id}'>
                    <span><i class='bi bi-pencil-square'></i></span></button>
                    </span>

                    <button
                    class='btn btn-success me-2'
                    data-bs-toggle='modal'
                    data-bs-target='#post-harvest-modal-${row.id}'>
                    <span><i class='bi bi-box-arrow-up'></i></span></button>
    								</span>
              </td>
          </tr>
        `;
        edit_modal += editHarvestProduct(row);
        postProduct_modal += postHarvestProduct(row);
      });
      $('#tableData').html(rows);
      $('#modalContainer').html(edit_modal + postProduct_modal);
    },
    error: function() {
      alert('Failed to load table data');
    }
  });
}

// Load when page opens
$(document).ready(function() {
  loadTableData();
});
