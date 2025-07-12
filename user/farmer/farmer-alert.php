<?php 

if ($page_title == "Index") {
	if (isset($_SESSION['is_farm_registered']) && $_SESSION['is_farm_registered'] == 0) {
		echo "
		<div class='farm-alert'>
			<strong>Notice:</strong> Your farm details are not set. Please complete them <a href='farm_detail.php'>here</a>.
		</div>";
	}
}





?>