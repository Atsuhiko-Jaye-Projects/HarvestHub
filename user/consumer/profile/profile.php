<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/user.php";

$page_title = "User Profile";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$user->id = $_SESSION['user_id'];

if($user->getUserProfileById()) {
    // --- POST LOGIC ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        if ($_POST['action'] == "update_profile") {
            $user->firstname = $_POST['firstname'];
            $user->lastname = $_POST['lastname'];
            $user->contact_number = $_POST['contact_number'];
            $user->address = $_POST['address'];
            $user->municipality = $_POST['municipality'];
            $user->barangay = $_POST['barangay'];
            $user->province = $_POST['province'];

            $image = !empty($_FILES["profile_pic"]["name"])
                ? sha1_file($_FILES['profile_pic']['tmp_name']) . "-" . basename($_FILES["profile_pic"]["name"])
                : $user->profile_pic;
            
            $user->profile_pic = $image;

            if ($user->updateUserProfile()) {
                if(!empty($_FILES["profile_pic"]["name"])) { $user->uploadPhoto(); }
                $_SESSION['flash'] = ['icon' => 'success', 'title' => 'Profile Updated!', 'text' => 'Information saved successfully.'];
            }
        }
    }

    $profile_img = $user->profile_pic == ""
        ? "{$base_url}/user/uploads/logo.png"
        : "{$base_url}/user/uploads/profile_pictures/{$_SESSION['user_type']}/{$_SESSION['user_id']}/{$user->profile_pic}";
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
    :root { --p-green: #10b981; --d-green: #064e3b; --slate: #0f172a; --soft-bg: #f8fafc; }
    
    body { background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--slate); }
    .main-wrapper { background: white; border-radius: 35px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.03); margin-top: 2rem; }
    
    .hero-banner { background: linear-gradient(135deg, var(--d-green) 0%, var(--p-green) 100%); padding: 4rem 3rem; color: white; }
    .avatar-lg { width: 140px; height: 140px; border-radius: 40px; border: 6px solid rgba(255,255,255,0.2); background: white; object-fit: cover; }
    
    .label-sm { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; font-weight: 800; margin-bottom: 0.5rem; display: block; }
    .info-value { font-weight: 700; font-size: 1.1rem; color: var(--slate); }
    .card-tile { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 20px; padding: 2rem; height: 100%; transition: 0.3s; }
    .card-tile:hover { border-color: var(--p-green); transform: translateY(-5px); }
    
    .btn-action { border-radius: 12px; padding: 12px 24px; font-weight: 700; transition: all 0.3s; }
    .btn-glass { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; backdrop-filter: blur(10px); }
    .btn-glass:hover { background: white; color: var(--d-green); }
</style>

