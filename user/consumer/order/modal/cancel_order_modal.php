

<!-- Button to trigger modal (example) -->

<!-- Modal -->
<div class="modal fade" id="cancel-order-modal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header border-0">
        <h5 class="modal-title" id="cancelOrderModalLabel">Select Cancellation Reason</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <div class="alert alert-warning small d-flex align-items-start">
          <i class="bi bi-exclamation-circle-fill me-2"></i>
          <div>
            Please select a cancellation reason. Please take note that this will cancel all items in the order and the action cannot be undone.
          </div>
        </div>

        <form id="cancelOrderForm">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancelReason" id="reason1" value="change_address">
            <label class="form-check-label" for="reason1">
              Need to change delivery address
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancelReason" id="reason2" value="voucher">
            <label class="form-check-label" for="reason2">
              Need to input/change voucher code
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancelReason" id="reason3" value="modify_order">
            <label class="form-check-label" for="reason3">
              Need to modify order (size, color, quantity, etc.)
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancelReason" id="reason4" value="payment_troublesome">
            <label class="form-check-label" for="reason4">
              Payment procedure too troublesome
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancelReason" id="reason5" value="found_cheaper">
            <label class="form-check-label" for="reason5">
              Found cheaper elsewhere
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancelReason" id="reason6" value="dont_want">
            <label class="form-check-label" for="reason6">
              Don't want to buy anymore
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancelReason" id="reason7" value="others">
            <label class="form-check-label" for="reason7">
              Others
            </label>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer border-0 justify-content-between">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">NOT NOW</button>
        <button type="button" class="btn btn-danger" id="confirmCancelOrder">CANCEL ORDER</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS + optional Bootstrap Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<script>
    document.getElementById('confirmCancelOrder').addEventListener('click', function() {
    const form = document.getElementById('cancelOrderForm');
    const selected = form.cancelReason.value;

    if (!selected) {
        alert('Please select a cancellation reason!');
        return;
    }

    // Example: send reason via AJAX
    console.log('Selected reason:', selected);

    // Close modal
    const modalEl = document.getElementById('cancelOrderModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
});

</script>