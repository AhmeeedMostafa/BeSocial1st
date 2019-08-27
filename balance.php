<?php
/**
 * @author Ahmed Mostafa <ahmed.mostafa1198@gmail.com>
 * @copyright (c) 2014, Ahmed Mostafa
 * @version 1.0
 */
$title = "Balance";
require_once 'includes/header.php';
BS1st::checkSession('user_id', 'username');

$UID = $_SESSION['user_id'];
$getUser = BS1st::SQLwF("SELECT * FROM `users` WHERE id = '".$UID."'");
?>
<center>
	<h3 style="font-weight: bold">Your Balance : $<?=substr($getUser['balance'], 0, 4);?></h3>
	<br />
	<form action="ppcharge.php"  method="POST" class="center-block" role="form" style="width: 30%;">
	<?php			
		if(isset($_GET['error']) && isset($_SESSION['charge_msg'])){
			$error = intval($_GET['error']);
			if($error == 1){
				echo "<div class='alert alert-danger'>".$_SESSION['charge_msg']."</div>";
				unset($_SESSION['charge_msg']);
			}else if($error == 2){
				echo "<div class='alert alert-danger'>".$_SESSION['charge_msg']."</div>";
				unset($_SESSION['charge_msg']);
			}
		}else if(isset($_SESSION['charge_msg'])){
			echo $_SESSION['charge_msg'];
			unset($_SESSION['charge_msg']);
		}
	?>
		<div class="alert alert-warning">Only Paypal Payment Method Available Now .</div>
		<div class="form-group">
			<label for="amount">Amount</label>
			<input type="amount" name="amount" class="form-control" id="amount" />
		</div>
		<button type="submit" class="btn btn-default btn-lg btn-block" name="pay">Charge</button>
	</form>
</center>
<?php
include_once 'includes/footer.php';
?>