<div class="container py-4">
    <div class="main-wrapper shadow-sm">
        <div class="hero-banner d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <img src="<?= $profile_img ?>" class="avatar-lg shadow-lg">
                <div>
                    <span class="badge bg-white text-success rounded-pill px-3 py-2 mb-2 fw-bold shadow-sm">Verified Account</span>
                    <h1 class="fw-800 mb-1" style="font-weight: 800;"><?= htmlspecialchars($user->firstname . " " . $user->lastname) ?></h1>
                    <p class="opacity-75 mb-0"><i class="bi bi-person-badge me-1"></i> HH-2026-<?= $_SESSION['user_id'] ?></p>
                </div>
            </div>
            <button class="btn btn-action btn-glass mt-4 mt-md-0" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-pencil-square me-2"></i>Account Settings
            </button>
        </div>

        <div class="p-4 p-md-5">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card-tile shadow-sm">
                        <div class="d-flex align-items-center mb-4 text-success">
                            <i class="bi bi-person-vcard fs-4 me-2"></i>
                            <h5 class="m-0 fw-bold">Contact Details</h5>
                        </div>
                        <div class="mb-4">
                            <span class="label-sm">Email Address</span>
                            <div class="info-value text-break"><?= htmlspecialchars($user->email_address) ?></div>
                        </div>
                        <div class="mb-0">
                            <span class="label-sm">Contact Number</span>
                            <div class="info-value"><?= !empty($user->contact_number) ? htmlspecialchars($user->contact_number) : 'Not Provided' ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-tile shadow-sm">
                        <div class="d-flex align-items-center mb-4 text-success">
                            <i class="bi bi-geo-alt-fill fs-4 me-2"></i>
                            <h5 class="m-0 fw-bold">Location Information</h5>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-4">
                                <span class="label-sm">Province</span>
                                <div class="info-value"><?= htmlspecialchars($user->province ?? 'N/A') ?></div>
                            </div>
                            <div class="col-6 mb-4">
                                <span class="label-sm">Municipality</span>
                                <div class="info-value"><?= htmlspecialchars($user->municipality ?? 'N/A') ?></div>
                            </div>
                            <div class="col-12">
                                <span class="label-sm">Full Address</span>
                                <div class="info-value"><?= htmlspecialchars($user->address . ", " . $user->barangay) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 mt-2">
                    <div class="p-3 bg-light rounded-4 d-flex align-items-center">
                        <i class="bi bi-info-circle-fill text-primary me-3 fs-5"></i>
                        <span class="small text-muted">Please ensure your contact details are updated so our farmers can reach you easily.</span>
                    </div>
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
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-800 m-0">Edit Account Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="profilePreview" src="<?= $profile_img ?>" class="rounded-4 shadow mb-2" style="width:120px;height:120px;object-fit:cover; border: 4px solid #f8fafc;">
                        </div>
                        <div class="mt-2 mx-auto" style="max-width: 300px;">
                            <label class="label-sm">Update Profile Photo</label>
                            <input type="file" name="profile_pic" class="form-control form-control-sm" id="profilePicInput" accept="image/*">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="label-sm">First Name</label><input type="text" name="firstname" class="form-control rounded-3" value="<?= $user->firstname ?>" required></div>
                        <div class="col-md-6"><label class="label-sm">Last Name</label><input type="text" name="lastname" class="form-control rounded-3" value="<?= $user->lastname ?>" required></div>
                        <div class="col-12"><label class="label-sm">Contact Number</label><input type="text" name="contact_number" class="form-control rounded-3" value="<?= $user->contact_number ?>" maxlength="11" required></div>
                        <div class="col-md-4"><label class="label-sm">Province</label><select class="form-select rounded-3" id="province"></select></div>
                        <div class="col-md-4"><label class="label-sm">Municipality</label><select class="form-select rounded-3" id="municipality"></select></div>
                        <div class="col-md-4"><label class="label-sm">Barangay</label><select class="form-select rounded-3" id="barangay"></select></div>
                        
                        <input type="hidden" name="province" id="province_name">
                        <input type="hidden" name="municipality" id="municipality_name">
                        <input type="hidden" name="barangay" id="barangay_name">
                        
                        <div class="col-12"><label class="label-sm">Street / House No.</label><input type="text" name="address" class="form-control rounded-3" placeholder="Street/Purok" value="<?= $user->address ?>"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-success btn-action w-100 shadow-sm">Save Profile Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#profilePicInput').change(function() {
        const file = this.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = e => $('#profilePreview').attr('src', e.target.result);
            reader.readAsDataURL(file);
        }
    });

    const provS = document.getElementById("province");
    if(provS) {
        const cityS = document.getElementById("municipality"), brgyS = document.getElementById("barangay");
        const provI = document.getElementById("province_name"), cityI = document.getElementById("municipality_name"), brgyI = document.getElementById("barangay_name");
        
        fetch("https://psgc.gitlab.io/api/provinces/").then(res => res.json()).then(data => {
            provS.innerHTML = "<option disabled selected>Select Province</option>";
            data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(p => {
                const opt = new Option(p.name, p.code); opt.dataset.name = p.name; provS.add(opt);
            });
        });

        provS.addEventListener("change", function() {
            provI.value = this.selectedOptions[0].dataset.name;
            fetch(`https://psgc.gitlab.io/api/provinces/${this.value}/cities-municipalities/`).then(res => res.json()).then(data => {
                cityS.innerHTML = "<option selected disabled>Select Town</option>";
                data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(m => {
                    const opt = new Option(m.name, m.code); opt.dataset.name = m.name; cityS.add(opt);
                });
            });
        });

        cityS.addEventListener("change", function() {
            cityI.value = this.selectedOptions[0].dataset.name;
            fetch(`https://psgc.gitlab.io/api/cities-municipalities/${this.value}/barangays/`).then(res => res.json()).then(data => {
                brgyS.innerHTML = "<option selected disabled>Select Brgy</option>";
                data.sort((a,b)=>a.name.localeCompare(b.name)).forEach(b => {
                    const opt = new Option(b.name, b.code); opt.dataset.name = b.name; brgyS.add(opt);
                });
            });
        });
        brgyS.addEventListener("change", function() { brgyI.value = this.selectedOptions[0].dataset.name; });
    }
});
</script>

<?php if(isset($_SESSION['flash'])): ?>
<script>Swal.fire({ icon: '<?= $_SESSION['flash']['icon'] ?>', title: '<?= $_SESSION['flash']['title'] ?>', text: '<?= $_SESSION['flash']['text'] ?>', timer: 2000, showConfirmButton: false });</script>
<?php unset($_SESSION['flash']); endif; ?>

<?php } include_once "../layout/layout_foot.php"; ?>