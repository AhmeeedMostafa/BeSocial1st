<?php
$title = "Log Out";
require_once "includes/header.php";

if(isset($_SESSION['user_id']) || isset($_SESSION['username']) || isset($_SESSION['admin_id'])){
	$destroy_session 	= session_destroy();
	$unset_session 		= session_unset();
	if(isset($destroy_session) && isset($unset_session)){
		echo "<div class='alert alert-success'>You Have Been Logged Out Sucessfully, You're Redirecting To Main Page After 2 Seconds .</div><meta http-equiv='refresh' content='3; url=index.php' />";
	}
}else{
	echo "<div class='alert alert-danger'>You're not logging In to Log Out, You're Redirecting To Main Page After 2 Seconds .</div><meta http-equiv='refresh' content='3; url=index.php' />";
}
include_once "includes/footer.php";