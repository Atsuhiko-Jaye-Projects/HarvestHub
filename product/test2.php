<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Modern Add to Cart Modal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
<body class="text-center p-5">

<button id="addToCartBtn" class="btn btn-success btn-lg shadow-sm">Add to Cart</button>

<!-- Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div id="loadingSpinner" class="modern-loader"></div>
      <div id="checkIcon" class="check-icon">
        <i class="bi bi-check-circle-fill"></i>
      </div>
      <p id="statusText" class="status-text">Adding to cart...</p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  
  const modal = new bootstrap.Modal($('#cartModal')[0], {
  backdrop: 'static',  // prevent close when clicking outside
  keyboard: false       // prevent close on ESC
  });

  $('#addToCartBtn').click(function() {
    // Reset modal state
    $('#loadingSpinner').show();
    $('#checkIcon').hide();
    $('#statusText').text('Adding to cart...');
    modal.show();

    // Simulate loading delay
    setTimeout(() => {
      $('#loadingSpinner').fadeOut(300, function() {
        $('#checkIcon').fadeIn(300);
        $('#statusText').text('Added to cart! ✅');
      });

      // Auto-close modal
      setTimeout(() => {
        modal.hide();
      }, 1200);
    }, 800);
  });
});
</script>
</body>
</html>
