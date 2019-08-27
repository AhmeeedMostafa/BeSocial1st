<?php
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once '../Libs/index.html');
	$pendingOrders = BS1st::SQL("SELECT * FROM `orders` WHERE status = 'Pending' ORDER BY id DESC");
	if(BS1st::rowsNum($pendingOrders) == 0)
		echo "<div class='alert alert-warning'>No Orders Found .</div>";
	else{
		if(isset($_REQUEST['Notified']) && isset($_GET['id'])){
			BS1st::SQL("UPDATE `orders` SET notify = '0' WHERE id = '".intval($_GET['id'])."'");
			header("Location: index.php?page=pendingorders");
		}
		if(isset($_REQUEST['cancel']) && isset($_GET['id'])){
			$price = BS1st::SQLwF("SELECT * FROM `orders` WHERE id = '".intval($_GET['id'])."'");
			BS1st::SQL("UPDATE `orders` SET status = 'Cancelled' WHERE id = '".intval($_GET['id'])."'");
			BS1st::SQL("UPDATE `users` SET balance = balance + '".$price['price']."' WHERE id = '".$price['uid']."'");
			header("Location: index.php?pendingorders");
		}
	?>
		<h3>Pending Orders | Admin CPanel</h3><br />
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<tr>
				<th>#Id</th>
				<th>user #Id</th>
				<th>Link</th>
				<th>Type</th>
				<th>Quantity</th>
				<th>Date</th>
				<th>Last Subscriber Used</th>
				<th>Operations</th>
			</tr>
	<?php
		while($orders = BS1st::fetchAssoc($pendingOrders)){
			if($orders['notify'] == 1){
				echo "<tr class='info'>
					<td>".$orders['id']."</td>
					<td>".$orders['uid']."</td>
					<td>".$orders['link']."</td>
					<td>".$orders['type']."</td>
					<td>".$orders['quantity']."</td>
					<td>".$orders['date']."</td>
					<td>".$orders['lsubscriber_used']."</td>
					<td><a href='index.php?execute=".$orders['id']."&link=".$orders['link']."&quantity=".$orders['quantity']."&type=".$orders['type']."&date=".$orders['date']."' class='btn btn-success' style='font-size: 12px; padding-top: 2px; padding-bottom: 2px'>Execute</a>&nbsp;<a href='index.php?page=pendingorders&Notified&id=".$orders['id']."' class='btn btn-info' style='font-size: 12px; padding-top: 2px; padding-bottom: 2px'>Notified</a>&nbsp;<a href='index.php?page=pendingorders&cancel&id=".$orders['id']."' class='btn btn-danger' style='font-size: 12px; padding-top: 2px; padding-bottom: 2px'>Cancel</a></td>
				</tr>";
			}else{
				echo "<tr>
					<td>".$orders['id']."</td>
					<td>".$orders['uid']."</td>
					<td>".$orders['link']."</td>
					<td>".$orders['type']."</td>
					<td>".$orders['quantity']."</td>
					<td>".$orders['date']."</td>
					<td>".$orders['lsubscriber_used']."</td>
					<td><a href='index.php?execute=".$orders['id']."&link=".$orders['link']."&quantity=".$orders['quantity']."&type=".$orders['type']."&date=".$orders['date']."' class='btn btn-success' style='font-size: 12px; padding-top: 2px; padding-bottom: 2px'>Execute</a>&nbsp;<a href='index.php?page=pendingorders&cancel&id=".$orders['id']."' class='btn btn-danger' style='font-size: 12px; padding-top: 2px; padding-bottom: 2px'>Cancel</a></td>
				</tr>";
			}
		}
		echo "</table></div>";
	}