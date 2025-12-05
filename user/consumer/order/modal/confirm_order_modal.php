<div class="modal fade" id="confirm-order-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-question-circle text-primary me-2"></i>
          Confirm This Order?
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body text-center">
        <p class="text-muted mb-0">
            <input type="hidden" name="action" value="confirmed">
            <input type="hidden" name='order_id' value="<?php echo $order_id;?>">
            <input type="hidden" name='invoice_number' value="<?php echo $order->invoice_number;?>">
            <input type="hidden" name='product_id' value="<?php echo $order->product_id;?>">
          Are you sure you want to confirm this order?  
          This action cannot be undone.
        </p>
      </div>

      <!-- Footer -->
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-lg me-1"></i> No
        </button>
        <button type="button" class="btn btn-primary" id="confirmOrder">
          <i class="bi bi-check-lg me-1"></i> Yes, Confirm
        </button>
      </div>

    </div>
  </div>
</div>
