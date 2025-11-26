<?php
$order_id = isset($_GET['vod']) ? $_GET['vod'] : die('ERROR: missing ID.');

include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/order.php";
include_once "../../../objects/user.php";
include_once "../../../objects/product.php";

$page_title = "Feedback";
include_once "../layout/layout_head.php";

// always make the page required is enabled
$require_login = true;
include_once "../../../login_checker.php";

?>