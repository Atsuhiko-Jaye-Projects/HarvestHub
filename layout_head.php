<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
    .product-card {
    transition: transform 0.2s;
}
.product-card:hover {
    transform: translateY(-5px);
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
