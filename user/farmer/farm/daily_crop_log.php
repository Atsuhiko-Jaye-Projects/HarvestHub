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
$farm->user_id = $_SESSION['user_id'];
$farm->getFarmerLocation();

$location = $farm->baranggay . ', ' . $farm->municipality . ', ' . $farm->province;

// Weather Cache Logic (Kept your original logic)
$user_cache_dir = __DIR__ . '/cache/' . $_SESSION['user_id'] . '/';
if (!is_dir($user_cache_dir)) { mkdir($user_cache_dir, 0777, true); }
$cache_file = $user_cache_dir . '_weather_' . md5($location) . '.json';
$cache_time = 3600; 

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    $weather = json_decode(file_get_contents($cache_file), true);
} else {
    $apiKey = 'VTZE7BHR7XAT9XD3GGS4VL3HU';
    $url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/" . urlencode($location) . "/today?unitGroup=metric&key={$apiKey}";
    $response = file_get_contents($url);
    $weather = json_decode($response, true);
    file_put_contents($cache_file, json_encode($weather));
}

$temperature = $weather['days'][0]['temp'] ?? '--';
$humidity = $weather['days'][0]['humidity'] ?? '--';
$conditions = $weather['days'][0]['conditions'] ?? '--';
$datetime = $weather['days'][0]['datetime'] ?? '--';
$precipitation = $weather['days'][0]['precip'] ?? '--';
$precipitation_prob = $weather['days'][0]['precipprob'] ?? '--';

// POST Logic (Kept your original logic)
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

    foreach ($crop_ids as $crop_id) {
        $health = $_POST['health_status'][$crop_id] ?? '';
        if ($health === '') continue;
        
        $dailyLog->crop_id = $crop_id;
        $dailyLog->health_status = $health;
        $dailyLog->activities = $_POST['activities'][$crop_id] ?? null;
        $dailyLog->remarks = "Logged";
        
        $dailyLog->photo_path = (isset($_FILES['photo']['name'][$crop_id]) && $_FILES['photo']['error'][$crop_id] === 0)
            ? $dailyLog->uploadPhoto(['name' => $_FILES['photo']['name'][$crop_id], 'tmp_name' => $_FILES['photo']['tmp_name'][$crop_id]], $_SESSION['user_id'], $crop_id)
            : null;
        $dailyLog->save();
    }
}

