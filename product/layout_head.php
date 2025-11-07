<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../libs/css/product_detail_style.css">
  <style>
    body {
    background: #f9fafb;
    font-family: 'Poppins', sans-serif;
  }

  .modal-content {
    border: none;
    border-radius: 20px;
    padding: 40px 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }

  /* Modern loading animation */
  .modern-loader {
    width: 60px;
    height: 60px;
    border: 5px solid #e0e0e0;
    border-top: 5px solid #28a745;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Check animation */
  .check-icon {
    font-size: 60px;
    color: #28a745;
    display: none;
    animation: pop 0.4s ease-in-out;
  }

  @keyframes pop {
    0% { transform: scale(0.3); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
  }

  .status-text {
    font-size: 1.1rem;
    font-weight: 500;
    color: #333;
    margin-top: 15px;
  }

  #addToCartBtn {
    background-color: #28a745;
    border: none;
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 500;
  }

  #addToCartBtn:hover {
    background-color: #218838;
  }
</style>
</head>
<body>