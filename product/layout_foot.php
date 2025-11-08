<!-- Footer -->
<footer class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h6>Explore</h6>
        <ul class="list-unstyled">
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h6>Customer Services</h6>
        <ul class="list-unstyled">
          <li><a href="#">Online Payment</a></li>
          <li><a href="#">Order Tracking</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h6>Blog</h6>
        <ul class="list-unstyled">
          <li><a href="#">Best Practices</a></li>
          <li><a href="#">Color Wheel</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

  function updateCartCount() {
    $.ajax({
      url: "../js/user/farmer/api/fetch_cart_count.php",
      type: "GET",
      dataType: "json",
      success: function(response) {
        console.log("Cart count response:", response); // 🧭 Debugging line

        let count = response.cart_item_count ?? 0;
        $("#cart-count").text(count);
        $("#cart-count").fadeIn(300);
      
      },
      error: function(xhr, status, error) {
        console.error("Error fetching cart count:", error);
      }
    });
  }

  // Initial load
  updateCartCount();

  // Update on interval
  setInterval(updateCartCount, 10000);

  // Example triggers
  // $(document).on("click", ".add-to-cart-btn, .delete-object", function() {
  //   setTimeout(updateCartCount, 500);
  // });
});
</script>

</body>
</html>

<script>
window.addEventListener("load", function() {
  const addToCartBtn = document.getElementById("addToCartBtn");
  if (!addToCartBtn) return;

  const cartModal = new bootstrap.Modal(document.getElementById("cartModal"));
  const loadingSpinner = document.getElementById("loadingSpinner");
  const checkIcon = document.getElementById("checkIcon");
  const statusText = document.getElementById("statusText");

  addToCartBtn.addEventListener("click", function() {
    cartModal.show();

    loadingSpinner.style.display = "block";
    checkIcon.style.display = "none";
    statusText.textContent = "Adding to cart...";

    setTimeout(() => {
      loadingSpinner.style.display = "none";
      checkIcon.style.display = "block";
      statusText.textContent = "Added successfully!";

      setTimeout(() => {
        cartModal.hide();
        document.getElementById("cartForm").submit();
      }, 1500);
    }, 1500);
  });
});
</script>





