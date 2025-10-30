</div>
</div>
</div>
</div>

<!-- CORE js Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.4/bootbox.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- APIs -->


<!-- JS modules -->
<script src="/HarvestHub/js/user/farmer/modals/farm_product/farm_product_modal.js"></script>
<script src="/Harvesthub/js/user/farmer/utils/utils.js"></script>
<script src="/Harvesthub/js/user/farmer/statistics/graphs.js"></script>
<script src="/HarvestHub/js/user/farmer/weather/weather.js"></script>
<script src="/HarvestHub/js/user/farmer/products/delete_product.js"></script>
<script src="/Harvesthub/js/user/farmer/utils/tooltips.js"></script>

<script>
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
                    <input type="text" name="product_name" class="form-control" value="${row.product_name}" required placeholder="Product Name">
                  </div>

                  <div class="col-md-6">
                    <label>Category</label>
                    <select name="category" class="form-select" required>
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
                    <Label>Price</Label>
                    <input type="text" name="price_per_unit" readonly value="${row.price_per_unit}" class="form-control" required placeholder="Lot Size">
                  </div>
                  <div class="col-md-6">
                    <Label>Unit</Label>
                    <input type="text" name="unit" readonly value="${row.unit}" class="form-control" required placeholder="Lot Size">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <Label>Description Price</Label>
                    <textarea name="product_description" class="form-control" required>${row.product_description}</textarea>
                  </div>

                  <div class="col-md-6">
                      <Label>Lot Size</Label>
                      <input type="text" name="lot_size" readonly value="${row.lot_size}" class="form-control" required placeholder="Lot Size">

                      <input type="text" hidden name="is_posted" readonly value="${row.is_posted}" class="form-control" required placeholder="Lot Size">
                    </div>

                </div>

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
</script>
</body>
</html>
