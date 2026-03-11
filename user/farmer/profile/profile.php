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

    // --- FORM LOGIC (SAME AS BEFORE) ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        if ($_POST['action'] == "update_profile") {
            $user->firstname = $_POST['firstname'];
            $user->lastname = $_POST['lastname'];
            $user->email_address = $_POST['email']; 
            $user->contact_number = $_POST['contact_number'];
            $user->address = $_POST['address'];
            $user->municipality = $_POST['municipality'];
            $user->barangay = $_POST['barangay'];
            $user->province = $_POST['province'];
            if(!empty($_FILES["profile_pic"]["name"])){
                $image = sha1_file($_FILES['profile_pic']['tmp_name']) . "-" . basename($_FILES["profile_pic"]["name"]);
                $user->profile_pic = $image;
            }
            if ($user->updateUserProfile()) {
                if(!empty($_FILES["profile_pic"]["name"])) { $user->uploadPhoto(); }
                $_SESSION['flash'] = ['title' => 'Profile Updated', 'text' => 'Your information is now up to date.', 'icon' => 'success'];
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
                $_SESSION['flash'] = ['title' => 'Farm Updated!', 'text' => 'Farm infrastructure data saved.', 'icon' => 'success'];
            }
        }
    }
?>

<style>
    :root {
        --primary-green: #10b981;
        --deep-green: #059669;
        --soft-bg: #f1f5f9;
    }

    body { background-color: var(--soft-bg); font-family: 'Inter', sans-serif; overflow-x: hidden; }

    /* --- CONTAINERS --- */
    .profile-card {
        background: white;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.8);
        overflow: hidden;
    }

    .header-gradient {
        background: linear-gradient(135deg, var(--deep-green) 0%, var(--primary-green) 100%);
        padding: 4rem 2rem;
        position: relative;
    }

    .profile-avatar {
        width: 120px; height: 120px;
        border: 6px solid white;
        border-radius: 35px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        background: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .profile-avatar:hover { transform: rotate(5deg) scale(1.1); }

    .stat-tile {
        background: #ffffff;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid #eef2f6;
        transition: all 0.3s ease;
        animation: float 4s ease-in-out infinite;
    }
    .stat-tile:hover {
        transform: scale(1.03);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        background: #fafcfe;
    }

    .info-label { font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
    .info-value { font-size: 1rem; font-weight: 600; color: #1e293b; }

    .status-active { width: 10px; height: 10px; background: #22c55e; border-radius: 50%; display: inline-block; margin-right: 5px; box-shadow: 0 0 10px #22c55e; }

    .btn-edit {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        border-radius: 15px;
        padding: 10px 25px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-edit:hover { background: white; color: var(--deep-green); }
</style>

<div class="container py-5">
    <div class="profile-card animate-in">
        <div class="header-gradient d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <div class="profile-avatar">
                    <img id="profilePreview" src="../../uploads/profile_pictures/<?= $_SESSION['user_type']."/".$_SESSION['user_id']."/".$user->profile_pic;?>" style="width:100%; height:100%; object-fit:cover; border-radius:30px;">
                </div>
                <div class="text-white">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-1">
                        <span class="status-active"></span>
                        <span class="small fw-bold opacity-75">Active Now</span>
                    </div>
                    <h1 class="fw-bold mb-0"><?= htmlspecialchars($user->firstname . " " . $user->lastname) ?></h1>
                    <p class="opacity-75 m-0"><?= strtoupper($_SESSION['user_type']) ?> &bull; Harvest Hub Member</p>
                </div>
            </div>
            <div class="mt-4 mt-md-0">
                <button class="btn-edit shadow-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-person-gear me-2"></i>Account Settings
                </button>
            </div>
        </div>

        <div class="p-4 p-md-5">
            <div class="row g-4">
                <div class="col-lg-4 animate-in delay-1">
                    <div class="p-4 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="fw-bold mb-4">Contact Details</h6>
                        <div class="mb-4">
                            <span class="info-label">Email Address</span>
                            <div class="info-value text-break"><?= $user->email_address ?></div>
                        </div>
                        <div class="mb-4">
                            <span class="info-label">Contact Number</span>
                            <div class="info-value"><?= $user->contact_number ?></div>
                        </div>
                        <div class="mb-0">
                            <span class="info-label">Member Since</span>
                            <div class="info-value">March 2026</div>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-4 rounded-4 bg-success text-white">
                        <h6 class="fw-bold mb-2">Farming Tip</h6>
                        <p class="small opacity-90 m-0">"Check your crop hydration levels today. Optimal watering time is between 6:00 AM - 8:00 AM."</p>
                    </div>
                </div>

                <div class="col-lg-8 animate-in delay-2">
                    <?php if ($farm->getFarmerDetailsById()): ?>
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <div>
                                <h4 class="fw-bold m-0"><?= htmlspecialchars($farm->farm_name) ?></h4>
                                <p class="text-muted small"><i class="bi bi-geo-alt-fill me-1"></i> <?= $farm->baranggay ?>, <?= $farm->municipality ?></p>
                            </div>
                            <button class="btn btn-sm btn-outline-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#editFarmModal">Edit Farm</button>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="stat-tile text-center">
                                    <i class="bi bi-bounding-box text-primary fs-3 mb-2 d-block"></i>
                                    <span class="info-label">Total Land</span>
                                    <div class="fs-4 fw-bold text-primary"><?= number_format($farm->lot_size) ?> <span class="small opacity-50">sqm</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-tile text-center" style="animation-delay: 0.5s;">
                                    <i class="bi bi-graph-up-arrow text-danger fs-3 mb-2 d-block"></i>
                                    <span class="info-label">Land in Use</span>
                                    <div class="fs-4 fw-bold text-danger"><?= number_format($farm->used_lot_size ?? 0) ?> <span class="small opacity-50">sqm</span></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-tile text-center" style="animation-delay: 1s; background: #f0fdf4;">
                                    <i class="bi bi-check-all text-success fs-3 mb-2 d-block"></i>
                                    <span class="info-label">Available Area</span>
                                    <div class="fs-4 fw-bold text-success"><?= number_format($farm->lot_size - ($farm->used_lot_size ?? 0)) ?> <span class="small opacity-50">sqm</span></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <h6 class="fw-bold mb-3">Recent Farm Activity</h6>
                            <div class="list-group list-group-flush border-top">
                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                    <span><i class="bi bi-dot text-success fs-4"></i> Profile Details Verified</span>
                                    <span class="small text-muted">Today</span>
                                </div>
                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                    <span><i class="bi bi-dot text-success fs-4"></i> Farm Location Updated</span>
                                    <span class="small text-muted">2 days ago</span>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="text-center py-5 border-dashed rounded-4" style="border: 2px dashed #cbd5e1;">
                            <i class="bi bi-plus-circle-dotted text-muted fs-1 mb-3 d-block"></i>
                            <h5 class="fw-bold">Setup your Farm Profile</h5>
                            <p class="text-muted small mb-4">You haven't added any farm details yet. Let's get started!</p>
                            <button class="btn btn-success rounded-pill px-5 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#editFarmModal">Register My Farm</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <form id="editProfileForm" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold">Update Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="text-center mb-4">
                        <img id="profileModalPreview" src="../../uploads/profile_pictures/<?= $_SESSION['user_type']."/".$_SESSION['user_id']."/".$user->profile_pic;?>" class="rounded-circle shadow-sm" style="width:100px; height:100px; object-fit:cover; border:3px solid #eee;">
                        <div class="mt-2">
                            <label for="profilePicInput" class="btn btn-sm btn-outline-success rounded-pill">Upload New Photo</label>
                            <input type="file" name="profile_pic" id="profilePicInput" class="d-none" accept="image/*">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6"><label class="small fw-bold mb-1">First Name</label><input type="text" name="firstname" class="form-control rounded-3" value="<?= $user->firstname ?>" required></div>
                        <div class="col-6"><label class="small fw-bold mb-1">Last Name</label><input type="text" name="lastname" class="form-control rounded-3" value="<?= $user->lastname ?>" required></div>
                        <div class="col-12"><label class="small fw-bold mb-1">Email</label><input type="email" name="email" class="form-control rounded-3" value="<?= $user->email_address ?>" required></div>
                        <div class="col-12"><label class="small fw-bold mb-1">Contact</label><input type="text" name="contact_number" class="form-control rounded-3" value="<?= $user->contact_number ?>"></div>
                        <div class="col-12"><label class="small fw-bold mb-1">Street Address</label><input type="text" name="address" class="form-control rounded-3" value="<?= $user->address ?>"></div>
                        <div class="col-4"><input type="text" name="barangay" class="form-control form-control-sm rounded-3" value="<?= $user->barangay ?>" placeholder="Brgy"></div>
                        <div class="col-4"><input type="text" name="municipality" class="form-control form-control-sm rounded-3" value="<?= $user->municipality ?>" placeholder="Town"></div>
                        <div class="col-4"><input type="text" name="province" class="form-control form-control-sm rounded-3" value="<?= $user->province ?>" placeholder="Prov"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-success w-100 py-3 rounded-4 fw-bold">Apply Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editFarmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <form id="editFarmForm" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="action" value="update_farm_info">
                <input type="hidden" name="province_name" id="province_name">
                <input type="hidden" name="municipality_name" id="municipality_name">
                <input type="hidden" name="barangay_name" id="barangay_name">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold">Farm Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3"><label class="small fw-bold mb-1">Farm Name</label><input type="text" name="farm_name" class="form-control rounded-3" value="<?= $farm->farm_name ?>" placeholder="e.g. Sunny Field"></div>
                    <div class="mb-3"><label class="small fw-bold mb-1">Total Area (sqm)</label><input type="number" name="farm_size" class="form-control rounded-3" value="<?= $farm->lot_size ?>"></div>
                    <div class="row g-2">
                        <div class="col-12"><label class="small fw-bold mb-1">Province</label><select id="farm-province" class="form-select rounded-3" required><option value="">Select Province</option></select></div>
                        <div class="col-6"><label class="small fw-bold mb-1">Municipality</label><select id="farm-municipality" class="form-select rounded-3" required><option value="">Select...</option></select></div>
                        <div class="col-6"><label class="small fw-bold mb-1">Barangay</label><select id="farm-barangay" class="form-select rounded-3" required><option value="">Select...</option></select></div>
                        <div class="col-12"><label class="small fw-bold mb-1">Street/Purok</label><input type="text" name="purok" class="form-control rounded-3" value="<?= $farm->purok ?>"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-success w-100 py-3 rounded-4 fw-bold">Update Farm Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Sync Preview
    $('#profilePicInput').on('change', function() {
        const [file] = this.files;
        if(file) {
            const reader = new FileReader();
            reader.onload = e => {
                $('#profilePreview, #profileModalPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // PSGC API
    const farmModal = document.getElementById("editFarmModal");
    farmModal.addEventListener("shown.bs.modal", function () {
        const pS = $("#farm-province"), mS = $("#farm-municipality"), bS = $("#farm-barangay");
        const pI = $("#province_name"), mI = $("#municipality_name"), bI = $("#barangay_name");

        if (pS[0].options.length > 1) return;

        fetch("https://psgc.gitlab.io/api/provinces/")
            .then(r => r.json()).then(data => {
                data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(p => {
                    pS.append(`<option value="${p.code}" data-name="${p.name}">${p.name}</option>`);
                });
            });

        pS.change(function() {
            pI.val($(this).find(':selected').data('name'));
            mS.html('<option disabled selected>Loading...</option>');
            fetch(`https://psgc.gitlab.io/api/provinces/${this.value}/cities-municipalities/`)
                .then(r => r.json()).then(data => {
                    mS.html('<option disabled selected>Select Municipality</option>');
                    data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(m => {
                        mS.append(`<option value="${m.code}" data-name="${m.name}">${m.name}</option>`);
                    });
                });
        });

        mS.change(function() {
            mI.val($(this).find(':selected').data('name'));
            bS.html('<option disabled selected>Loading...</option>');
            fetch(`https://psgc.gitlab.io/api/cities-municipalities/${this.value}/barangays/`)
                .then(r => r.json()).then(data => {
                    bS.html('<option disabled selected>Select Barangay</option>');
                    data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(b => {
                        bS.append(`<option value="${b.code}" data-name="${b.name}">${b.name}</option>`);
                    });
                });
        });
        bS.change(function(){ bI.val($(this).find(':selected').data('name')); });
    });
});
</script>

<?php if(isset($_SESSION['flash'])): ?>
<script>
    Swal.fire({
        title: "<?= $_SESSION['flash']['title'] ?>",
        text: "<?= $_SESSION['flash']['text'] ?>",
        icon: "<?= $_SESSION['flash']['icon'] ?>",
        showConfirmButton: false,
        timer: 2000
    }).then(() => { window.location.href = window.location.pathname; });
</script>
<?php unset($_SESSION['flash']); endif; ?>

<?php } include_once "../layout/layout_foot.php"; ?>