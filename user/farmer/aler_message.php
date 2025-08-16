$action=isset($_GET['action']) ? $_GET['action'] : "";
echo '<!-- Hidden Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="bi bi-check-circle-fill text-success fs-1"></i>
        <p class="mt-2 mb-0">Product updated successfully!</p>
      </div>
    </div>
  </div>
</div>';