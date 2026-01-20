<!-- SELLER RATING PANEL -->
<div class="card shadow-sm rounded mb-4">
  <div class="card-body">

    <h6 class="fw-bold mb-3">Seller Rating</h6>

    <div class="d-flex align-items-center">

      <!-- Rating Score -->
      <div class="me-4 text-center">
        <div class="fw-bold fs-2 text-warning">
          <?php echo number_format($seller_rating ?? 4.8, 1); ?>
        </div>
        <div class="small text-muted">out of 5</div>
      </div>


      <!-- Stars + Reviews -->
      <div>
        <?php
        $rating = round($seller_rating * 2) / 2; // rounds to nearest 0.5
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) == 0.5 ? true : false;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        ?>

        <div class="mb-1">
          <?php for ($i=0; $i < $fullStars; $i++) : ?>
            <i class="bi bi-star-fill text-warning"></i>
          <?php endfor; ?>

          <?php if ($halfStar) : ?>
            <i class="bi bi-star-half text-warning"></i>
          <?php endif; ?>

          <?php for ($i=0; $i < $emptyStars; $i++) : ?>
            <i class="bi bi-star text-warning"></i>
          <?php endfor; ?>
        </div>


        <div class="small text-muted">
          Based on <?php echo number_format($total_reviews ?? 120); ?> reviews
        </div>
      </div>

    </div>

  </div>
</div>
  