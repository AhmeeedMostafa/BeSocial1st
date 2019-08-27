<?php
/**
 * @author Ahmed Mostafa <ahmed.mostafa1198@gmail.com>
 * @copyright (c) 2014, Ahmed Mostafa
 * @version 1.0
 */
$title = "BeSocial1st";
require_once 'includes/header.php';

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])){

	if(isset($_POST['logIn'])){
		$username = BS1st::postValues($_POST['username']);
		$password = $_POST['password'];
		
		$check = BS1st::SQL("SELECT * FROM `users` WHERE username = '".$username."' AND password = '".$password."'");
		if(BS1st::rowsNum($check) == 0){
			echo "<center><div style='width: 25%' class='alert alert-danger'>Incorrect username or password</div></center>";
		}else{
			$user = BS1st::fetchAssoc($check);
			$_SESSION['user_id']  = $user['id'];
			$_SESSION['username'] = $user['username'];
			header("Location: index.php");
		}
	}
	
	require_once 'includes/Login.html';
}else{
    require_once "newOrder.php";
}
echo "<br /><div style='padding-left: 5px'";
require_once 'faq.php';
echo "</div>";

include_once "includes/footer.php";