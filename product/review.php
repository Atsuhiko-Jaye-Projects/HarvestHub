
<style>
  .review-card {
    border-bottom: 1px solid #eee;
    padding: 1rem 0;
  }
  .user-avatar {
    width: 48px;
    height: 48px;
    background: #ccc;
    border-radius: 50%;
    font-weight: 700;
    font-size: 1.2rem;
    color: #666;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .star-rating i {
    color: #f56a23;
    font-size: 1rem;
  }
  .review-meta small {
    color: #777;
  }
  .review-details b {
    font-weight: 600;
  }
  .review-text {
    margin: 0.7rem 0 1rem 0;
  }
  .media-thumbnails {
    display: flex;
    gap: 0.5rem;
  }
  .media-thumb {
    position: relative;
    width: 70px;
    height: 70px;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    background: #000;
  }
  .media-thumb img, .media-thumb video {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .video-icon {
    position: absolute;
    bottom: 4px;
    left: 4px;
    background: rgba(0,0,0,0.7);
    color: white;
    font-size: 0.8rem;
    padding: 1px 4px;
    border-radius: 3px;
    display: flex;
    align-items: center;
    gap: 3px;
  }
  .seller-response {
    background: #f5f5f5;
    border-radius: 4px;
    padding: 0.75rem 1rem;
    margin-top: 1rem;
    font-size: 0.9rem;
  }
  .like-btn {
    color: #999;
    cursor: pointer;
    user-select: none;
  }
  .like-btn.liked {
    color: #f56a23;
    font-weight: 700;
  }
  .review-actions {
    font-size: 1.2rem;
    color: #ccc;
    cursor: pointer;
  }
</style>

<!-- loop the reviews -->
<?php
if ($num>0){
    while ($row = $getProductReview->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
?>
    <div class="review-card d-flex gap-3">
    <div class="user-avatar flex-shrink-0">a</div>
    
    <div class="flex-grow-1">
        <div class="d-flex justify-content-between align-items-start">
        <div>
            <div><strong><?php echo $row['customer_name']; ?></strong></div>
            <div class="star-rating">
            <?php
                $rating = $row['product_rating']; // e.g., 4.5
                $maxStars = 5;

                for ($i = 1; $i <= $maxStars; $i++) {
                    if ($i <= floor($rating)) {
                        // Full star
                        echo "<i class='bi bi-star-fill' style='color:#f56a23;'></i>";
                    } elseif ($i - $rating < 1) {
                        // Half star
                        echo "<i class='bi bi-star-half' style='color:#f56a23;'></i>";
                    } else {
                        // Empty star
                        echo "<i class='bi bi-star' style='color:#f56a23;'></i>";
                    }
                }
            ?>
            </div>
            <div class="review-meta small">2025-05-10 10:59 | Variation: 1x4</div>
        </div>
        <div class="review-actions">
            <i class="bi bi-three-dots-vertical"></i>
        </div>
        </div>
        
        <div class="review-details mt-2">
        <div><b>Product Quality: </b><Strong><?php echo $row['product_quality_review']; ?></Strong></div>
        <div><b>Performance: </b><Strong><?php echo $row['performance_review']; ?></Strong></div>
        <!-- <div><b>Best Feature:</b> </div> -->
        </div>
        
        <p class="review-text">
        <?php echo $row['review_text']; ?>
        </p>
        
        <div class="media-thumbnails">
        <div class="media-thumb" title="Video">
            <video src="your-video-url.mp4" muted></video>
            <div class="video-icon"><i class="bi bi-camera-video-fill"></i> 0:05</div>
        </div>
        <div class="media-thumb" title="Photo">
            <img src="your-photo-url.jpg" alt="Review photo">
        </div>
        </div>
        

            <!-- check if farmer response is empty -->
             <?php
                if (!empty($row['farmer_response'])) {
                    echo "<div class='seller-response mt-3'>";
                        echo "<strong>Farmer's Response:</strong><br>";
                        echo $row['farmer_response'];
                    echo "</div>";
                }else{
                }
             ?>

        
        <div class="d-flex align-items-center mt-2 gap-2">
        <div class="like-btn" onclick="this.classList.toggle('liked')">
            <i class="bi bi-hand-thumbs-up"></i> 1
        </div>
        </div>
    </div>
    </div>
<?php 
    }
}?>
