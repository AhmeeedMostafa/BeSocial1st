<?php
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once '../Libs/index.html');
	$inProgressOrders = BS1st::SQL("SELECT * FROM `orders` WHERE status = 'In Progress' ORDER BY id DESC");
	if(BS1st::rowsNum($inProgressOrders) == 0)
		echo "<div class='alert alert-warning'>No Orders Found .</div>";
	else{
	?>
		<h3>In Progress Orders | Admin CPanel</h3><br />
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<tr>
				<th>#Id</th>
				<th>user #Id</th>
				<th>Link</th>
				<th>Type</th>
				<th>Quantity</th>
				<th>Success Count</th>
				<th>Remaining Count</th>
				<th>Date</th>
				<th>Last Subscriber Used</th>
				<th>Operations</th>
			</tr>
	<?php
		while($orders = BS1st::fetchAssoc($inProgressOrders)){
			$remainingCount = $orders['quantity'] - $orders['success_count'];
			echo "<tr>
				<td>".$orders['id']."</td>
				<td>".$orders['uid']."</td>
				<td>".$orders['link']."</td>
				<td>".$orders['type']."</td>
				<td>".$orders['quantity']."</td>
				<td>".$orders['success_count']."</td>
				<td>".$remainingCount."</td>
				<td>".$orders['date']."</td>
				<td>".$orders['lsubscriber_used']."</td>
				<td><a href='index.php?execute=".$orders['id']."&link=".$orders['link']."&quantity=".$remainingCount."&type=".$orders['type']."&date=".$orders['date']."' class='btn btn-success' style='font-size: 12px; padding-top: 2px; padding-bottom: 2px'>Continue</a></td>
			</tr>";
		}
		echo "</table></div>";
	}