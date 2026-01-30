<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/crop.php";
include_once "../../../objects/farm.php";
include_once "../../../objects/daily_crop_log.php";
include_once "../../../objects/product.php";


$page_title = "Daily Crop Log";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$crop = new Crop($db);
$farm = new Farm($db);
$product = new Product($db);


$crop->user_id = $_SESSION['user_id'];  
//get farmer location
$farm->user_id = $_SESSION['user_id'];
$farm->getFarmerLocation();

// get the farmer location
$location = $farm->baranggay . ', ' . $farm->municipality . ', ' . $farm->province;

$page_url = "{$home_url}user/farmer/farm/daily_crop_log.php?";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 6;
$from_record_num = ($records_per_page * $page) - $records_per_page;

$stmt = $crop->readAllPlantedCrop($from_record_num, $records_per_page);
$num  = $stmt->rowCount();
$total_rows = $crop->countAll();

// cache weather api
$user_cache_dir = __DIR__ . '/cache/' . $_SESSION['user_id'] . '/';
if (!is_dir($user_cache_dir)) {
    mkdir($user_cache_dir);
}
$cache_file = $user_cache_dir . '_weather_' . md5($location) . '.json';
$cache_time = 3600; // 10 minutes in seconds

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    // Use cached data
    $weather = json_decode(file_get_contents($cache_file), true);
} else {
    // Call Visual Crossing API
    $apiKey = 'VTZE7BHR7XAT9XD3GGS4VL3HU';
    $url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/" . urlencode($location) . "/today?unitGroup=metric&key={$apiKey}";

    $response = file_get_contents($url);
    $weather = json_decode($response, true);

    // Save cache
    file_put_contents($cache_file, json_encode($weather));
}

// Now $weather contains today’s weather
$temperature = $weather['days'][0]['temp'] ?? '--';
$humidity = $weather['days'][0]['humidity'] ?? '--';
$conditions = $weather['days'][0]['conditions'] ?? '--';
$datetime = $weather['days'][0]['datetime'] ?? '--';
$precipitation = $weather['days'][0]['precip'] ?? '--';
$precipitation_prob = $weather['days'][0]['precipprob'] ?? '--';


