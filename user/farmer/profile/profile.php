<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/user.php";
include_once "../../../objects/farm.php";

$page_title = "Profile Dashboard";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$farm = new Farm($db);
$user->id = $_SESSION['user_id'];

if($user->getUserProfileById()){
    $farm->user_id = $user->id;

    // --- FORM LOGIC ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        if ($_POST['action'] == "update_profile") {
            $user->firstname = $_POST['firstname'];
            $user->lastname = $_POST['lastname'];
            $user->email_address = $_POST['email']; 
            $user->contact_number = $_POST['contact_number'];
            $user->address = $_POST['address'];
            $user->province = $_POST['u_province_name'];
            $user->municipality = $_POST['u_municipality_name'];
            $user->barangay = $_POST['u_barangay_name'];

            if(!empty($_FILES["profile_pic"]["name"])){
                $image = sha1_file($_FILES['profile_pic']['tmp_name']) . "-" . basename($_FILES["profile_pic"]["name"]);
                $user->profile_pic = $image;
            }
            if ($user->updateUserProfile()) {
                if(!empty($_FILES["profile_pic"]["name"])) { $user->uploadPhoto(); }
                $_SESSION['flash'] = ['title' => 'Profile Updated', 'text' => 'Account details saved successfully.', 'icon' => 'success'];
            }
        }
        if ($_POST['action'] == "update_farm_info") {
            $farm->lot_size = $_POST['farm_size'];
            $farm->farm_name = $_POST['farm_name'];
            $farm->province = $_POST['province_name'];
            $farm->municipality = $_POST['municipality_name'];
            $farm->baranggay = $_POST['barangay_name'];
            $farm->purok = $_POST['purok'];
            if ($farm->updateFarmDetail()) {
                $_SESSION['flash'] = ['title' => 'Farm Saved!', 'text' => 'Farm infrastructure data updated.', 'icon' => 'success'];
            }
        }
    }
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
    :root { --p-green: #10b981; --d-green: #064e3b; --slate: #0f172a; --soft: #f8fafc; }
    
    body { background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif; }
    .main-card { background: white; border-radius: 35px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.03); }
    
    /* Header Section */
    .hero-box { background: linear-gradient(135deg, var(--d-green) 0%, var(--p-green) 100%); padding: 4rem 3rem; color: white; }
    .avatar-wrapper { width: 140px; height: 140px; border-radius: 40px; border: 6px solid rgba(255,255,255,0.2); background: white; overflow: hidden; }
    .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .label-caps { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; font-weight: 800; }
    
    /* Tiles & Details */
    .info-box { background: #f8fafc; border: 1px solid #eef2f6; border-radius: 20px; padding: 1.5rem; }
    .stat-tile { background: white; border: 1px solid #f1f5f9; border-radius: 20px; padding: 1.2rem; text-align: center; transition: 0.3s; }
    .stat-tile:hover { border-color: var(--p-green); transform: translateY(-3px); }
    
    .farm-icon-text { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-weight: 600; color: #475569; }
    .farm-icon-text i { color: var(--p-green); font-size: 1.1rem; }

    .btn-glass { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; backdrop-filter: blur(10px); border-radius: 15px; padding: 10px 20px; font-weight: 700; }
    .btn-glass:hover { background: white; color: var(--d-green); }
</style>

<div class="container py-5">
    <div class="main-card shadow-sm">
        <div class="hero-box d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4 text-center text-md-start">
                <div class="avatar-wrapper shadow-lg">
                    <img id="profilePreview" src="../../uploads/profile_pictures/<?="/".$_SESSION['user_id']."/".$user->profile_pic;?>">
                </div>
                <div>
                    <span class="badge bg-white text-success rounded-pill px-3 py-2 mb-2 fw-bold shadow-sm">Verified Account</span>
                    <h1 class="fw-800 mb-1" style="font-weight: 800;"><?= htmlspecialchars($user->firstname . " " . $user->lastname) ?></h1>
                    <p class="opacity-75 mb-0"><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($user->barangay . ", " . $user->municipality) ?></p>
                </div>
            </div>
            <button class="btn btn-glass mt-4 mt-md-0" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-person-gear me-2"></i>Account Settings
            </button>
        </div>

        <div class="p-4 p-md-5">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="info-box shadow-sm mb-4">
                        <h6 class="fw-bold mb-4">Contact Details</h6>
                        <div class="mb-3">
                            <span class="label-caps d-block mb-1">Email Address</span>
                            <div class="fw-bold text-break"><?= $user->email_address ?></div>
                        </div>
                        <div class="mb-3">
                            <span class="label-caps d-block mb-1">Contact Number</span>
                            <div class="fw-bold"><?= $user->contact_number ?></div>
                        </div>
                        <div class="mb-0">
                            <span class="label-caps d-block mb-1">Permanent Address</span>
                            <div class="fw-bold"><?= htmlspecialchars($user->address . ", " . $user->barangay . ", " . $user->municipality . ", " . $user->province) ?></div>
                        </div>
                    </div>
                    
                    <div class="p-4 rounded-4 bg-success text-white">
                        <h6 class="fw-bold mb-2"><i class="bi bi-lightning-charge"></i> Quick Tip</h6>
                        <p class="small opacity-90 m-0">Keep your farm lot size updated to receive more accurate marketplace recommendations.</p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-800 m-0">Farm Infrastructure</h4>
                        <button class="btn btn-sm btn-outline-success rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#editFarmModal">Edit Farm</button>
                    </div>

                    <?php if ($farm->getFarmerDetailsById()): ?>
                        <div class="p-4 rounded-4 mb-4 border bg-white shadow-sm">
                            <h5 class="fw-bold text-success mb-3"><?= htmlspecialchars($farm->farm_name) ?></h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="farm-icon-text"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($farm->province) ?></div>
                                    <div class="farm-icon-text"><i class="bi bi-map"></i> <?= htmlspecialchars($farm->municipality) ?></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="farm-icon-text"><i class="bi bi-house-door"></i> Brgy. <?= htmlspecialchars($farm->baranggay) ?></div>
                                    <div class="farm-icon-text"><i class="bi bi-signpost-split"></i> <?= htmlspecialchars($farm->purok) ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-4">
                                <div class="stat-tile shadow-sm">
                                    <span class="label-caps text-primary">Total Size</span>
                                    <div class="h4 fw-bold mb-0"><?= number_format($farm->lot_size) ?> <small class="fs-6 opacity-50">m²</small></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-tile shadow-sm">
                                    <span class="label-caps text-danger">Utilized</span>
                                    <div class="h4 fw-bold mb-0 text-danger"><?= number_format($farm->used_lot_size ?? 0) ?> <small class="fs-6 opacity-50">m²</small></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-tile shadow-sm bg-success bg-opacity-10 border-success">
                                    <span class="label-caps text-success">Available</span>
                                    <div class="h4 fw-bold mb-0 text-success"><?= number_format($farm->lot_size - ($farm->used_lot_size ?? 0)) ?> <small class="fs-6 opacity-50">m²</small></div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 rounded-4 border-dashed" style="border: 2px dashed #cbd5e1; background: #f8fafc;">
                            <i class="bi bi-plus-circle-dotted fs-1 text-muted mb-3 d-block"></i>
                            <h5 class="fw-bold">No Farm Profile Yet</h5>
                            <p class="text-muted small mb-4">Add your farm location and size to start tracking.</p>
                            <button class="btn btn-success rounded-pill px-5 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#editFarmModal">Register Farm Now</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <input type="hidden" name="u_province_name" id="u_province_name" value="<?= $user->province ?>">
                <input type="hidden" name="u_municipality_name" id="u_municipality_name" value="<?= $user->municipality ?>">
                <input type="hidden" name="u_barangay_name" id="u_barangay_name" value="<?= $user->barangay ?>">
                
                <div class="modal-header border-0 p-4"><h5 class="fw-bold m-0">Edit Profile</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body p-4 pt-0">
                    <div class="row g-3">
                        <div class="col-6"><label class="label-caps">First Name</label><input type="text" name="firstname" class="form-control rounded-3" value="<?= $user->firstname ?>" required></div>
                        <div class="col-6"><label class="label-caps">Last Name</label><input type="text" name="lastname" class="form-control rounded-3" value="<?= $user->lastname ?>" required></div>
                        <div class="col-12"><label class="label-caps">Street Address</label><input type="text" name="address" class="form-control rounded-3" value="<?= $user->address ?>"></div>
                        <div class="col-4"><label class="label-caps">Province</label><select id="u-province" class="form-select rounded-3"></select></div>
                        <div class="col-4"><label class="label-caps">Town</label><select id="u-municipality" class="form-select rounded-3"></select></div>
                        <div class="col-4"><label class="label-caps">Barangay</label><select id="u-barangay" class="form-select rounded-3"></select></div>
                        <div class="col-12 mt-3"><label class="label-caps">Profile Photo</label><input type="file" name="profile_pic" class="form-control rounded-3"></div>
                        <input type="hidden" name="email" value="<?= $user->email_address ?>"><input type="hidden" name="contact_number" value="<?= $user->contact_number ?>">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4"><button type="submit" class="btn btn-success w-100 py-3 rounded-4 fw-bold shadow">Apply Account Changes</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editFarmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="action" value="update_farm_info">
                <input type="hidden" name="province_name" id="f_province_name" value="<?= $farm->province ?>">
                <input type="hidden" name="municipality_name" id="f_municipality_name" value="<?= $farm->municipality ?>">
                <input type="hidden" name="barangay_name" id="f_barangay_name" value="<?= $farm->baranggay ?>">
                
                <div class="modal-header border-0 p-4"><h5 class="fw-bold m-0 text-success">Farm Profile</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3"><label class="label-caps">Farm Brand Name</label><input type="text" name="farm_name" class="form-control rounded-3" value="<?= $farm->farm_name ?>" placeholder="e.g., Happy Farm" required></div>
                    <div class="mb-3"><label class="label-caps">Total Land Size (sqm)</label><input type="number" name="farm_size" class="form-control rounded-3" value="<?= $farm->lot_size ?>" required></div>
                    <div class="row g-2">
                        <div class="col-12"><select id="f-province" class="form-select rounded-3"><option value="">Select Province</option></select></div>
                        <div class="col-6"><select id="f-municipality" class="form-select rounded-3"><option value="">Select Town</option></select></div>
                        <div class="col-6"><select id="f-barangay" class="form-select rounded-3"><option value="">Select Barangay</option></select></div>
                        <div class="col-12 mt-2"><input type="text" name="purok" class="form-control rounded-3" placeholder="Purok/Street Name" value="<?= $farm->purok ?>"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4"><button type="submit" class="btn btn-success w-100 py-3 rounded-4 fw-bold">Save Farm Settings</button></div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    function setupPSGC(prefix) {
        const provS = $(`#${prefix}-province`), cityS = $(`#${prefix}-municipality`), brgyS = $(`#${prefix}-barangay`);
        const provI = $(`#${prefix}_province_name`), cityI = $(`#${prefix}_municipality_name`), brgyI = $(`#${prefix}_barangay_name`);

        fetch("https://psgc.gitlab.io/api/provinces/").then(r => r.json()).then(data => {
            provS.append('<option value="">Select Province</option>');
            data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(p => {
                provS.append(`<option value="${p.code}" data-name="${p.name}">${p.name}</option>`);
            });
        });

        provS.change(function() {
            provI.val($(this).find(':selected').data('name'));
            cityS.html('<option>Loading...</option>');
            fetch(`https://psgc.gitlab.io/api/provinces/${this.value}/cities-municipalities/`).then(r => r.json()).then(data => {
                cityS.html('<option value="">Select Town</option>');
                data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(m => {
                    cityS.append(`<option value="${m.code}" data-name="${m.name}">${m.name}</option>`);
                });
            });
        });

        cityS.change(function() {
            cityI.val($(this).find(':selected').data('name'));
            brgyS.html('<option>Loading...</option>');
            fetch(`https://psgc.gitlab.io/api/cities-municipalities/${this.value}/barangays/`).then(r => r.json()).then(data => {
                brgyS.html('<option value="">Select Barangay</option>');
                data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(b => {
                    brgyS.append(`<option value="${b.code}" data-name="${b.name}">${b.name}</option>`);
                });
            });
        });
        brgyS.change(function(){ brgyI.val($(this).find(':selected').data('name')); });
    }

    setupPSGC('u'); // Account
    setupPSGC('f'); // Farm
});
</script>

<?php if(isset($_SESSION['flash'])): ?>
<script>Swal.fire({ title: "<?= $_SESSION['flash']['title'] ?>", text: "<?= $_SESSION['flash']['text'] ?>", icon: "<?= $_SESSION['flash']['icon'] ?>", timer: 2000, showConfirmButton: false });</script>
<?php unset($_SESSION['flash']); endif; ?>

<?php } include_once "../layout/layout_foot.php"; ?>