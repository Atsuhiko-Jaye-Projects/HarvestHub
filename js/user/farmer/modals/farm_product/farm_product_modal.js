function editHarvestProduct(row){
  return `
  <div class="modal fade" id="edit-harvest-modal-${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Form starts here and wraps the modal content -->
        <form action="${UpdatePostURL}" method="POST" enctype="multipart/form-data">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="card-body">
              <div class="container">
                <input type="hidden" name="product_id" value="${row.id}">
                <input type="hidden" name="action" value="update">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <Label>Product</Label>
                    <input type="text" name="product_name" class="form-control border border-success" value="${row.product_name}" required placeholder="Product Name">
                  </div>

                  <div class="col-md-6">
                    <label>Category</label>
                    <select name="category" class="form-select border border-success" required>
                      <option value="">Select Category...</option>
                      <option value="Vegetable" ${row.category === 'Vegetable' ? 'selected' : ''}>Vegetable</option>
                      <option value="Fruit" ${row.category === 'Fruit' ? 'selected' : ''}>Fruit</option>
                      <option value="Rootcrop" ${row.category === 'Rootcrop' ? 'selected' : ''}>Rootcrop</option>
                      <option value="Legume" ${row.category === 'Legume' ? 'selected' : ''}>Legume</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <Label>Price/KG</Label>
                    <input type="hidden" name="price_per_unit" readonly value="${row.price_per_unit}">
                    <input type="text" name="" readonly value="${Number(row.price_per_unit).toLocaleString('en-PH', { style: 'currency', currency: 'PHP' })}
" class="form-control border border-warning" required placeholder="Lot Size">
                  </div>
                  <div class="col-md-6">
                    <Label>Unit</Label>
                    <input type="text" name="unit" readonly value="${row.unit}" class="form-control border border-warning" required placeholder="Lot Size">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <Label>Description Price</Label>
                    <textarea name="product_description" class="form-control border border-success" required>${row.product_description}</textarea>
                  </div>

                  <div class="col-md-6">
                      <Label>Crop Area (sqm)</Label>
                      <input type="number" name="lot_size" value="${row.lot_size}" class="form-control border border-warning" required placeholder="Lot Size">

                      <input type="text" hidden name="is_posted" readonly value="${row.is_posted}" class="form-control border border-warning" required placeholder="Lot Size">
                    </div>
                </div>

                <input type="hidden"  name="plant_count" value="${row.plant_count}">
                <input type="hidden"  name="kilo_per_plant" value="${row.kilo_per_plant}">
                <input type="hidden"  name="total_plant_expense" value="${row.expense}">

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

function postHarvestProduct(row) {
  return `
  <!-- Modal -->
  <div class="modal fade" id="post-harvest-modal-${row.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Form starts here and wraps the modal content -->
        <form action="${ProductPostingURL}" method="POST" enctype="multipart/form-data">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="card-body">
              <div class="container">

                <input type="hidden" name="product_id" value="${row.id}">
                <input type="hidden" name="action" value="product_post">

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label>Product</label>
                    <input type="text" name="product_name" class="form-control" value="${row.product_name}" readonly>
                  </div>
                  <div class="col-md-6">
                    <label>Category</label>
                    <input type="text" name="category" value="${row.category}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" id="cost-${row.id}" value="${row.price_per_unit}" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>EST Stocks (KG)</label>
                    <input type="text" name="total_stocks" value="${row.total_stocks}" class="form-control" readonly>
                  </div>
                  <div class="col-md-4">
                    <label>Unit</label>
                    <input type="text" name="unit" value="${row.unit}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label>Description Price</label>
                    <textarea name="product_description" class="form-control" required readonly>${row.product_description}</textarea>
                  </div>
                  <div class="col-md-6">
                    <label>Lot Size</label>
                    <input type="text" name="lot_size" value="${row.lot_size}" class="form-control" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <label>Image</label>
                  <div class="col-md-6">
                    <img class="img-fluid border rounded" src="${row.product_image_path}" alt="Product Image" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    <input name="product_image" type="text" value="${row.product_image}" hidden>
                    <input type="text" name="is_posted" value="${row.is_posted}" hidden>
                  </div>
                </div>
                  <hr>
                <!-- BREAK EVEN SECTION -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label>Cost per KG (Base Cost)</label>
                    <input type="number" step="0.01" name="cost_per_kg" class="form-control" id="cost-${row.id}" value="${row.price_per_unit}" readonly>

                  </div>

                  <div class="col-md-6">
                    <label>Your Selling Price per KG</label>
                    <input type="number" step="0.01" name="selling_price" class="form-control" id="selling-price-${row.id}" placeholder="Enter selling price" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-12">
                    <label>Break-even</label>
                    <div id="breakeven-result-${row.id}" class="alert alert-info">Enter values above…</div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id='postButton'>Post</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- INLINE SCRIPT FOR THIS SPECIFIC MODAL -->
  <script>
    document.addEventListener("input", function(e) {
      if (e.target.id === "cost-${row.id}" || e.target.id === "selling-price-${row.id}") {

        let cost = parseFloat(document.getElementById("cost-${row.id}").value) || 0;
        let price = parseFloat(document.getElementById("selling-price-${row.id}").value) || 0;
        let resultBox = document.getElementById("breakeven-result-${row.id}");
        const postButton = document.getElementById('postButton');

        if (cost === 0 || price === 0) {
          resultBox.className = "alert alert-info";
          resultBox.innerHTML = "Enter values above…";
          return;
        }

        if (price < cost) {
          let loss = (cost - price).toFixed(2);
          var markup = ((price - cost) / cost * 100).toFixed(2);
          resultBox.className = "alert alert-danger";
          resultBox.innerHTML = "⚠️ You are selling at a loss! <br> Loss per KG: ₱" + loss + "<br>Markup: " + markup + "%";
        } else {
          var markup = ((price - cost) / cost * 100).toFixed(2);
          resultBox.className = "alert alert-success";
          resultBox.innerHTML = "✔️ Profit per KG: ₱" + (price - cost).toFixed(2) + "<br>Markup: " + markup + "%";

              if (markup > 25.00) {
                resultBox.innerHTML += "<br>⚠️ Markup is too high: " + markup + "%";
                postButton.disabled = true;
              }else{
                postButton.disabled = false;
              }
        }
      }
    });
  </script>
  `;
}


