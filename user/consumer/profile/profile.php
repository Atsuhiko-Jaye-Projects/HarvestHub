<?php

include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/user.php";

$page_title = "Profile";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$user->id = $_SESSION['user_id'];

if($user->getUserProfileById()) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        if ($_POST['action'] == "update_profile") {

            $user->id = $_SESSION['user_id'];
            $user->user_type = $_SESSION['user_type'];
            $user->firstname = $_POST['firstname'];
            $user->lastname = $_POST['lastname'];
            $user->contact_number = $_POST['contact_number'];
            $user->address = $_POST['address'];
            $user->municipality = $_POST['municipality'];
            $user->barangay = $_POST['barangay'];
            $user->province = $_POST['province'];

            $image = !empty($_FILES["profile_pic"]["name"])
                ? sha1_file($_FILES['profile_pic']['tmp_name']) . "-" . basename($_FILES["profile_pic"]["name"])
                : "";
            $user->profile_pic = $image;

            if ($user->updateUserProfile()) {
                if ($user->uploadPhoto()) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated!',
                        text: 'Profile information has been saved successfully',
                        showConfirmButton: true
                    });
                </script>
                ";
                } else {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated!',
                            text: 'Profile information has been saved successfully',
                            showConfirmButton: true
                        });
                    </script>
                    ";
                }
            } else {
                echo "<div class='alert alert-danger'>ERROR: Profile update failed.</div>";
            }
        }
    }

    // Profile image fallback
    $profile_img = $user->profile_pic == ""
        ? "{$base_url}/user/uploads/logo.png"
        : "{$base_url}/user/uploads/profile_pictures/{$_SESSION['user_type']}/{$_SESSION['user_id']}/{$user->profile_pic}";
?>

