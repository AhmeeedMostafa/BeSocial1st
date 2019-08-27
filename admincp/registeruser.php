<?php
	if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once '../Libs/index.html');
	if(isset($_POST['register'])){
		$username = BS1st::postValues($_POST['username']);
		$password = BS1st::postValues($_POST['password']);
		
		$getSameUser = BS1st::SQL("SELECT * FROM `users` WHERE username = '".$username."'");
		if(BS1st::rowsNum($getSameUser) >= 1){
			echo "<div class='alert alert-danger'>This Username Already User With Us .</div>";
		}else{
			$register = BS1st::SQL("INSERT INTO `users` (username, password, balance) VALUES ('".$username."', '".$password."', '0.00')");
			if($register == true)
				echo "<div class='alert alert-success'>User Has Been Registered Successfully .</div>";
		}
	}
?>
<center>
	<h3>Register New User | Admin Cpanel</h3>
	<hr />
</center>
<form action=""  method="POST" class="center-block" role="form" style="width: 30%;">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="username" required="required" value="<?php (isset($_POST['username'])) ? print $_POST['username'] : null; ?>" class="form-control" id="username" />
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password" required="required" class="form-control" id="password" />
	</div>
	<button type="submit" class="btn btn-default btn-lg btn-block" name="register">Register New User</button>
</form>