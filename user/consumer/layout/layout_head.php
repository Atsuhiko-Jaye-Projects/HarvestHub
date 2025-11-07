<?php
$base_url = "/HarvestHub/";
$root_path = $_SERVER['DOCUMENT_ROOT'] . "/HarvestHub/";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($page_title) ? $page_title : "HarvestHub"; ?></title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- Custom Styles -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>libs/css/style.css">

  <style>
  body {
    overflow-x: hidden;
    background: #f8f9fa;
  }

  /* Sidebar */
  .sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1000;
    background-color: #fff;
    transition: transform 0.3s ease;
  }
  .sidebar.show { transform: translateX(0); }
  .sidebar.hide { transform: translateX(-100%); }

  /* Content */
  .content-wrapper {
    margin-left: 250px;
    min-height: 100vh;
    transition: margin-left 0.3s ease;
  }

  .nav-link.active {
    background-color: #ffffff;
    color: #198754 !important;
    font-weight: 600;
  }

  /* Cards */
  .order-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    background: #fff;
    margin-bottom: 1rem;
    transition: all 0.2s ease-in-out;
  }
  .order-card:hover { transform: scale(1.01); }

  /* Tables */
  .table-responsive { overflow-x: auto; }

  /* Mobile */
  @media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); position: fixed; }
    .content-wrapper { margin-left: 0 !important; }
    .sidebar-toggle-btn {
      display: inline-block;
    }
  }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <?php include $root_path . "user/consumer/layout/sidebar.php"; ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">

    <!-- Navigation -->
    <?php include $root_path . "user/consumer/layout/navigation.php"; ?>

    <!-- Main Container -->
    <div class="container-fluid p-3">
