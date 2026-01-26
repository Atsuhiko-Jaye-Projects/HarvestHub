<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmer Daily Crop Log</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .crop-card { margin-bottom: 20px; }
    .health-btn.active { font-weight: bold; }
    .activity-btn.active { background-color: #0d6efd; color: #fff; }
  </style>
</head>
<body class="p-3">

  <div class="container">
    <h2 class="mb-4">My Crops - Daily Log</h2>

    <!-- Sample Crop Card -->
    <div class="card crop-card" data-crop-id="1">
      <div class="card-body">
        <h5 class="card-title">Kamatis (Tomato)</h5>
        <p>Planting Date: 2026-01-20 | Growing Days: 75</p>

        <!-- Health Status Buttons -->
        <div class="mb-2">
          <strong>Health Status:</strong>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-success health-btn" data-value="Healthy">Healthy</button>
            <button type="button" class="btn btn-outline-danger health-btn" data-value="Diseased">Diseased</button>
            <button type="button" class="btn btn-outline-warning health-btn" data-value="Wilting">Wilting</button>
          </div>
        </div>

        <!-- Activity Buttons -->
        <div class="mb-2">
          <strong>Activities:</strong>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Applied Fertilizer">Fertilizer</button>
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Applied Pesticide">Pesticide</button>
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Pruned">Pruned</button>
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Watered">Watered</button>
          </div>
        </div>

        <!-- Auto-save info -->
        <div class="mt-2">
          <small class="text-muted log-status">No changes yet</small>
        </div>
      </div>
    </div>

    <!-- Repeat cards for other crops -->
    <div class="card crop-card" data-crop-id="2">
      <div class="card-body">
        <h5 class="card-title">Talong (Eggplant)</h5>
        <p>Planting Date: 2026-01-18 | Growing Days: 80</p>

        <div class="mb-2">
          <strong>Health Status:</strong>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-success health-btn" data-value="Healthy">Healthy</button>
            <button type="button" class="btn btn-outline-danger health-btn" data-value="Diseased">Diseased</button>
            <button type="button" class="btn btn-outline-warning health-btn" data-value="Wilting">Wilting</button>
          </div>
        </div>

        <div class="mb-2">
          <strong>Activities:</strong>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Applied Fertilizer">Fertilizer</button>
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Applied Pesticide">Pesticide</button>
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Pruned">Pruned</button>
            <button type="button" class="btn btn-outline-primary activity-btn" data-value="Watered">Watered</button>
          </div>
        </div>

        <div class="mt-2">
          <small class="text-muted log-status">No changes yet</small>
        </div>
      </div>
    </div>

  </div>

  <script>
    // Health buttons (single select)
    document.querySelectorAll('.health-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const group = btn.parentElement;
        group.querySelectorAll('.health-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        saveLog(btn.closest('.crop-card'));
      });
    });

    // Activity buttons (multi-select toggle)
    document.querySelectorAll('.activity-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        btn.classList.toggle('active');

        saveLog(btn.closest('.crop-card'));
      });
    });

    // Save function (simulate AJAX)
    function saveLog(cropCard) {
      const cropId = cropCard.dataset.cropId;

      // Health
      const healthBtn = cropCard.querySelector('.health-btn.active');
      const healthStatus = healthBtn ? healthBtn.dataset.value : null;

      // Activities
      const activeActivities = [];
      cropCard.querySelectorAll('.activity-btn.active').forEach(b => activeActivities.push(b.dataset.value));

      // Debug / placeholder AJAX
      console.log('Saving log:', {
        cropId,
        healthStatus,
        activities: activeActivities
      });

      // Update UI status
      const statusText = cropCard.querySelector('.log-status');
      statusText.textContent = `Saved: Health = ${healthStatus || 'None'}, Activities = ${activeActivities.join(', ') || 'None'}`;

      // Here you would replace console.log with an actual AJAX POST to PHP
      // Example:
      /*
      fetch('save_log.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ cropId, healthStatus, activities: activeActivities })
      }).then(res => res.json()).then(data => {
        statusText.textContent = 'Saved successfully';
      });
      */
    }
  </script>

</body>
</html>
