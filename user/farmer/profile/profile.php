<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/user.php";
include_once "../../../objects/farm.php";
//include_once "../../../objects/farm-details.php";

$page_title = "Profile";
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

    if ($_POST['action'] == "update_farm_info") {
        
        $farm->user_id = $_SESSION['user_id'];
        $farm->lot_size = $_POST['farm_size'];
        $farm->farm_type = $_POST['farm_type'];
        $farm->farm_name = $_POST['farm_name'];
        $farm->province = $_POST['province_name'];
        $farm->municipality = $_POST['municipality_name'];
        $farm->baranggay = $_POST['barangay_name'];
        $farm->purok = $_POST['purok'];

        if ($farm->updateFarmDetail()) {
            $_SESSION['flash'] = [
                'title' => 'Success!',
                'text'  => 'Farm Info has been updated successfully.',
                'icon'  => 'success' // 'success', 'error', 'warning', 'info'
            ];
        }else{
            echo "<div class = 'alert alert-danger'>ERROR: Profile update failed.</div>";
        }

    }
}
?>

<div class="container py-4">
    <!-- Profile Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">
                
                <!-- Left: Avatar + Welcome Message -->
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <!-- Avatar -->
                    <div class="rounded-circle bg-light overflow-hidden d-flex justify-content-center align-items-center"
                         style="width:80px; height:80px; transition: transform 0.3s;">
                        <img id="profilePreview" src="../../uploads/profile_pictures/<?php echo $_SESSION['user_type'] . "/" . $_SESSION['user_id'] . "/" . $user->profile_pic;?>" 
                             style="width:80px; height:80px; border-radius:50%; object-fit:cover;" 
                             alt="User Avatar" 
                             title="Click edit to change profile picture">
                    </div>

                    <!-- Welcome & Role -->
                    <div class="ms-3">
                        <h5 class="mb-1 text-capitalize">
                            Welcome BACK, <?php echo htmlspecialchars($user->firstname . " " . $user->lastname); ?>!
                        </h5>
                        <small class="text-light-opacity"><?php echo htmlspecialchars($_SESSION['user_type']); ?></small>
                    </div>
                </div>

                <!-- Right: Edit Button -->
                <!-- <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-fill me-1"></i> Edit Profile
                </button> -->
            </div>
        </div>
    </div>
</div>

<!-- Optional: Small hover effect on avatar -->
<style>
    #profilePreview:hover {
        transform: scale(1.05);
        cursor: pointer;
    }
    .text-light-opacity {
        opacity: 0.85;
    }
</style>


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
                    <p><strong>Full Name: <?php echo $user->firstname . " " .  $user->lastname; ?></strong> <?php?></p>
                    <p><strong>Email:</strong> <?php echo $user->email_address; ?></p>
                    <p><strong>Contact Number:</strong> <?php echo $user->contact_number; ?></p>
                    <p><strong>Address:</strong> <?= !empty($user->address) ? htmlspecialchars($user->address) : 'Not Set' ?></p>
                </div>
            </div>
        </div>
