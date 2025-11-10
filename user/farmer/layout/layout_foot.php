</div>
</div>
</div>
</div>

<!-- CORE js Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.4/bootbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- APIs -->


<!-- JS modules -->

<!-- check the page if index page -->

<?php

if ($page_title == "Index") {
  echo "<script src='/Harvesthub/js/user/farmer/statistics/graphs.js'></script>";
}else{
echo "<script src='/HarvestHub/js/user/farmer/modals/farm_product/farm_product_modal.js'></script>
<script src='/HarvestHub/js/user/farmer/modals/farm_crop/farm_crop_modal.js'></script>
<script src='/Harvesthub/js/user/farmer/utils/utils.js'></script>
<script src='/HarvestHub/js/user/farmer/weather/weather.js'></script>
<script src='/HarvestHub/js/user/farmer/products/delete_product.js'></script>
<script src='/Harvesthub/js/user/farmer/utils/tooltips.js'></script>";
}
?>


</body>
</html>