if ($_POST) {

    $dailyLog = new FarmCropLog($db);

    $dailyLog->user_id = $_SESSION['user_id'];
    $dailyLog->log_date = $_POST['weather_date'];
    $dailyLog->temperature = $_POST['weather_temp'];
    $dailyLog->humidity = $_POST['weather_humidity'];
    $dailyLog->weather_conditions = $_POST['weather_desc'];
    $dailyLog->location = $_POST['weather_location'];
    $dailyLog->precipitation = $_POST['weather_precip'];
    $dailyLog->precipitation_prob = $_POST['weather_precip_prob'];
    $crop_ids = $_POST['crop_id'] ?? [];

    if (!is_array($crop_ids)) {
        $crop_ids = [$crop_ids];
    }

    foreach ($crop_ids as $crop_id) {
        $health = $_POST['health_status'][$crop_id] ?? '';

        if ($health === '') {
            continue;
        }
        $dailyLog->crop_id = $crop_id;
        $dailyLog->health_status = $_POST['health_status'][$crop_id] ?? null;
        $dailyLog->activities = $_POST['activities'][$crop_id] ?? null;
        $dailyLog->remarks = "Logged";

        // 📸 photo upload (clean call)
        $dailyLog->photo_path = (isset($_FILES['photo']['name'][$crop_id]) 
                                 && $_FILES['photo']['error'][$crop_id] === 0)
            ? $dailyLog->uploadPhoto([
                'name' => $_FILES['photo']['name'][$crop_id],
                'tmp_name' => $_FILES['photo']['tmp_name'][$crop_id]
              ], $_SESSION['user_id'], $crop_id)
            : null;

        $dailyLog->save();
    }
}

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

  <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
    <div class="row g-3">

        <?php 
        if ($num > 0) {
            $dailyLog = new FarmCropLog($db);
            
            $dailyLog->user_id = $_SESSION['user_id'];
            $dailyLog->log_date = date('Y-m-d');

            // disable the save button all crops are logged
            $AllCropLogged = $dailyLog->allCropLogged();
            
            $disable_save = '';

            $disable_save = '';

            if ($AllCropLogged === $num) {
                $disable_save = 'pe-none opacity-50';
            }


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $dailyLog->user_id = $_SESSION['user_id'];
                $dailyLog->crop_id = $id;
                $dailyLog->log_date = date('Y-m-d');
                $isLoggedToday = $dailyLog->cropLoggedToday();

                
        ?>
        
            <!-- Hidden Weather Inputs -->
            <input type="hidden" name="weather_location" value="<?= htmlspecialchars($location) ?>">
            <input type="hidden" name="weather_temp" value="<?= $temperature ?>">
            <input type="hidden" name="weather_desc" value="<?= $conditions ?>">
            <input type="hidden" name="weather_humidity" value="<?= $humidity ?>">
            <input type="hidden" name="weather_date" value="<?= $datetime ?>">
            <input type="hidden" name="weather_precip" value="<?= $precipitation ?>">
            <input type="hidden" name="weather_precip_prob" value="<?= $precipitation_prob ?>">
            
            

            <div class="col-md-6 col-lg-4 col-sm-12">
                <div class="card crop-card shadow-sm" data-crop-id="<?= $id ?>">
                    <div class="card-body">

                        <h3 class="fw-bold mb-1"><?= ucwords(strtolower(htmlspecialchars($crop_name))) ?></h3>
                        <p class="small text-muted mb-2">Planted: <?= date("M d, Y", strtotime($date_planted)) ?></p>
                        <p class="small text-muted mb-2">Harvest Date: <?= date("M d, Y", strtotime($estimated_harvest_date)) ?></p>

                        <!-- HEALTH STATUS -->
                        <div class="mb-2">
                            <strong class="small">Health Status</strong>
                            <div class="btn-group w-100 mt-1 col-sm-12 <?= $isLoggedToday ? 'pe-none opacity-50' : '' ?>">
                                <input type="hidden" name="crop_id[]" value="<?= $id ?>">
                                <input type="hidden" name="health_status[<?= $id ?>]" class="health-input">
                                <input type="hidden" name="activities[<?= $id ?>]" class="activities-input">
                                
                                <button type="button" class="btn btn-outline-success health-btn" data-value="Healthy">Healthy</button>
                                <button type="button" class="btn btn-outline-warning health-btn" data-value="Stressed">Wilting</button>
                                <button type="button" class="btn btn-outline-danger health-btn" data-value="Diseased">Diseased</button>
                            </div>
                            
                        </div>

                        <!-- ACTIVITIES -->
                        <div class="mb-2">
                            <strong class="small">Activities</strong>

                            <div class="row g-2 mt-1 <?= $isLoggedToday ? 'pe-none opacity-50' : '' ?>">
                                <!-- Hidden input -->
                                <input type="hidden" name="activities[<?= $crop_id ?>]" class="activities-input">

                                <div class="col-12 col-sm-6">
                                    <label class="btn btn-outline-primary w-100">
                                        <input type="checkbox" class="d-none activity-checkbox" value="Watered">
                                        💧 Watered
                                    </label>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="btn btn-outline-primary w-100">
                                        <input type="checkbox" class="d-none activity-checkbox" value="Fertilized">
                                        🌱 Fertilizer
                                    </label>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="btn btn-outline-primary w-100">
                                        <input type="checkbox" class="d-none activity-checkbox" value="Pesticide">
                                        🐛 Pesticide
                                    </label>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="btn btn-outline-primary w-100">
                                        <input type="checkbox" class="d-none activity-checkbox" value="Pruned">
                                        ✂️ Pruned
                                    </label>
                                </div>
                            </div>


                            <!-- Only one hidden input for this crop -->
                            <input type="hidden" name="activities[<?= $crop_id ?>]" class="activities-input">


                            <!-- Photo -->
                            <div class="mt-2">
                                <label class="btn btn-outline-success w-100 <?= $isLoggedToday ? 'pe-none opacity-50' : '' ?>">
                                    📷 Take Photo
                                        <input type="file" name="photo[<?= $id ?>]" class="d-none crop-photo" accept="image/*" capture="environment">
                                </label>

                                <div class="mt-2 text-center">
                                    <img class="img-fluid rounded d-none preview-photo" 
                                        alt="Crop photo preview"
                                        style="width:250px; max-height:300px; object-fit:contain; display:block; border:1px solid #ced4da;">
                                    <small class="text-muted photo-status"></small>
                                </div>
                            </div>
                            <?php if ($isLoggedToday): ?>
                                <small class="text-success fw-semibold">✔ Logged today</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-center <?= $disable_save ?>">
                <button type="submit" class="btn btn-success btn-lg">Save Daily Log</button>
            </div>
        <?php 
            } // end while
        } else {
            echo "<div class='alert alert-warning'>No Crop to log.</div>";
        } 
        ?>
    </div>

    <!-- Submit Button -->

</form>


  </div>

</div>
</div>




<?php include_once "../layout/layout_foot.php"; ?>

<script>
const USER_LOCATION = "<?php echo $location; ?>";
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
document.querySelectorAll('.crop-card').forEach(card => {
    const hiddenInput = card.querySelector('.activities-input');
    
    card.querySelectorAll('.activity-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            // Toggle label active class
            if (checkbox.checked) {
                checkbox.parentElement.classList.add('active');
            } else {
                checkbox.parentElement.classList.remove('active');
            }

            // Update hidden input with all selected values
            const selected = [];
            card.querySelectorAll('.activity-checkbox:checked').forEach(cb => selected.push(cb.value));
            hiddenInput.value = selected// or leave as array if you want
        });
    });
});




document.querySelectorAll('.health-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.card-body');
    // Remove active from siblings
    card.querySelectorAll('.health-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // Update hidden input
    const input = card.querySelector('.health-input');
    input.value = btn.dataset.value;
  });
});

// Activity buttons (multi-select)
// Multi-select toggle for activities


// Photo preview
document.querySelectorAll('.crop-photo').forEach(fileInput => {
  fileInput.addEventListener('change', (e) => {
    const card = fileInput.closest('.card-body');
    const preview = card.querySelector('.preview-photo');

    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();
      reader.onload = (event) => {
        preview.src = event.target.result;
        preview.classList.remove('d-none');
      };
      reader.readAsDataURL(fileInput.files[0]);
    }
  });
});

</script>
