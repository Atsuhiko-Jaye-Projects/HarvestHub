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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  

<style>
  
body { font-family: "Inter", sans-serif; }
/* Darker backdrop with smooth opacity */
.modal-backdrop.show {
  opacity: 0.6 !important;
  background-color: rgba(0, 0, 0, 0.7) !important;
}

/* === MODERN FARM INPUT UI === */



.modal-content {
  border-radius: 18px;
  border: none;
  box-shadow: 0 20px 40px rgba(0,0,0,.12);
  overflow: hidden;
}

/* Header */
.modal-header {
  background: linear-gradient(135deg, #198754, #20c997);
  color: #fff;
  padding: 1.5rem 2rem;
}

.modal-header h4 {
  font-weight: 700;
}

.modal-header small {
  opacity: .9;
}

/* Body */
.modal-body {
  padding: 2rem;
  background: #f8fafc;
}

/* Labels */
label {
  font-weight: 600;
  font-size: .9rem;
  margin-bottom: .35rem;
}

/* Inputs */
.form-control,
.form-select,
textarea {
  border-radius: 12px !important;
  border: 1.8px solid #d1d5db !important;
  padding: .65rem .85rem;
  font-size: .9rem;
  transition: all .2s ease;
  background: #fff;
}

.form-control:focus,
.form-select:focus,
textarea:focus {
  border-color: #198754 !important;
  box-shadow: 0 0 0 .2rem rgba(25,135,84,.15);
}

/* Activity block */
.item-block {
  background: #fff;
  border-radius: 16px;
  padding: 1rem 1.25rem;
  margin-bottom: 1.2rem;
  box-shadow: 0 6px 16px rgba(0,0,0,.06);
}

/* Activity header */
.item-block h5 {
  font-weight: 700;
  color: #198754;
}

/* Frame */
.frame {
  border-radius: 16px;
  padding: 1rem;
  background: #eef2f7;
}

/* Buttons */
.btn {
  border-radius: 12px;
  font-weight: 600;
  padding: .55rem 1.1rem;
}

.btn-primary {
  background: linear-gradient(135deg, #198754, #20c997);
  border: none;
}

.btn-danger {
  border-radius: 50%;
  width: 36px;
  height: 36px;
  padding: 0;
}

.btn-danger i {
  font-size: 1.1rem;
}

/* Floating total */
.floating-total {
  background: #fff;
  padding: .6rem 1.1rem;
  border-radius: 14px;
  font-weight: 700;
  box-shadow: 0 6px 14px rgba(0,0,0,.08);
}

#total-cost {
  color: white;
  
}

/* Footer */
.modal-footer {
  background: #f1f5f9;
  padding: 1.2rem 2rem;
}

/* Mobile */
@media (max-width: 768px) {
  .modal-body {
    padding: 1.25rem;
  }
}

.summary-card {
  border-radius: 1.2rem;
  box-shadow: 
    0 2px 6px rgba(0,0,0,0.05),
    0 10px 20px rgba(0,0,0,0.06);
  transition: all 0.25s ease-in-out;
  position: relative;
  overflow: hidden;
  border: 1px solid rgba(0,0,0,0.04);
}

/* fake 2D layered border effect */
.summary-card::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 1.2rem;
  border: 1px solid rgba(255,255,255,0.35);
  pointer-events: none;
}

.summary-card:hover {
  transform: translateY(-4px) scale(1.01);
  box-shadow:
    0 6px 15px rgba(0,0,0,0.08),
    0 14px 28px rgba(0,0,0,0.12);
}

/* icon bubble */
.icon-box {
  width: 50px;
  height: 50px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow:
    inset 0 0 0 2px rgba(255,255,255,0.4),
    0 4px 10px rgba(0,0,0,0.1);
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

  .floating-total {
    background-color: #198754; /* Bootstrap green */
    color: #fff;
    padding: 12px 18px;
    border-radius: 8px;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);;
}

.frame {
    padding: 15px;
    max-height: 450px; /* adjust height as needed */
    overflow-y: auto;  /* vertical scroll */
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f8f9fa; /* optional */
}

/* Optional: style for individual dynamic rows */
.dynamic-row {
    margin-bottom: 10px;
}

.media-card {
  width: 80px;
  height: 80px;
  background: #000;
  border-radius: 10px;
  overflow: hidden;
  cursor: pointer;
  display: inline-block;   /* ✅ THIS is the key */
  margin-right: 6px;       /* spacing */
}

.media-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}


/* Photo label */
.media-label {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.6);
  color: #fff;
  font-size: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  font-weight: 500;
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
