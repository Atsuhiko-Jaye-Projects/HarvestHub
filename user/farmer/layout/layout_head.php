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

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


</head>
<body>

<div class="container-fluid">
  <div class="row" style="height: 100vh">

    <!-- Sidebar -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . $base_url . "user/farmer/layout/sidebar.php"; ?>

    <!-- Main content -->
    <div class="col-2 col-sm-9 col-xl-10 p-0 m-0">

      <!-- Navigation -->
      <?php include $_SERVER['DOCUMENT_ROOT'] . $base_url . "user/farmer/layout/navigation.php"; ?>

      <!-- Page content starts here -->
      <div class="p-3">
        <!-- Your page-specific content goes here -->