include_once "../statistics/stats.php";
$stmt = $crop->readAllPlantedCrop(0, 100); // Simplified for design demonstration
$num = $stmt->rowCount();
?>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --primary-soft: #eef2ff;
        --accent-indigo: #4f46e5;
    }

    body { background-color: #f8fafc; }

    /* Weather Widget */
    .weather-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: white;
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    .weather-card::after {
        content: '\F210'; /* Bootstrap Cloud icon */
        font-family: 'bootstrap-icons';
        position: absolute;
        right: -10px;
        top: -10px;
        font-size: 8rem;
        opacity: 0.1;
    }

    /* Modern Crop Card */
    .crop-card {
        background: var(--glass-bg);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        transition: transform 0.2s;
        height: 100%;
    }
    .crop-card:hover { transform: translateY(-5px); }

    /* Custom Selection Buttons */
    .health-btn-group .btn {
        border-radius: 12px;
        margin: 0 4px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 2px solid transparent;
    }
    .health-btn-group .btn.active { border-color: inherit; }

    .activity-label {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .activity-checkbox:checked + .activity-label {
        background: #dbeafe;
        border-color: #3b82f6;
        color: #1e40af;
    }

    .photo-preview-box {
        width: 100%;
        height: 180px;
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .photo-preview-box img { width: 100%; height: 100%; object-fit: cover; }
</style>

<div class="container py-4 px-lg-5">
    
    <div class="weather-card shadow-lg mb-5">
        <div class="row align-items-center">
            <div class="col-md-7">
                <span class="badge bg-primary mb-2 rounded-pill px-3">Live Forecast</span>
                <h1 class="fw-bold mb-1 display-4"><?= $temperature ?>°C</h1>
                <h4 class="fw-semibold opacity-75"><?= $location ?></h4>
                <div class="d-flex gap-3 mt-3">
                    <span class="small"><i class="bi bi-droplets me-1"></i> Humidity: <?= $humidity ?>%</span>
                    <span class="small"><i class="bi bi-cloud-rain me-1"></i> Rain: <?= $precipitation_prob ?>%</span>
                </div>
            </div>
            <div class="col-md-5 text-md-end mt-4 mt-md-0">
                <p class="mb-1 small text-uppercase fw-bold opacity-50">Conditions</p>
                <h3 class="fw-bold"><?= ucwords($conditions) ?></h3>
                <p class="mb-0 small opacity-75"><?= date("l, M d Y") ?></p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-check text-success me-2"></i>Daily Farm Log</h4>
        <span class="text-muted small"><?= $num ?> Crops Tracked</span>
    </div>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <?php 
            if ($num > 0) {
                $dailyLog = new FarmCropLog($db);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $dailyLog->user_id = $_SESSION['user_id'];
                    $dailyLog->crop_id = $id;
                    $dailyLog->log_date = date('Y-m-d');
                    $isLoggedToday = $dailyLog->cropLoggedToday();
            ?>
            
            <input type="hidden" name="weather_location" value="<?= htmlspecialchars($location) ?>">
            <input type="hidden" name="weather_temp" value="<?= $temperature ?>">
            <input type="hidden" name="weather_desc" value="<?= $conditions ?>">
            <input type="hidden" name="weather_humidity" value="<?= $humidity ?>">
            <input type="hidden" name="weather_date" value="<?= date('Y-m-d H:i:s') ?>">
            <input type="hidden" name="weather_precip" value="<?= $precipitation ?>">
            <input type="hidden" name="weather_precip_prob" value="<?= $precipitation_prob ?>">

            <div class="col-lg-4 col-md-6">
                <div class="crop-card shadow-sm p-4 d-flex flex-column <?= $isLoggedToday ? 'opacity-75' : '' ?>">
                    <div class="mb-3">
                        <h4 class="fw-bold mb-0"><?= ucwords(strtolower(htmlspecialchars($crop_name))) ?></h4>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="small text-muted"><i class="bi bi-calendar-event me-1"></i> <?= date("M d", strtotime($date_planted)) ?></span>
                            <span class="small text-success fw-bold"><i class="bi bi-harvest me-1"></i> <?= date("M d", strtotime($estimated_harvest_date)) ?></span>
                        </div>
                    </div>

                    <div class="<?= $isLoggedToday ? 'pe-none' : '' ?>">
                        <input type="hidden" name="crop_id[]" value="<?= $id ?>">
                        
                        <div class="mb-4">
                            <label class="small fw-bold text-uppercase text-muted mb-2 d-block">Crop Health</label>
                            <div class="btn-group w-100 health-btn-group">
                                <input type="hidden" name="health_status[<?= $id ?>]" class="health-input">
                                <button type="button" class="btn btn-outline-success health-btn flex-fill" data-value="Healthy">Healthy</button>
                                <button type="button" class="btn btn-outline-warning health-btn flex-fill" data-value="Stressed">Wilting</button>
                                <button type="button" class="btn btn-outline-danger health-btn flex-fill" data-value="Diseased">Diseased</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold text-uppercase text-muted mb-2 d-block">Activities Done</label>
                            <input type="hidden" name="activities[<?= $id ?>]" class="activities-input">
                            <div class="row g-2">
                                <?php 
                                $acts = ['Watered' => '💧', 'Fertilizer' => '🌱', 'Pesticide' => '🐛', 'Pruned' => '✂️'];
                                foreach($acts as $val => $icon): ?>
                                <div class="col-6">
                                    <input type="checkbox" class="d-none activity-checkbox" id="act-<?= $id ?>-<?= $val ?>" value="<?= $val ?>">
                                    <label class="activity-label w-100" for="act-<?= $id ?>-<?= $val ?>">
                                        <?= $icon ?> <?= $val ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="photo-preview-box mb-2" id="preview-box-<?= $id ?>">
                                <i class="bi bi-camera fs-1 opacity-25"></i>
                            </div>
                            <label class="btn btn-light border w-100 rounded-pill small fw-bold">
                                <i class="bi bi-upload me-2"></i> Update Photo
                                <input type="file" name="photo[<?= $id ?>]" class="d-none crop-photo" accept="image/*" capture="environment" data-preview="#preview-box-<?= $id ?>">
                            </label>
                        </div>
                    </div>

                    <?php if ($isLoggedToday): ?>
                        <div class="mt-auto pt-3 border-top text-center">
                            <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i> Successfully Logged Today
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php 
                } 
            } else {
                echo "<div class='col-12 text-center py-5'><i class='bi bi-folder-x display-1 opacity-10'></i><p class='mt-3'>No crops found to log.</p></div>";
            } 
            ?>
        </div>

        <div class="text-center mt-5 mb-5">
            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg fw-bold">
                <i class="bi bi-cloud-upload me-2"></i> Save All Logs
            </button>
        </div>
    </form>
</div>

<?php include_once "../layout/layout_foot.php"; ?>

<script>
// Health Status Selection
document.querySelectorAll('.health-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const parent = this.closest('.health-btn-group');
        parent.querySelectorAll('.btn').forEach(b => b.classList.remove('active', 'btn-success', 'btn-warning', 'btn-danger'));
        this.classList.add('active');
        
        const val = this.dataset.value;
        if(val === 'Healthy') this.classList.add('btn-success');
        if(val === 'Stressed') this.classList.add('btn-warning');
        if(val === 'Diseased') this.classList.add('btn-danger');

        this.closest('.crop-card').querySelector('.health-input').value = val;
    });
});

// Activity Checkboxes to Hidden Input
document.querySelectorAll('.activity-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const card = this.closest('.crop-card');
        const hiddenInput = card.querySelector('.activities-input');
        const checked = Array.from(card.querySelectorAll('.activity-checkbox:checked')).map(cb => cb.value);
        hiddenInput.value = checked.join(', ');
    });
});

// Photo Preview
document.querySelectorAll('.crop-photo').forEach(input => {
    input.addEventListener('change', function() {
        const previewId = this.dataset.preview;
        const box = document.querySelector(previewId);
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                box.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>