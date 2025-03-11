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

elseif ($action=='email_verified') {
    echo "<div class='alert alert-success'>";
        echo "<strong>Email address has been validated</strong>";
    echo "</div>";
}

if ($access_denied) {
    echo "<div class='alert alert-danger margin-top-40' role='alert'>";
        echo "Access Denied. <br/> <br/>";
        echo "Contact No. or Last Name is incorrect.";
    echo "</div>";
}
?>
