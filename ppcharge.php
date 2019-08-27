<?php

/*****************************************************************
*    Advanced Membership System                                  *
*    Copyright (c) 2012 MasDyn Studio, All Rights Reserved.      *
*****************************************************************/
(isset($_GET['action']) && $_GET['action'] == "cancel") ? $title = "Canceled" : $title = "Charge";

require_once 'includes/header.php';
require_once 'paypal_charge/paypal.class.php';

$pp = new paypal(); // initiate an instance

define("PAYPAL_SANDBOX", "NO");
define("PAYPAL_EMAIL", "ahmed.mostafa1198@gmail.com");
define("CURRENCY_CODE", "USD");

if(PAYPAL_SANDBOX == "YES"){
	$pp->paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$pp->paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}

$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	
if(isset($_POST['pay'])) {
	$item_price = BS1st::postValues($_POST['amount']);
	if(empty($item_price)){
		$_SESSION['charge_msg'] = "Please, Insert The Amount You Want To Charge it .";
		header("Location: balance.php?error=1");
	}else if($item_price < 10){
		$_SESSION['charge_msg'] = "Sorry, The Minimum of Amount is $10 .";
		header("Location: balance.php?error=2");
	}else{
		$pp_item_name = "Charge Balance $".$item_price." To ".$_SERVER['HTTP_HOST'];
		$pp_item_price = $item_price;
		$user_id = $_SESSION['user_id'];
		$amount = $pp_item_price;
		$custom = "add//".$user_id."//".$amount;
	}
}

// if no action variable, set 'process' as default action
if (empty($_GET['action'])) $_GET['action'] = 'process';

switch ($_GET['action']) {
	case 'process': // Process and order...
		$pp->add_field('business', PAYPAL_EMAIL);
		$pp->add_field('return', $this_script.'?action=success');
		$pp->add_field('cancel_return', $this_script.'?action=cancel');
		$pp->add_field('notify_url', $this_script.'?action=ipn');
		$pp->add_field('item_name', $pp_item_name);
		$pp->add_field('amount', $pp_item_price);
		$pp->add_field('currency_code', CURRENCY_CODE);
		$pp->add_field('custom', $custom);
		$pp->submit_paypal_post();
	break;
	case 'success': // successful order...
		$_SESSION['charge_msg'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Thank You, your payment has been received &amp; Your Balance Has Been Updated.</div>";
		header("Location: ../balance.php");
	break;
	case 'cancel': // Canceled Order...
		echo "<h2>The order was canceled.</h2>";
	break;
	case 'ipn': // For IPN validation...
		if ($pp->validate_ipn()) {
			if($pp->ipn_data['payment_status'] == "Completed"){
				$return_data = explode("//", $pp->ipn_data['custom']);
				if($return_data[0] == "add"){
					BS1st::SQL("UPDATE `users` SET balance = balance + '".$return_data[2]."' WHERE id = '".$return_data[1]."'");
				}
			}
		}
	break;
}
include_once "includes/footer.php";
?>