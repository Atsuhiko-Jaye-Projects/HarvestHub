<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- Form starts here and wraps the modal content -->
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="card-body">
            <div class="container">
              
              <div class="row mb-3">
                <div class="col-md-6">    
                  <label for="">Product Type</label>
                  <select name="category" class='form-select' id="" required>
                    <option value="">Select Category...</option>
                    <option value="Vegetable">Vegetable</option>
                    <option value="Fruit">Fruit</option>
                  </select>
                  <input type="hidden" name="action" value="create">
                </div>
                <div class="col-md-6">
                  <label for="">Product Name</label>
                  <?php
                    if ($crop_num > 0) {
                      echo "<select class='form-select' name='product_name'>";
                        echo "<option value=''>--Select Crop--</option>";
                        while ($row = $product_stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo "<option value=\"{$row['crop_name']}\" data-farm-resource-id=\"{$row['farm_resource_id']}\">
                            {$row['crop_name']}
                          </option>";
                        }
                        echo "<option value='other' id='other-crop'>Other Crop</option>";
                      echo "</select>";
                    }else{
                      echo "<input type='text' id='crop_field' name='product_name' class='form-control' required>";
                    }
                  ?>
                  
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="">No. of plants</label>
                  <input type="number" name="plant_count" class="form-control" required placeholder="No. of Plants">
                </div>
                <div class="col-md-4">
                  <label for="">KG/Plant (Avg.)</label>
                  <input type="number" step="0.1" name="kilo_per_plant" class="form-control" required placeholder="KG/Plant">
                </div>
                  <div class="col-md-4">
                    <label for="">Lot Size (sqm)</label>
                    <input 
                      type="number" 
                      name="lot_size" 
                      class="form-control" 
                      required 
                      placeholder="Lot Size"
                      min="50" 
                      max="5000"
                      onchange="
                        if (this.value < 50) { alert('Minimum lot size is 50 sqm'); this.value = 50; }
                        if (this.value > 5000) { alert('Maximum lot size is 5000 sqm'); this.value = 5000; }">
                  </div>
              </div>

              <div class="mb-3">
                <label for="">Description</label>
                <textarea name="product_description" class="form-control"></textarea>
              </div>


              <div class="mb-3">
                <!-- <label for="">Owned Farm Land (SQM)</label> -->
                <input type="hidden" name="farm_size_sqm" class="form-control" value="<?php echo number_format($farm_lot);?>" readonly>
              </div>

              <div class="mb-3">
                <label for=""> Expense</label>
                  <select id="overall_expense" name="total_plant_expense" class="form-select">
                    <option value="">-- Select Expense --</option>
                    <?php
                      $farm_expense = new FarmResource($db);
                      $farm_expense->user_id = $_SESSION['user_id'];

                      // Get the records
                      $stmt = $farm_expense->getRecordExpense(); // make sure this returns a PDOStatement or array

                      if ($stmt && $stmt->rowCount() > 0) {
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              // Assuming the table has 'id' and 'expense_name' fields
                             echo "<option value='{$row['grand_total']}' data-expense-farm-resource-id=\"{$row['farm_resource_id']}\" style='color: red; font-weight: bold;'>{$row['record_name']} | ₱" . number_format($row['grand_total']) . "</option>";


                          }
                      } else {
                          echo '<option value="">No expenses found</option>';
                      }
                    ?>
                  </select>
              </div>

              <div class="mb-3">
                <label for="">Images</label>
                <input type="file" name="product_image" class="form-control" required>
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

