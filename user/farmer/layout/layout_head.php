<?php
// config/core.php
$base_url = "/HarvestHub/"; // Root URL for links
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($page_title) ? $page_title : "HarvestHub"; ?></title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>
body { font-family: "Inter", sans-serif; }
/* Darker backdrop with smooth opacity */
.modal-backdrop.show {
  opacity: 0.6 !important;
  background-color: rgba(0, 0, 0, 0.7) !important;
}

/* Center Bootbox horizontally and vertically */
.bootbox .modal-dialog {
  display: flex !important;
  align-items: center;
  justify-content: center;
  min-height: 100vh; /* full screen height to center vertically */
  margin: 0 auto; /* center horizontally */
}

/* Optional styling for better appearance */
.bootbox .modal-content {
  border-radius: 15px;
  box-shadow: 0 0 20px rgba(0,0,0,0.3);
  text-align: center;
  padding: 10px;
}

.bootbox .modal-title {
  font-weight: 600;
  color: #198754; /* Bootstrap green */
}

  /* Smooth slide animation */
  .offcanvas {
    transition: transform 0.35s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
  }

  /* Smooth backdrop */
  .offcanvas-backdrop.show {
    backdrop-filter: blur(4px);
    transition: backdrop-filter 0.3s ease !important;
  }
</style>


</head>
<body>

<div class="container-fluid">
  <div class="row" style="height: 100vh">


    <!-- Sidebar -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . $base_url . "user/farmer/layout/sidebar.php"; ?>

    <!-- Main content -->
    <div class="col-12 col-sm-9 col-xl-10 p-0 m-0">

      <!-- Navigation -->
      <?php include $_SERVER['DOCUMENT_ROOT'] . $base_url . "user/farmer/layout/navigation.php"; ?>

      <!-- Page content starts here -->
      <div class="p-3">
        <!-- Your page-specific content goes here -->
