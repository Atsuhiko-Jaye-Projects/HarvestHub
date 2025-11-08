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
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px;height:80px;">
                            <img id="currentProfilePic" src="../../../libs/images/logo.png" 
                                 style="width:80px;height:80px;border-radius:50%;object-fit:cover;" alt="User Avatar">
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
                <div class="card-header"><h5>Personal Information</h5></div>
                <div class="card-body">
                    <p><strong>Full Name:</strong> <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?></p>
                    <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                    <p><strong>Contact Number:</strong> <?php echo $_SESSION['contact_number']; ?></p>
                </div>
            </div>
        </div>

        <!-- Address Info -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm">
                <div class="card-header"><h5>Address Information</h5></div>
                <div class="card-body">
                    <p><strong>Street / Purok:</strong> <?php echo $_SESSION['street'] ?? '-'; ?></p>
                    <p><strong>Barangay:</strong> <?php echo $_SESSION['barangay'] ?? '-'; ?></p>
                    <p><strong>Municipality:</strong> <?php echo $_SESSION['municipality'] ?? '-'; ?></p>
                    <p><strong>Province:</strong> <?php echo $_SESSION['province'] ?? '-'; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editProfileForm" enctype="multipart/form-data">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Picture -->
                    <div class="mb-3 text-center">
                        <label class="form-label">Profile Picture</label>
                        <div class="mb-2">
                            <img id="profilePreview" src="../../../libs/images/logo.png" 
                                 alt="Profile Picture" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                        </div>
                        <input type="file" name="profile_pic" class="form-control" accept="image/*" id="profilePicInput">
                        <small class="text-muted">Choose a profile picture to preview (not saved yet).</small>
                    </div>

                    <!-- Name & Contact -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" 
                                   value="<?php echo $_SESSION['firstname']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" 
                                   value="<?php echo $_SESSION['lastname']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" 
                               value="<?php echo $_SESSION['contact_number']; ?>" required>
                    </div>

                    <!-- Complete Address -->
                    <div class="mb-3">
                        <label>Complete Address</label>
                        <input type="text" name="street" class="form-control mb-2" placeholder="Street / Purok" 
                               value="<?php echo $_SESSION['street'] ?? ''; ?>">
                        <select name="barangay" class="form-select mb-2" required>
                            <option value="">Select Barangay</option>
                            <option value="Barangay 1" <?php if(($_SESSION['barangay'] ?? '')=='Barangay 1') echo 'selected';?>>Barangay 1</option>
                            <option value="Barangay 2" <?php if(($_SESSION['barangay'] ?? '')=='Barangay 2') echo 'selected';?>>Barangay 2</option>
                        </select>
                        <select name="municipality" class="form-select mb-2" required>
                            <option value="">Select Municipality</option>
                            <option value="Municipality A" <?php if(($_SESSION['municipality'] ?? '')=='Municipality A') echo 'selected';?>>Municipality A</option>
                            <option value="Municipality B" <?php if(($_SESSION['municipality'] ?? '')=='Municipality B') echo 'selected';?>>Municipality B</option>
                        </select>
                        <select name="province" class="form-select" required>
                            <option value="">Select Province</option>
                            <option value="Marinduque" <?php if(($_SESSION['province'] ?? '')=='Marinduque') echo 'selected';?>>Marinduque</option>
                        </select>
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

<script>
$(document).ready(function() {
    // Preview selected image immediately
    $('#profilePicInput').on('change', function() {
        const [file] = this.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Submit profile form via AJAX
    $('#editProfileForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '../../../js/user/farmer/api/update_profile.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    alert('Profile updated successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('An error occurred while updating profile.');
            }
        });
    });
});
</script>

<?php include_once "../layout/layout_foot.php"; ?>
