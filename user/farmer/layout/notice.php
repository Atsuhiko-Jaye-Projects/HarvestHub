<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/config/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/objects/farm.php";

$database = new Database();
$db = $database->getConnection();

$farm = new Farm($db);
$farm->user_id = $_SESSION['user_id'] ?? 0;

/**
 * Fetch data safely
 */
$farm_info = $farm->getfarmerProfile();
$lotSize   = $farm->getLotSizeInfo();

/**
 * Defaults (prevents warnings)
 */
$totalLotSize = 0;
$usedLotSize  = 0;
$availableLot = 0;
$threshold    = 0;

/**
 * Guard: lot size record may be false
 */
if (!empty($lotSize) && is_array($lotSize)) {
    $totalLotSize = (float)($lotSize['lot_size'] ?? 0);
    $usedLotSize  = (float)($lotSize['used_lot_size'] ?? 0);
    $availableLot = $totalLotSize - $usedLotSize;
    $threshold    = 0.05 * $totalLotSize;
}
?>

<?php if (empty($farm_info)) : ?>

<!-- 🟡 FARM PROFILE INCOMPLETE -->
<div class="alert alert-warning d-flex align-items-center justify-content-between w-100 mb-2 rounded-3 shadow-sm"
     role="alert"
     style="border-left:5px solid #ffc107;">
    <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
        <div>
            <strong>Complete your farm profile</strong><br>
            <small class="text-muted">
                Add your farm details to gain trust and attract more future clients.
            </small>
        </div>
    </div>
    <a href="<?= $base_url; ?>user/farmer/profile/profile.php"
       class="btn btn-sm btn-warning fw-semibold ms-3">
        Complete now
    </a>
</div>

<?php elseif ($availableLot <= $threshold && $availableLot > 0) : ?>

<!-- 🟠 ALMOST FULL -->
<div class="alert d-flex align-items-center justify-content-between shadow-sm mb-4" 
     role="alert"
     style="border-left:5px solid #ffc107; background-color: #fff8e1;">
    <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-circle-fill me-2 fs-4 text-warning"></i>
        <div>
            <strong>Almost at full capacity!</strong><br>
            <small class="text-muted">
                You only have <?= number_format($availableLot, 2) ?> sqm left in your farm.
                Plan carefully before adding more crops.
            </small>
        </div>
    </div>
    <a href="<?= $base_url; ?>user/farmer/profile/profile.php"
       class="btn btn-sm btn-warning fw-semibold ms-3">
        View Farm
    </a>
</div>

<?php elseif ($availableLot <= 0 && $totalLotSize > 0) : ?>

<!-- 🔴 FULLY USED -->
<div class="alert d-flex align-items-center justify-content-between shadow-sm mb-4" 
     role="alert"
     style="border-left:5px solid #dc3545; background-color: #f8d7da;">
    <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-4 text-danger"></i>
        <div>
            <strong>Farm capacity reached!</strong><br>
            <small class="text-muted">
                You cannot add more crops. Your farm is fully utilized.
            </small>
        </div>
    </div>
</div>

<?php endif; ?>
