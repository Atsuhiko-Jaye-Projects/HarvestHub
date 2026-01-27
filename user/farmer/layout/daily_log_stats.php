<!-- DAILY LOG SUMMARY PANEL -->
<div class="card shadow-sm rounded mb-4">
  <div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
      <h6 class="fw-bold mb-2 mb-md-0">Daily Log Summary</h6>

      <!-- Action Button (Desktop) -->
      <a href="farm/daily_crop_log.php" 
         class="btn btn-success btn-sm d-none d-md-inline-flex align-items-center">
        <i class="bi bi-plus-circle me-1"></i> Log Today
      </a>
    </div>

    <div class="d-flex align-items-center">

      <!-- Health Score -->
      <div class="me-4 text-center">
        <div class="fw-bold fs-2 text-success">
          <?php echo number_format($daily_health_score ?? 4.3, 1); ?>
        </div>
        <div class="small text-muted">health score</div>
      </div>

      <!-- Stars + Logs -->
      <div>
        <?php
          $score = round(($daily_health_score ?? 4.3) * 2) / 2;
          $fullStars = floor($score);
          $halfStar = ($score - $fullStars) == 0.5;
          $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        ?>

        <div class="mb-1">
          <?php for ($i=0; $i < $fullStars; $i++) : ?>
            <i class="bi bi-star-fill text-success"></i>
          <?php endfor; ?>

          <?php if ($halfStar) : ?>
            <i class="bi bi-star-half text-success"></i>
          <?php endif; ?>

          <?php for ($i=0; $i < $emptyStars; $i++) : ?>
            <i class="bi bi-star text-success"></i>
          <?php endfor; ?>
        </div>

        <div class="small text-muted">
          <?php echo number_format($total_logs_today ?? 12); ?> crop logs today
        </div>
      </div>

    </div>

    <hr>

    <div class="small text-muted mb-3">
      🌱 Healthy: <?php echo $healthy_count ?? 8; ?> |
      ⚠️ Stressed: <?php echo $stressed_count ?? 3; ?> |
      ❌ Diseased: <?php echo $diseased_count ?? 1; ?>
    </div>

    <!-- BIG MOBILE BUTTON -->
    <div class="d-md-none">
      <a href="farm/daily_crop_log.php" class="btn btn-success w-100 btn-lg d-flex align-items-center justify-content-center">
        <i class="bi bi-clipboard-check fs-4 me-2"></i>
        Log Today’s Crop Status
      </a>
    </div>

  </div>
</div>
