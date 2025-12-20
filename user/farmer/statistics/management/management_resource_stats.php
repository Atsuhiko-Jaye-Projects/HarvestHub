<!-- Show the latest expense current month -->
<?php
// get the farm resource statistics
$total = $farm_resource->farmStatsCurrentTotalCost();
?>

<div class="container-xl mt-3">
  <div class="row g-3">

    <!-- Card 1 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card text-white bg-success shadow mb-3 h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 id="location"></h6>
              <h2 id="temperature"></h2>
              <small id="desc"></small>
            </div>
            <div>
              <i class="bi bi-clipboard" style="font-size: 1.5rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2 -->


    <!-- Card 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow mb-3 h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6>Farm Expense (<?php echo date('M d', strtotime($start_date)); ?> – <?php echo date('M d', strtotime($end_date)); ?>)</h6>
              <h2>₱ <?php echo number_format($total); ?></h2>
            </div>
            <div>
              <i class="bi bi-wallet2" style="font-size: 1.5rem;"></i>
            </div>
          </div>
          <small class="text-success">
            +3.16% compared to <?php echo date('M d', strtotime($start_date)); ?> – <?php echo date('M d', strtotime($end_date)); ?>
          </small>
        </div>
      </div>
    </div>

    <!-- Card 4 - Top Crops Table -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card shadow mb-3 h-100">
        <div class="card-header fw-bold text-white" style="background-color: #007bff;">
          Top Crops Planted in Brgy.
        </div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>Rank</th>
                <th>Crop Name</th>
                <th>Total Plant</th>
              </tr>
            </thead>
            <tbody id="TopCropsInArea"></tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>



<div class="container mt-4">

</div>
