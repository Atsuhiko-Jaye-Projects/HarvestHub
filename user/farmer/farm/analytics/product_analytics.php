<?php
// display the top 5 crop sold for each category

$order->farmer_id = $_SESSION['user_id'];

$MCSD_stmt = $order->getTopSoldCropDaily();
$MCSM_stmt = $order->getTopSoldCropMonthly();
$MCSA_stmt = $order->getTopSoldCropAnnually();

?>
<div class="row g-3">

  <!-- SECTION HEADER (ONCE) -->
  <div class="col-12">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h5 class="fw-bold mb-0">🌱 Crop Analytics</h5>
        <small class="text-muted">
          Weather-based seasonal crop insights
        </small>
      </div>
    </div>
  </div>


<!-- Crop Analytics Tabs -->
<div class="col-lg-6 col-sm-12">
  <div class="card shadow-sm h-100 two-d-border">

    <!-- Card Header -->
    <div class="card-header d-flex align-items-center justify-content-between fw-bold text-white"
         style="background: linear-gradient(135deg, #198754, #20c997);">
      <div class="d-flex align-items-center gap-2">
        <div class="icon-badge bg-white text-success rounded-circle p-2">
          <i class="bi bi-bar-chart-fill"></i>
        </div>
        <span>Top Crop Sales Analytics</span>
      </div>
      <span class="badge bg-light text-success small">Live</span>
    </div>

    <!-- Nav Tabs -->
    <ul class="nav nav-pills nav-fill mt-3 mr-3" id="cropTabs" role="tablist">

      <li class="nav-item ms-2 me-2" role="presentation">
        <button class="nav-link active" id="daily-crop-sold-lbl" data-bs-toggle="tab" data-bs-target="#daily-crop-sold-tab" type="button" role="tab">
          Today
        </button>
      </li>
      <li class="nav-item me-2" role="presentation">
        <button class="nav-link" id="monthly-crop-sold-lbl" data-bs-toggle="tab" data-bs-target="#monthly-crop-sold-tab" type="button" role="tab">
          Monthly
        </button>
      </li>
      <li class="nav-item me-2" role="presentation">
        <button class="nav-link" id="annual-crop-sold-lbl" data-bs-toggle="tab" data-bs-target="#annual-crop-sold-tab" type="button" role="tab">
          Annually
        </button>
      </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
      
      <!-- Daily Tab -->
      <div class="tab-pane fade show active" id="daily-crop-sold-tab" role="tabpanel" aria-labelledby="daily-crop-sold-lbl">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Crop</th>
                <th>Sold Quantity</th>
                <th>Date</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $rank_MSC = 1;
                while ($row_MSC = $MCSD_stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$rank_MSC}</td>";
                    echo "<td>{$row_MSC['product_name']}</td>";
                    echo "<td>{$row_MSC['total_sold']} KG</td>";
                    echo "<td>{$row_MSC['sale_date']} KG</td>";
                    echo "<td>₱" . number_format($row_MSC['price_sold'], 2). "</td>";
                    
                    echo "</tr>";
                    $rank_MSC++;
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Monthly Tab -->
      <div class="tab-pane fade" id="monthly-crop-sold-tab" role="tabpanel" aria-labelledby="monthly-crop-sold-lbl">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Crop</th>
                <th>Sold Quantity</th>
                <th>Month</th>
                <th>Amount</th>
                
              </tr>
            </thead>
            <tbody>
              <?php
                $rank_MSCM = 1;
                while ($row_MCSM = $MCSM_stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$rank_MSCM}</td>";
                    echo "<td>{$row_MCSM['product_name']}</td>";
                    echo "<td>{$row_MCSM['total_sold']} KG</td>";
                    echo "<td>{$row_MCSM['sale_day']}</td>";
                    echo "<td>₱" . number_format($row_MCSM['price_sold'], 2) . "</td>";
                    echo "</tr>";
                    $rank_MSCM++;
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Annual Tab -->
      <div class="tab-pane fade" id="annual-crop-sold-tab" role="tabpanel" aria-labelledby="annual-crop-sold-lbl">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Crop</th>
                <th>Sold Quantity</th>
                <th>Month</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $rank_MSCA = 1;
                while ($row_MCSA = $MCSA_stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$rank_MSCA}</td>";
                    echo "<td>{$row_MCSA['product_name']}</td>";
                    echo "<td>{$row_MCSA['total_sold']} KG</td>";
                    echo "<td>{$row_MCSA['sale_month']}</td>";
                    echo "<td>₱" . number_format($row_MCSA['price_sold'], 2) . "</td>";
                    echo "</tr>";
                    $rank_MSCA++;
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>


    </div>
  </div>

  <!-- TOP SEASONAL CROPS -->
  <div class="col-lg-6 col-sm-12">
    <div class="card shadow-sm h-100 two-d-border">

      <!-- Header -->
      <div class="card-header d-flex align-items-center justify-content-between fw-bold text-white"
        style="background: linear-gradient(135deg, #198754, #20c997);">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-badge bg-white text-success rounded-circle p-2">
            <i class="bi bi-bar-chart-fill"></i>
          </div>
          <span>Top Seasonal Crops</span>
        </div>
        <span class="badge bg-light text-success small">
          <i class="bi bi-cloud-sun"></i> Live
        </span>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 60px;">#</th>
                <th>Crop</th>
                <th class="text-end">Rain (mm)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $rank = 1;
              while ($row_crops = $SC_stmt->fetch(PDO::FETCH_ASSOC)) {
                $rankBadge = match ($rank) {
                    1 => 'bg-warning text-dark',
                    2 => 'bg-secondary',
                    3 => 'bg-info',
                    default => 'bg-light text-dark'
                };

                echo "
                <tr>
                  <td>
                    <span class='badge {$rankBadge}'>{$rank}</span>
                  </td>
                  <td>
                    <div class='fw-semibold'>
                      <i class='bi bi-seedling text-success me-1'></i>
                      {$row_crops['crop_name']}
                    </div>
                  </td>
                  <td class='text-end'>
                    <span class='badge bg-success-subtle text-success'>
                      {$row_crops['avg_precip']} mm
                    </span>
                  </td>
                </tr>";
                $rank++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Footer actions -->
      <div class="card-footer bg-light d-flex justify-content-between align-items-center">
        <small class="text-muted">
          Based on weather & crop logs
        </small>
      </div>

    </div>
  </div>
  
    <div class="col-lg-6 col-sm-12">
    <div class="card shadow-sm h-100 two-d-border">

      <!-- Header -->
      <div class="card-header d-flex align-items-center justify-content-between fw-bold text-white"
        style="background: linear-gradient(135deg, #198754, #20c997);">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-badge bg-white text-success rounded-circle p-2">
            <i class="bi bi-bar-chart-fill"></i>
          </div>
          <span>Top Seasonal Crops</span>
        </div>
        <span class="badge bg-light text-success small">
          <i class="bi bi-cloud-sun"></i> Live
        </span>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 60px;">#</th>
                <th>Crop</th>
                <th class="text-end">Rain (mm)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $rank = 1;
              while ($row_crops = $SC_stmt->fetch(PDO::FETCH_ASSOC)) {
                $rankBadge = match ($rank) {
                    1 => 'bg-warning text-dark',
                    2 => 'bg-secondary',
                    3 => 'bg-info',
                    default => 'bg-light text-dark'
                };

                echo "
                <tr>
                  <td>
                    <span class='badge {$rankBadge}'>{$rank}</span>
                  </td>
                  <td>
                    <div class='fw-semibold'>
                      <i class='bi bi-seedling text-success me-1'></i>
                      {$row_crops['crop_name']}
                    </div>
                  </td>
                  <td class='text-end'>
                    <span class='badge bg-success-subtle text-success'>
                      {$row_crops['avg_precip']} mm
                    </span>
                  </td>
                </tr>";
                $rank++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Footer actions -->
      <div class="card-footer bg-light d-flex justify-content-between align-items-center">
        <small class="text-muted">
          Based on weather & crop logs
        </small>
      </div>

    </div>
  </div>
    <div class="col-lg-6 col-sm-12">
    <div class="card shadow-sm h-100 two-d-border">

      <!-- Header -->
      <div class="card-header d-flex align-items-center justify-content-between fw-bold text-white"
        style="background: linear-gradient(135deg, #198754, #20c997);">
        <div class="d-flex align-items-center gap-2">
          <div class="icon-badge bg-white text-success rounded-circle p-2">
            <i class="bi bi-bar-chart-fill"></i>
          </div>
          <span>Top Seasonal Crops</span>
        </div>
        <span class="badge bg-light text-success small">
          <i class="bi bi-cloud-sun"></i> Live
        </span>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 60px;">#</th>
                <th>Crop</th>
                <th class="text-end">Rain (mm)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $rank = 1;
              while ($row_crops = $SC_stmt->fetch(PDO::FETCH_ASSOC)) {
                $rankBadge = match ($rank) {
                    1 => 'bg-warning text-dark',
                    2 => 'bg-secondary',
                    3 => 'bg-info',
                    default => 'bg-light text-dark'
                };

                echo "
                <tr>
                  <td>
                    <span class='badge {$rankBadge}'>{$rank}</span>
                  </td>
                  <td>
                    <div class='fw-semibold'>
                      <i class='bi bi-seedling text-success me-1'></i>
                      {$row_crops['crop_name']}
                    </div>
                  </td>
                  <td class='text-end'>
                    <span class='badge bg-success-subtle text-success'>
                      {$row_crops['avg_precip']} mm
                    </span>
                  </td>
                </tr>";
                $rank++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Footer actions -->
      <div class="card-footer bg-light d-flex justify-content-between align-items-center">
        <small class="text-muted">
          Based on weather & crop logs
        </small>
      </div>

    </div>
  </div>
</div>