<?php
    if ($farm->getFarmerDetailsById()) {
        # code...
?>

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
                        <?php
                            $farm_province     = !empty($farm->province)     ? $farm->province     : 'Not Set';
                            $farm_municipality = !empty($farm->municipality) ? $farm->municipality : 'Not Set';
                            $farm_barangay     = !empty($farm->baranggay)    ? $farm->baranggay    : 'Not Set';
                            $farm_address      = !empty($farm->purok)          ? $farm->purok      : 'Not Set';

                            $farm_location = $farm_address . " " . $farm_barangay . "," . $farm_municipality . "," . $farm_province; 
                        ?>
                        <p><strong>Farm Name:</strong> <?= !empty($farm->farm_name) ? htmlspecialchars($farm->farm_name) : 'Not Set' ?></p>
                        <p><strong>Farm Location:</strong> <?=  $farm_location ?></p> 
                        <hr>  
                        <p>
                        <strong class="text-primary">Total Farm Area:</strong>
                        <?= !empty($farm->lot_size) ? htmlspecialchars($farm->lot_size) : 'Not Set' ?> sqm
                        </p>

                        <p>
                        <strong class="text-danger">Land in Use:</strong>
                        <?= !empty($farm->used_lot_size) ? htmlspecialchars($farm->used_lot_size) : '0' ?> sqm
                        </p>

                        <p>
                        <strong class="text-success">Available Land:</strong>
                        <?= !empty($farm->lot_size) 
                            ? htmlspecialchars($farm->lot_size - ($farm->used_lot_size ?? 0)) 
                            : '0' ?> sqm
                        </p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editProfileForm" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST' enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <label class="form-label">Profile Picture</label>
                        <div class="mb-2">
                            <img id="profileModalPreview" src="../../uploads/profile_pictures/<?php echo $_SESSION['user_type'] . "/" . $_SESSION['user_id'] . "/" . $user->profile_pic;?>" class="rounded-circle" style="width:100px;height:100px;object-fit:cover;">
                        </div>
                        <input type="file" name="profile_pic" class="form-control" accept="image/*" id="profilePicInput">
                    </div>
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $user->firstname; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $user->lastname; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email_address" name="email" class="form-control" value="<?php echo $user->email_address; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" value="<?php echo $user->contact_number; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
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

<!-- Optional Farm Edit Modal -->
<div class="modal fade" id="editFarmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editFarmForm" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="action" value="update_farm_info">
                <input type="hidden" name="province_name" id="province_name">
                <input type="hidden" name="municipality_name" id="municipality_name">
                <input type="hidden" name="barangay_name" id="barangay_name">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Farm Info</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Farm Name</label>
                        <input type="text" name="farm_name" class="form-control" value="<?= !empty($farm->farm_name) ? htmlspecialchars($farm->farm_name) : 'Not Set' ?>">
                    </div>
                    <div class="mb-3">
                        <label>Farm Size (sqm)</label>
                        <input type="number" name="farm_size" class="form-control" value="<?= !empty($farm->lot_size) ? htmlspecialchars($farm->lot_size) : 'Not Set' ?>">
                    </div>
                    <!-- <div class="mb-3">
                        <label>Farm Type</label>
                        <select name="farm_type" class="form-select">
                            <option value="">Select type</option>
                            <?= !empty($farm->farm_name) ? htmlspecialchars($farm->farm_name) : 'Not Set' ?>
                            <option value="Vegetable" <?php if(($farm->farm_type ?? '')=='Vegetable') echo 'selected'; ?>>Vegetable</option>
                            <option value="Fruit" <?php if(($farm->farm_type ?? '')=='Fruit') echo 'selected'; ?>>Fruit</option>
                            <option value="Livestock" <?php if(($farm->farm_type ?? '')=='Livestock') echo 'selected'; ?>>Livestock</option>
                        </select>
                    </div> -->
                    <div class="row mb-3">
                        <div class="col-12 col-sm-6 col-md-6 mt-3">
                        <label class="form-label">Province</label>
                        <select name="province" id="farm-province" class='form-select' required>
                            <option value="" hidden>Select ...</option>
                        </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 mt-3">
                        <label class="form-label">Municipality</label>
                        <select name="municipality" id="farm-municipality" class='form-select' required>
                            <option value="" hidden>Select...</option>
                        </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 mt-3">
                        <label class="form-label">Barangay</label>
                        <select name="barangay" id="farm-barangay" class='form-select' required>
                            <option value="" hidden>Select...</option>
                        </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 mt-3">
                        <label class="form-label">Street</label>
                        <input type="text" name="purok" class="form-control">
                        </div>
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
<?php }else{
    echo "ERROR:";
}?>
<?php

}
?>

<script>
const farmModal = document.getElementById("editFarmModal");

farmModal.addEventListener("shown.bs.modal", function () {

  const provinceSelect = document.getElementById("farm-province");
  const municipalitySelect = document.getElementById("farm-municipality");
  const barangaySelect = document.getElementById("farm-barangay");

  const provinceInput = document.getElementById("province_name");
  const municipalityInput = document.getElementById("municipality_name");
  const barangayInput = document.getElementById("barangay_name");

  // prevent reloading provinces
  if (provinceSelect.options.length > 1) return;

  fetch("https://psgc.gitlab.io/api/provinces/")
    .then(res => res.json())
    .then(data => {
      provinceSelect.innerHTML = '<option disabled selected>Select Province</option>';
      data.forEach(p => {
        const opt = document.createElement("option");
        opt.value = p.code;
        opt.textContent = p.name;
        opt.dataset.name = p.name;
        provinceSelect.appendChild(opt);
      });
    });

  provinceSelect.onchange = function () {
    provinceInput.value = this.selectedOptions[0].dataset.name;

    fetch(`https://psgc.gitlab.io/api/provinces/${this.value}/cities-municipalities/`)
      .then(res => res.json())
      .then(data => {
        municipalitySelect.innerHTML = '<option disabled selected>Select Municipality</option>';
        barangaySelect.innerHTML = '<option disabled selected>Select Municipality First</option>';

        data.forEach(m => {
          const opt = document.createElement("option");
          opt.value = m.code;
          opt.textContent = m.name;
          opt.dataset.name = m.name;
          municipalitySelect.appendChild(opt);
        });
      });
  };

  municipalitySelect.onchange = function () {
    municipalityInput.value = this.selectedOptions[0].dataset.name;

    fetch(`https://psgc.gitlab.io/api/cities-municipalities/${this.value}/barangays/`)
      .then(res => res.json())
      .then(data => {
        barangaySelect.innerHTML = '<option disabled selected>Select Barangay</option>';
        data.forEach(b => {
          const opt = document.createElement("option");
          opt.value = b.code;
          opt.textContent = b.name;
          opt.dataset.name = b.name;
          barangaySelect.appendChild(opt);
        });
      });
  };

  barangaySelect.onchange = function () {
    barangayInput.value = this.selectedOptions[0].dataset.name;
  };
});

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    title: <?= json_encode($_SESSION['flash']['title']) ?>,
    text: <?= json_encode($_SESSION['flash']['text']) ?>,
    icon: <?= json_encode($_SESSION['flash']['icon']) ?>,
    showConfirmButton: false, // ❌ no OK button
}).then(() => {
   window.location.href = window.location.pathname;
});

</script>
<?php unset($_SESSION['flash']); ?>

<?php include_once "../layout/layout_foot.php"; ?>
