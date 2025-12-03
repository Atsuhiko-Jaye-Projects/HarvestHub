<?php

$action=isset($_GET['action']) ? $_GET['action'] : "";
//tell user hes not yet logged in

if ($action == "not_yet_logged_in") {
    echo "<div class='alert alert-danger margin-top-40' role='alert'>Please login.</div>";
}

else if($action=='please_login'){
    echo "<div class='alert alert-info'>";
        echo "<strong>Please login to access that page.</strong>";
    echo "</div>";
}

elseif ($action=='please_verify') {
    echo "<div class='alert alert-warning'>";
        echo "<strong>Please Verify your account to continue.</strong>";
    echo "</div>";
}

elseif ($action=='not_set_shipping_address') {
    echo "<div class='alert alert-warning'>";
        echo "<strong>Please Setup your Shipping address to continue checking out. <a href='{$base_url}user/consumer/profile/profile.php'>Here</a></strong>";
    echo "</div>";
}

if ($access_denied) {
    echo "<div class='alert alert-danger margin-top-40' role='alert'>";
        echo "Access Denied. <br/> <br/>";
        echo "Contact No. or Last Name is incorrect.";
    echo "</div>";
}

?>
