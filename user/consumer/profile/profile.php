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

if($user->getUserProfileById()){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    if ($_POST['action'] == "update_profile") {
        
        $user->id = $_SESSION['user_id'];
        $user->user_type = $_SESSION['user_type'];
        $user->firstname = $_POST['firstname'];
        $user->profile_pic = $_POST['profile_pic'] ?? null;
        $user->lastname = $_POST['lastname'];
        $user->contact_number = $_POST['contact_number'];
        $user->address = $_POST['address'];
        $user->municipality = $_POST['municipality'];
        $user->barangay = $_POST['barangay'];
        $user->province = $_POST['province'];

        $image=!empty($_FILES["profile_pic"]["name"])
        ? sha1_file($_FILES['profile_pic']['tmp_name']) . "-" . basename($_FILES["profile_pic"]["name"]) : "";
        $user->profile_pic = $image;


        if ($user->updateUserProfile()) {
            if ($user->uploadPhoto()) {
                echo "<div class = 'alert alert-success'>Profile has been updated</div>";
            }else{
                echo "<div class = 'alert alert-warning'>Profile has been updated</div>"; 
            }
        }else{
            echo "<div class = 'alert alert-danger'>ERROR: Profile update failed.</div>";
        }
    }
    }

    // check the image to not show broken image
    $profile_image = "";
    $raw_image = $user->profile_pic;

    if ($user->profile_pic == "") {
        $profile_img = "{$base_url}/user/uploads/logo.png";
    }else{
        $profile_img = "{$base_url}/user/uploads/profile_pictures/{$_SESSION['user_type']}/{$_SESSION['user_id']}/{$raw_image}";
    }
?>

<div class="container py-4">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px;height:80px;">
                            <img id="currentProfilePic" src="<?php echo $profile_img; ?>" 
                                 style="width:80px;height:80px;border-radius:50%;object-fit:cover;" alt="User Avatar">
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1 text-capitalize"><?php echo $user->firstname . ", " . $user->lastname; ?></h5>
                            
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
                    <p><strong>Full Name:</strong> <?php echo $user->firstname . ", " . $user->lastname; ?></p>
                    <p><strong>Email:</strong> <?php echo $user->email_address;  ?></p>
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
                    <p><strong>Province:</strong> <?= !empty($user->municipality) ? htmlspecialchars($user->municipality) : 'Not Set' ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="editProfileForm" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST' enctype="multipart/form-data">
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
                            <img id="profilePreview" name="profile_pic" src="<?php echo $profile_img;?>" 
                                 alt="Profile Picture" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                        </div>
                        
                        <?php if (empty($user->profile_pic)) : ?>
                            <!-- No profile picture yet -->
                            <input type="file" name="profile_pic" class="form-control" accept="image/*" id="profilePicInput">
                        <?php else : ?>
                            <!-- Show current picture -->
                            <div class="mb-2 text-center">
                                <img src="<?= "{$base_url}/uploads/{$_SESSION['user_type']}/{$_SESSION['user_id']}/{$user->profile_pic}" ?>"
                                    alt="Profile Picture"
                                    class="rounded-circle shadow"
                                    style="width:120px; height:120px; object-fit:cover;">
                            </div>
                            <label for="profilePicInput" class="form-label">Change Profile Picture</label>
                            <input type="file" name="profile_pic" class="form-control" accept="image/*" id="profilePicInput">
                        <?php endif; ?>
                        <small class="text-muted">Choose a profile picture to preview (not saved yet).</small>
                    </div>

                    <!-- Name & Contact -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" 
                                   value="<?php echo $user->firstname; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" 
                                   value="<?php echo $user->lastname; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email_address" class="form-control" value="<?php echo $user->email_address; ?>" readonly>
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
                        <label>Complete Address</label>
                        <input type="text" name="address" class="form-control mb-2" placeholder="Street / Purok" value="<?= !empty($user->address) ? htmlspecialchars($user->address) : 'Not Set' ?>">
                        <input type="text" name="barangay" class="form-control mb-2" placeholder="Barangay" value="<?= !empty($user->barangay) ? htmlspecialchars($user->barangay) : 'Not Set' ?>">
                        <input type="text" name="municipality" class="form-control mb-2" placeholder="Municipality" value="<?= !empty($user->municipality) ? htmlspecialchars($user->municipality) : 'Not Set' ?>">
                        <input type="text" name="province" class="form-control" placeholder="Province" value="<?= !empty($user->province) ? htmlspecialchars($user->province) : 'Not Set' ?>">
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

<?php }?>

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
