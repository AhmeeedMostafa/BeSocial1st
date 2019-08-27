<?php
$title = "Settings";
require_once 'includes/header.php';
BS1st::checkSession('user_id', 'username');

if(isset($_POST['edit'])){
	$current_password 	= BS1st::postValues($_POST['current_password']);
	$new_password 		= BS1st::postValues($_POST['new_password']);
	$confirm_password 	= BS1st::postValues($_POST['confirm_password']);
	
	$getUserPass 	= BS1st::SQL("SELECT * FROM `users` WHERE id = '".$_SESSION['user_id']."'");
	$userPass 		= BS1st::fetchAssoc($getUserPass);

	if(empty($current_password))
		echo "<div class='alert alert-danger'>Current Password Required .</div>";
	else if(BS1st::rowsNum($getUserPass) == 0)
		echo "<div class='alert alert-danger'>No User Found To Change His Password .</div>";
	else if(empty($new_password))
		echo "<div class='alert alert-danger'>New Password Required .</div>";
	else if($current_password != $userPass['password'])
		echo "<div class='alert alert-danger'>Current Password Is Wrong .</div>";
	else if(empty($confirm_password))
		echo "<div class='alert alert-danger'>Confirm Password Required .</div>";
	else if($new_password != $confirm_password)
		echo "<div class='alert alert-danger'>Confirm Password Doesn't Equal New Password .</div>";
	else{
		$editPass = BS1st::SQL("UPDATE `users` SET password = '".$new_password."' WHERE id = '".$_SESSION['user_id']."'");
		if(isset($editPass))
			echo "<div class='alert alert-success'>Password Changed Successfully .</div>";
	}
		
}
?>
<form action=""  method="POST" class="center-block" role="form" style="width: 30%;">
	<div class="form-group">
		<label for="current_password">Current Password</label>
		<input type="password" name="current_password" class="form-control" id="current_password" />
	</div>
	<div class="form-group">
		<label for="new_password">New Password</label>
		<input type="password" name="new_password" class="form-control" id="new_password" />
	</div>
	<div class="form-group">
		<label for="confirm_password">Confirm Password</label>
		<input type="password" name="confirm_password" class="form-control" id="confirm_password" />
	</div>
	<button type="submit" class="btn btn-default btn-lg btn-block" name="edit">Edit</button>
</form>