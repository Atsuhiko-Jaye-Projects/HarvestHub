<?php 

if ($page_title=="Index") {
	if(isset($_SESSION['is_farm_registered']) && $_SESSION['is_farm_registered']==0){
		echo "<div class='farm-alert-message'>Your farm details is not set, please set the details <a href='farm_detail.php'>HERE</a></div>";
	}
}




?>