<!-- Footer -->
<footer class="bg-dark text-white mt-5 py-4">
  <div class="container d-flex justify-content-between">
    <div>
      <h6>Explore</h6>
      <ul class="list-unstyled">
        <li>Home</li>
        <li>About Us</li>
        <li>Services</li>
      </ul>
    </div>
    <div>
      <h6>Customer Services</h6>
      <ul class="list-unstyled">
        <li>Online Payment & Cash on Delivery</li>
        <li>Order Tracking</li>
        <li>Help Center</li>
      </ul>
    </div>
    <div>
      <h6>Blog</h6>
      <ul class="list-unstyled">
        <li>Best Practices</li>
        <li>Careers</li>
        <li>Contact</li>
      </ul>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<!-- Optional success modal JS -->
<script>
  // After successful update
  const successModalEl = document.getElementById('successModal');
  if(successModalEl) {
    const successModal = new bootstrap.Modal(successModalEl);
    successModal.show();
    setTimeout(() => successModal.hide(), 2000);
  }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

  function updateCartCount() {
    $.ajax({
      url: "js/user/farmer/api/fetch_cart_count.php",
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
