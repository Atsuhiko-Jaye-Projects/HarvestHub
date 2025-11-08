<?php
include_once "../../../config/core.php";


$page_title = "Profile";
include_once "../layout/layout_head.php";
print_r($_SESSION);

$require_login = true;
include_once "../../../login_checker.php";
?>

<div class="container py-4">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <img id="profilePreview" src="../../../libs/images/logo.png" style="width:80px; height:80px; border-radius:50%; object-fit:cover;" alt="User Avatar">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1 text-capitalize"><?php echo $_SESSION['lastname'] . ", " . $_SESSION['firstname']; ?></h5>
                            <small><?php echo $_SESSION['user_type']; ?></small>
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
                <div class="card-header d-flex justify-content-between">
                    <h5>Personal Information</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit
                    </button>
                </div>
                <div class="card-body">
                    <p><strong>Full Name:</strong> <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></p>
                    <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                    <p><strong>Contact Number:</strong> <?php echo $_SESSION['contact_number']; ?></p>
                    <p><strong>Address:</strong> <?php echo $_SESSION['street'] . ", " . $_SESSION['barangay'] . ", " . $_SESSION['municipality'] . ", " . $_SESSION['province']; ?></p>
                </div>
            </div>
        </div>

        <!-- Farm Info -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between">
                    <h5>Farm Information</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editFarmModal">
                        Edit
                    </button>
                </div>
                <div class="card-body">
                    <p><strong>Farm Name:</strong> <?php echo $_SESSION['farm_name'] ?? '-'; ?></p>
                    <p><strong>Farm Size:</strong> <?php echo $_SESSION['farm_size'] ?? '-'; ?> sqm</p>
                    <p><strong>Farm Type:</strong> <?php echo $_SESSION['farm_type'] ?? '-'; ?></p>
                    <p><strong>Farm Location:</strong> <?php echo $_SESSION['farm_location'] ?? '-'; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editProfileForm" enctype="multipart/form-data">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <label class="form-label">Profile Picture</label>
                        <div class="mb-2">
                            <img id="profileModalPreview" src="../../../libs/images/logo.png" class="rounded-circle" style="width:100px;height:100px;object-fit:cover;">
                        </div>
                        <input type="file" name="profile_pic" class="form-control" accept="image/*" id="profilePicInput">
                    </div>
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $_SESSION['firstname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $_SESSION['lastname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" value="<?php echo $_SESSION['contact_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" name="street" class="form-control mb-2" placeholder="Street / Purok" value="<?php echo $_SESSION['street'] ?? ''; ?>">
                        <input type="text" name="barangay" class="form-control mb-2" placeholder="Barangay" value="<?php echo $_SESSION['barangay'] ?? ''; ?>">
                        <input type="text" name="municipality" class="form-control mb-2" placeholder="Municipality" value="<?php echo $_SESSION['municipality'] ?? ''; ?>">
                        <input type="text" name="province" class="form-control" placeholder="Province" value="<?php echo $_SESSION['province'] ?? ''; ?>">
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

<!-- Optional Farm Edit Modal -->
<div class="modal fade" id="editFarmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editFarmForm">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Farm Info</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Farm Name</label>
                        <input type="text" name="farm_name" class="form-control" value="<?php echo $_SESSION['farm_name'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label>Farm Size (sqm)</label>
                        <input type="number" name="farm_size" class="form-control" value="<?php echo $_SESSION['farm_size'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label>Farm Type</label>
                        <select name="farm_type" class="form-select">
                            <option value="">Select type</option>
                            <option value="Vegetable" <?php if(($_SESSION['farm_type'] ?? '')=='Vegetable') echo 'selected'; ?>>Vegetable</option>
                            <option value="Fruit" <?php if(($_SESSION['farm_type'] ?? '')=='Fruit') echo 'selected'; ?>>Fruit</option>
                            <option value="Livestock" <?php if(($_SESSION['farm_type'] ?? '')=='Livestock') echo 'selected'; ?>>Livestock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Farm Location</label>
                        <input type="text" name="farm_location" class="form-control" value="<?php echo $_SESSION['farm_location'] ?? ''; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Farm Info</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Profile picture preview
    $('#profilePicInput').on('change', function() {
        const [file] = this.files;
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').attr('src', e.target.result);
                $('#profileModalPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>
