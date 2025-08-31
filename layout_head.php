<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
    .category-icon {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
    }
    .product-card img {
      height: 150px;
      object-fit: cover;
    }
    .hero-banner {
      background-color: #28a745;
      color: white;
      border-radius: 12px;
      padding: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
  </style>
  </head>
  <body>
    <?php 
      if ($page_title != "Index") {
          echo "<div class='container-fluid'>";
          echo "<div class='row' style='height: 100vh'>";
      }else{
        ?>
        <!-- navbar -->

        <?php
      }
    ?>
