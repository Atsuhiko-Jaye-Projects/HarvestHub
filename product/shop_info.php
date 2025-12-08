<div class="card p-3 shadow-sm rounded mb-3 mt-3">
  <div class="d-flex align-items-center flex-wrap">
    
    <!-- Shop Logo -->
    <div class="me-3">
      <img src="<?php echo $logo; ?>" 
     alt="Shop Logo" 
     class="rounded-circle"
     style="width: 70px; height: 70px; border: 3px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.3);">
    </div>

    <!-- Shop Info -->
    <div class="flex-grow-0">
      <h5 class="mb-1"><?php echo $farm_info->farm_name;?></h5>
      <small class="text-muted">Active 4 Minutes Ago</small>
      <div class="mt-2">
        <span class="badge bg-danger">Preferred</span>
      </div>
    </div>

    <!-- Shop Metrics -->
    <div class="d-flex flex-wrap align-items-center ms-auto gap-3 mt-2 mt-md-0">
      <div>
        <div class="text-muted small">Ratings</div>
        <div class="fw-bold text-danger">101.2K</div>
      </div>
      <div>
        <div class="text-muted small">Products</div>
        <div class="fw-bold">268</div>
      </div>
      <div>
        <div class="text-muted small">Response Rate</div>
        <div class="fw-bold text-success">100%</div>
      </div>
      <div>
        <div class="text-muted small">Response Time</div>
        <div class="fw-bold">within minutes</div>
      </div>
      <div>
        <div class="text-muted small">Joined</div>
        <div class="fw-bold"><?php echo  $joined_duration;?> ago</div>
      </div>
      <div>
        <div class="text-muted small">Follower</div>
        <div class="fw-bold"><?php echo $farm_info->follower_count; ?></div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="d-flex gap-2 mt-2 mt-md-0 ms-auto">
       <?php
        if ($_SESSION['logged_in'] == true) {
          echo "<a href='../user/consumer/message/message.php?fid={$farm_info->user_id}' class='btn btn-success'><i class='bi bi-chat-dots me-1'></i> Chat Now</a>";
        }
       ?>
      <a href="../FarmShop/farmer_profile.php?fid=<?php echo $farm_info->user_id; ?>" class="btn btn-outline-secondary">View Shop</a>
    </div>

  </div>
</div>