<div class="container py-4">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px;height:80px;">
                            <img id="currentProfilePic" src="<?= $profile_img ?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;" alt="User Avatar">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1 text-capitalize"><?= htmlspecialchars($user->firstname) . ", " . htmlspecialchars($user->lastname) ?></h5>
                        </div>
                    </div>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-fill"></i> Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row g-3">
        <!-- Personal Info -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm">
                <div class="card-header"><h5>Personal Information</h5></div>
                <div class="card-body">
                    <p><strong>Full Name:</strong> <?= htmlspecialchars($user->firstname) . ", " . htmlspecialchars($user->lastname) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user->email_address) ?></p>
                    <p><strong>Contact Number:</strong> <?= !empty($user->contact_number) ? htmlspecialchars($user->contact_number) : 'Not Set' ?></p>
                </div>
            </div>
        </div>

        <!-- Address Info -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm">
                <div class="card-header"><h5>Address Information</h5></div>
                <div class="card-body">
                    <p><strong>Street / Purok:</strong> <?= !empty($user->address) ? htmlspecialchars($user->address) : 'Not Set' ?></p>
                    <p><strong>Barangay:</strong> <?= !empty($user->barangay) ? htmlspecialchars($user->barangay) : 'Not Set' ?></p>
                    <p><strong>Municipality:</strong> <?= !empty($user->municipality) ? htmlspecialchars($user->municipality) : 'Not Set' ?></p>
                    <p><strong>Province:</strong> <?= !empty($user->province) ? htmlspecialchars($user->province) : 'Not Set' ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editProfileForm" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Picture -->
                    <div class="mb-3 text-center">
                        <label class="form-label">Profile Picture</label>
                        <div class="mb-2">
                            <img id="profilePreview" src="<?= $profile_img ?>" alt="Profile Picture" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                        </div>
                        <input type="file" name="profile_pic" class="form-control" accept="image/*" id="profilePicInput">
                        <small class="text-muted">Choose a profile picture to preview (not saved yet).</small>
                    </div>

                    <!-- Name & Contact -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($user->firstname) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($user->lastname) ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email_address" class="form-control" value="<?= htmlspecialchars($user->email_address) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" class="form-control"
                               value="<?= !empty($user->contact_number) ? htmlspecialchars($user->contact_number) : '09' ?>"
                               pattern="[0-9]{11}"
                               maxlength="11"
                               inputmode="numeric"
                               title="Contact number must be 11 digits" required>
                    </div>

                    <!-- Complete Address -->
                    <div class="mb-3">
                        <label>Shipping Information</label>
                        <hr>
                        <?php if (empty($user->province)) : ?>
                            <select class="form-select mb-2" id="province"></select>
                            <select class="form-select mb-2" id="municipality"></select>
                            <select class="form-select mb-2" id="barangay"></select>

                            <input type="hidden" name="province" id="province_name">
                            <input type="hidden" name="municipality" id="municipality_name">
                            <input type="hidden" name="barangay" id="barangay_name">
                        <?php else: ?>
                            <input type="text" name="province" class="form-control mb-2" value="<?= htmlspecialchars($user->province) ?>" readonly>
                            <input type="text" name="municipality" class="form-control mb-2" value="<?= htmlspecialchars($user->municipality) ?>" readonly>
                            <input type="text" name="barangay" class="form-control mb-2" value="<?= htmlspecialchars($user->barangay) ?>" readonly>
                        <?php endif; ?>

                        <input type="text" name="address" class="form-control mb-2" placeholder="Street / Purok" value="<?= !empty($user->address) ? htmlspecialchars($user->address) : 'Not Set' ?>">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Preview image
    $('#profilePicInput').on('change', function() {
        const [file] = this.files;
        if(file) {
            const reader = new FileReader();
            reader.onload = e => $('#profilePreview').attr('src', e.target.result);
            reader.readAsDataURL(file);
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const provinceSelect = document.getElementById("province");
    if(!provinceSelect) return;

    const municipalitySelect = document.getElementById("municipality");
    const barangaySelect = document.getElementById("barangay");
    const provinceInput = document.getElementById("province_name");
    const municipalityInput = document.getElementById("municipality_name");
    const barangayInput = document.getElementById("barangay_name");

    // Load provinces
    fetch("https://psgc.gitlab.io/api/provinces/")
    .then(res => res.json())
    .then(data => {
        provinceSelect.innerHTML = "<option disabled selected>Select Province</option>";
        data.forEach(province => {
            const option = document.createElement("option");
            option.value = province.code;
            option.textContent = province.name;
            option.dataset.name = province.name;
            provinceSelect.appendChild(option);
        });
    });

    provinceSelect.addEventListener("change", function() {
        const selectedOption = this.selectedOptions[0];
        if(provinceInput) provinceInput.value = selectedOption.dataset.name;

        const provinceCode = this.value;
        if(municipalitySelect) municipalitySelect.innerHTML = "<option selected disabled>Loading...</option>";
        if(barangaySelect) barangaySelect.innerHTML = "<option selected disabled>Select Municipality First</option>";

        fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`)
        .then(res => res.json())
        .then(data => {
            if(municipalitySelect){
                municipalitySelect.innerHTML = "<option selected disabled>Select Municipality</option>";
                data.forEach(muni => {
                    const option = document.createElement("option");
                    option.value = muni.code;
                    option.textContent = muni.name;
                    option.dataset.name = muni.name;
                    municipalitySelect.appendChild(option);
                });
            }
        });
    });

    if(municipalitySelect){
        municipalitySelect.addEventListener("change", function() {
            const selectedOption = this.selectedOptions[0];
            if(municipalityInput) municipalityInput.value = selectedOption.dataset.name;

            const muniCode = this.value;
            if(barangaySelect) barangaySelect.innerHTML = "<option selected disabled>Loading...</option>";

            fetch(`https://psgc.gitlab.io/api/cities-municipalities/${muniCode}/barangays/`)
            .then(res => res.json())
            .then(data => {
                if(barangaySelect){
                    barangaySelect.innerHTML = "<option selected disabled>Select Barangay</option>";
                    data.forEach(barangay => {
                        const option = document.createElement("option");
                        option.value = barangay.code;
                        option.textContent = barangay.name;
                        option.dataset.name = barangay.name;
                        barangaySelect.appendChild(option);
                    });
                }
            });
        });
    }

    if(barangaySelect){
        barangaySelect.addEventListener("change", function() {
            const selectedOption = this.selectedOptions[0];
            if(barangayInput) barangayInput.value = selectedOption.dataset.name;
        });
    }
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>
