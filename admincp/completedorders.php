<?php
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once '../Libs/index.html');
	$completedOrders = BS1st::SQL("SELECT * FROM `orders` WHERE status = 'Completed' ORDER BY id DESC");
	if(BS1st::rowsNum($completedOrders) == 0)
		echo "<div class='alert alert-warning'>No Orders Found .</div>";
	else{
	?>
		<h3>Completed Orders | Admin CPanel</h3><br />
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<tr>
				<th>#Id</th>
				<th>user #Id</th>
				<th>Link</th>
				<th>Type</th>
				<th>Quantity</th>
				<th>Success Count</th>
				<th>Date</th>
				<th>Completed In</th>
				<th>Last Subscriber Used</th>
			</tr>
	<?php
		while($orders = BS1st::fetchAssoc($completedOrders)){
			echo "<tr>
				<td>".$orders['id']."</td>
				<td>".$orders['uid']."</td>
				<td>".$orders['link']."</td>
				<td>".$orders['type']."</td>
				<td>".$orders['quantity']."</td>
				<td>".$orders['success_count']."</td>
				<td>".$orders['date']."</td>
				<td>".$orders['completed_in']."</td>
				<td>".$orders['lsubscriber_used']."</td>
			</tr>";
		}
		echo "</table></div>";
	}