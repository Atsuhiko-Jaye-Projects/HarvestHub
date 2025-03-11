<?php
// login checker for 'customer' access level
// if access level was not 'Admin', redirect him to login page
if(isset($_SESSION['user_type']) && $_SESSION['user_type']=="Admin"){
	header("Location: {$home_url}admin/index.php?action=logged_in_as_admin");
}

else if(isset($_SESSION['user_type']) && $_SESSION['user_type']=="Seller"){
	header("Location: {$home_url}seller/index.php?action=logged_in_as_seller");
}
// if $require_login was set and value is 'true'
else if(isset($require_login) && $require_login==true){
	// if user not yet logged in, redirect to login page
	if(!isset($_SESSION['user_type'])){
		header("Location: {$home_url}login.php?action=please_login");
	}
}
// if it was the 'login' or 'register' or 'sign up' page but the customer was already logged in
else if(isset($page_title) && ($page_title=="Sign In" || $page_title=="Sign Up")){
	// if user not yet logged in, redirect to login page
	if(isset($_SESSION['user_type']) && $_SESSION['user_type']=="Consumer"){
		header("Location: {$home_url}index.php?action=already_logged_in");
	}
}
else{
	// no problem, stay on current page
}
?>