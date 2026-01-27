<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/crop.php";

$page_title = "Daily Crop Log";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$crop = new Crop($db);
$crop->user_id = $_SESSION['user_id'];

$page_url = "{$home_url}user/farmer/farm/daily_crop_log.php?";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 6;
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $crop->readAllPlantedCrop($from_record_num, $records_per_page);
$num  = $stmt->rowCount();
$total_rows = $crop->countAll();

include_once "../statistics/stats.php";
?>

<div class="container mt-3">
  <div class="card shadow-sm rounded p-3 d-flex flex-row justify-content-between align-items-center mb-3">

    <!-- Weather Info -->
        <div>
    <div class="alert alert-warning py-1 px-2 mb-3 text-center fw-semibold" style="font-size:0.9rem;">
        Today’s weather will affect your crops 🌱
    </div>
        <h2 id="temperature" class="mb-1 fw-bold" style="font-size:2.5rem; color:#0d6efd;">--°C</h2>
        <h5 id="location" class="mb-0 fw-semibold">--</h5>
        <small id="desc" class="text-muted">--</small>
        </div>
    </div>


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

          <h3 class="fw-bold mb-1">
            <?= ucwords(strtolower(htmlspecialchars($crop_name))) ?>
          </h3>

          <p class="small text-muted mb-2">
            Planted: <?= date("M d, Y", strtotime($date_planted)) ?>
          </p>


          <!-- HEALTH STATUS -->
          <div class="mb-2">
            <strong class="small">Health Status</strong>
            <div class="btn-group w-100 mt-1">
              <button type="button" class="btn btn-outline-success health-btn" data-value="Healthy">Healthy</button>
              <button type="button" class="btn btn-outline-warning health-btn" data-value="Stressed">Wilting</button>
              <button type="button" class="btn btn-outline-danger health-btn" data-value="Diseased">Diseased</button>
            </div>
          </div>

          <!-- ACTIVITIES -->
          <div class="mb-2">
            <strong class="small">Activities</strong>
                <div class="row g-2 mt-1">
                <div class="col-6 col-md-6">
                    <button type="button" class="btn btn-outline-primary w-100 activity-btn" data-value="Watered">
                    💧 Watered
                    </button>
                </div>

                <div class="col-6 col-md-6">
                    <button type="button" class="btn btn-outline-primary w-100 activity-btn" data-value="Fertilized">
                    🌱 Fertilizer
                    </button>
                </div>

                <div class="col-6 col-md-6">
                    <button type="button" class="btn btn-outline-primary w-100 activity-btn" data-value="Pesticide">
                    🐛 Pesticide
                    </button>
                </div>

                <div class="col-6 col-md-6">
                    <button type="button" class="btn btn-outline-primary w-100 activity-btn" data-value="Pruned">
                    ✂️ Pruned
                    </button>
                </div>
                </div>
                <div class="mt-2">
                    <label class="btn btn-outline-success w-100">
                        📷 Take Photo
                        <input 
                        type="file"
                        accept="image/*"
                        capture="environment"
                        class="d-none crop-photo"
                        >
                    </label>

                    <div class="mt-2 text-center">
                            <img 
                                class="img-fluid rounded d-none preview-photo" 
                                alt="Crop photo preview"
                                style="width:300px; max-height:300px; object-fit:contain; display:block; border:1px solid #ced4da;"
                            >
                            <small class="text-muted photo-status"></small>
                        </div>
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


<?php include_once "../layout/layout_foot.php"; ?>

<script>
/* Health buttons (single select) */
document.querySelectorAll('.health-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.crop-card');
    card.querySelectorAll('.health-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    saveLog(card);
  });
});

/* Activity buttons (multi-select) */
document.querySelectorAll('.activity-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    btn.classList.toggle('active');
    saveLog(btn.closest('.crop-card'));
  });
});

function saveLog(card) {
  const cropId = card.dataset.cropId;

  const healthBtn = card.querySelector('.health-btn.active');
  const health = healthBtn ? healthBtn.dataset.value : null;

  const activities = [];
  card.querySelectorAll('.activity-btn.active')
    .forEach(btn => activities.push(btn.dataset.value));

  // UI feedback
  card.querySelector('.log-status').textContent =
    `Saved: ${health || 'No health'} | ${activities.join(', ') || 'No activities'}`;

  // AJAX placeholder
  /*
  fetch('save_crop_log.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ crop_id: cropId, health, activities })
  });
  */

  console.log({ cropId, health, activities });
}

document.querySelectorAll('.crop-photo').forEach(input => {
input.addEventListener('change', () => {
    const cropCard = input.closest('.crop-card');
    const preview = cropCard.querySelector('.preview-photo');
    const status = cropCard.querySelector('.photo-status');

    const file = input.files[0];
    if (!file) return;

    // Preview image
    const reader = new FileReader();
    reader.onload = e => {
    preview.src = e.target.result;
    preview.classList.remove('d-none');
    };
    reader.readAsDataURL(file);

    // Simulate save
    status.textContent = '📤 Photo saved for today';

    console.log('Saving photo for crop:', cropCard.dataset.cropId, file);

    // REAL upload example (PHP backend)
    /*
    const formData = new FormData();
    formData.append('crop_id', cropCard.dataset.cropId);
    formData.append('photo', file);

    fetch('upload_photo.php', {
    method: 'POST',
    body: formData
    });
    */
});
});
</script>
