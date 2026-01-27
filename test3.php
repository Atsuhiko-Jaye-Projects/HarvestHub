<div class="container mt-3">
  <h5 class="mb-4">
    <i class="bi bi-clipboard-check text-success"></i> My Crops – Daily Log
  </h5>

  <div class="row g-3">

    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
    ?>

    <div class="col-md-6 col-lg-4">
      <div class="card crop-card shadow-sm" data-crop-id="<?= $crop_id ?>">
        <div class="card-body">

          <h6 class="fw-bold mb-1">
            <?= ucwords(strtolower(htmlspecialchars($crop_name))) ?>
          </h6>

          <p class="small text-muted mb-2">
            Planted: <?= date("M d, Y", strtotime($planting_date)) ?>
          </p>

          <!-- HEALTH STATUS -->
          <div class="mb-2">
            <strong class="small">Health Status</strong>
            <div class="btn-group w-100 mt-1">
              <button type="button" class="btn btn-outline-success health-btn" data-value="Healthy">Healthy</button>
              <button type="button" class="btn btn-outline-warning health-btn" data-value="Stressed">Stressed</button>
              <button type="button" class="btn btn-outline-danger health-btn" data-value="Diseased">Diseased</button>
            </div>
          </div>

          <!-- ACTIVITIES -->
          <div class="mb-2">
            <strong class="small">Activities</strong>
            <div class="btn-group w-100 flex-wrap mt-1">
              <button type="button" class="btn btn-outline-primary activity-btn" data-value="Watered">Watered</button>
              <button type="button" class="btn btn-outline-primary activity-btn" data-value="Fertilized">Fertilizer</button>
              <button type="button" class="btn btn-outline-primary activity-btn" data-value="Pesticide">Pesticide</button>
              <button type="button" class="btn btn-outline-primary activity-btn" data-value="Pruned">Pruned</button>
            </div>
          </div>

          <small class="text-muted log-status">
            No activity logged today
          </small>

        </div>
      </div>
    </div>

    <?php } ?>

  </div>
</div>
