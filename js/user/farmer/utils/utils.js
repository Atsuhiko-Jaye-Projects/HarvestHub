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
        console.log(response);
        let rows = '';
        let edit_modal = '';
        let postProduct_modal = '';
        let statusClass = '';
        let totalrows = response.records.length;
        let postedPlantCount = 0;


        if (!response.records || response.records.length === 0) {
          $('#harvest_product').html("<tr><td colspan='9' class='text-center'>No products found.</td></tr>");
          $('#harvest_product_pagination').html('');
          return;
        }


        response.records.forEach(row => {
          
        const deleteBtn = row.is_posted === 'er'
        ? ''
        : `
          <form method="POST" action="" class="d-inline delete-form">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="${row.id}">
            <button type="button" class="btn btn-danger btn-delete">
              <i class="bi bi-trash"></i>
            </button>
          </form>
        `;

        const postBtn = row.is_posted === 'Posted'
        ? ''
        :`
          <button class='btn btn-success me-2'
          data-bs-toggle='modal'
          data-bs-target='#post-harvest-modal-${row.id}'>
          <i class='bi bi-box-arrow-up'></i>
          </button>
        `  



          if (row.is_posted === "Pending") {
            statusClass = "bg-warning text-dark";
            } else if (row.is_posted === "Posted") {
                statusClass = "bg-success text-white";
            }

          rows += `
          <tr class='text-center'>
          <td>${row.product_name}</td>
          <td>${row.category}</td>
          <td class='price'>₱${row.price_per_unit}.00</td>
          <td>${row.unit}</td>
          <td>${Number(row.total_stocks).toLocaleString()} KG</td>
          <td>${row.plant_count}</td>
          <td>${row.lot_size}</td>
          <td>
            <span class='badge ${statusClass} px-3 py-2 text-uppercase'>
              ${row.is_posted}
            </span>
          </td>
          <td>
            <button class='btn btn-primary me-2'
                    data-bs-toggle='modal'
                    data-bs-target='#edit-harvest-modal-${row.id}'>
              <i class='bi bi-pencil-square'></i>
            </button>


            ${postBtn}
            ${deleteBtn}
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
        console.log(error);
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
// document.addEventListener('DOMContentLoaded', function() {
//   // Helper function: calculate days since planted
//   function getDaysSincePlanted(datePlanted) {
//     if (!datePlanted) return '-';
//     const planted = new Date(datePlanted);
//     const today = new Date();
//     const diffTime = today - planted;
//     const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
//     diffDays === 1 ? " Day" : " Days"
//     return diffDays + (diffDays === 1 ? " Day" : " Days");
//   }

//   // Helper function: determine crop status based on days
//   function getCropStatus(datePlanted) {
//     const days = getDaysSincePlanted(datePlanted);
//     if (days === 0) return 'Planted';
//     if (days <= 4) return 'Germinating';
//     if (days <= 10) return 'Cultivating';
//     return 'Growing';
//   }

//   window.loadCropTable = function(page = 1) {
//     $.ajax({
//       url: '../../../js/user/farmer/api/fetch_farm_crop.php',
//       type: 'GET',
//       data: { page: page },
//       dataType: 'json',
//       success: function(response) {
//         let rows = '';
//         let update_crop_modal = '';
//         let post_crop_modal = '';
//         let total_stocks = 0;
//         let planted_crops = 0;
//         let total_harvest = 0;
//         let cultivatedArea = 0;
//         let avgYield = 0;
//         let plantCount = 0;


//         response.records.forEach(row => {
          
//         response.records.forEach(row=>{
//         let total_stocks = 0;
//         });

//           total_stocks += Number(row.stocks);
//           planted_crops += Number(row.plant_count);
//           total_harvest = parseFloat(row.stocks);
//           cultivatedArea = parseFloat(row.cultivated_area);
//           avgYield = cultivatedArea > 0 ? (total_harvest / cultivatedArea) : 0;
//         });
//         document.getElementById('recordCount').textContent = response.total_rows;
//         document.getElementById('recordCounts').textContent = response.total_rows;
//         document.getElementById('crop_stocks').textContent = total_stocks.toLocaleString();
//         document.getElementById('planted_crop_count').textContent = planted_crops.toLocaleString();
//         document.getElementById('avg_Yields').textContent = avgYield.toFixed(2)  + " kg";
        
//       },
//       error: function() {
//         alert('Failed to load crop data');
//       }
//     });
//   };

//   // Load crop data when page opens
//   loadCropTable();
// });


// // // check the estimation of plant Date
// document.addEventListener('DOMContentLoaded', function(){
//   document.getElementById('cropForm').addEventListener('submit', function(e) {
//     const datePlanted = new Date(document.getElementById('date_planted').value);
//     const harvestDate = new Date(document.getElementById('estimated_harvest_date').value);

//     if (harvestDate <= datePlanted) {
//       e.preventDefault();
//       bootbox.alert({
//         title: "Invalid Dates ❌",
//         message: "Estimated harvest date must be after the date planted.",
//         backdrop: false
//       });
//       return;
//     }

//     const diffTime = harvestDate - datePlanted;
//     const diffDays = diffTime / (1000 * 60 * 60 * 24);

//     if (diffDays < 45) {
//       e.preventDefault();
//       bootbox.alert({
//         title: "Too Soon 🌱",
//         message: "The estimated harvest date must be at least 45 days after planting.",
//       });
//       return;
//     }

//     if (diffDays > 365) {
//       e.preventDefault();
//       bootbox.alert({
//         title: "Too Far ⚠️",
//         message: "The harvest date seems too far. Please check the date.",
//       });
//       return;
//     }
//   });
// });

function loadMostPlanted() {
  $.ajax({
    url: "../../../js/user/farmer/api/fetch_most_planted.php",
    type: "GET",
    dataType: "json",
    success: function(response) {
      if (!response.records || response.records.length === 0) {
        $("#mostPlantedTable").html(`
          <tr><td colspan="3" class="text-center">No data found</td></tr>
        `);
        return;
      }

      let rows = "";
      let rank = 1;

      response.records.forEach(row => {
        rows += `
          <tr>
            <td>${rank}</td>

            <td style="text-transform: capitalize;">${row.crop_name}</td>
            <td>${Number(row.total_planted).toLocaleString()}</td>
          </tr>
        `;
        rank++;
      });

      $("#mostPlantedTable").html(rows);
    }
  });
}

document.addEventListener("DOMContentLoaded", loadMostPlanted);


function loadTopCropsInArea() {
  $.ajax({
    url: "../../../js/user/farmer/api/fetch_top_crops_in_brgy.php",
    type: "GET",
    dataType: "json",
    success: function(response) {
      if (!response.records || response.records.length === 0) {
        $("#TopCropsInArea").html(`
          <tr><td colspan="3" class="text-center">No data found</td></tr>
        `);
        return;
      }

      let rows = "";
      let rank = 1;

      response.records.forEach(row => {
        rows += `
          <tr>
            <td>${rank}</td>

            <td style="text-transform: capitalize;">${row.crop_name}</td>
            <td>${Number(row.total_planted).toLocaleString()}</td>
          </tr>
        `;
        rank++;
      });

      $("#TopCropsInArea").html(rows);
    }
  });
}

document.addEventListener("DOMContentLoaded", loadTopCropsInArea);




