<?php
/**
 * @author Ahmed Mostafa <ahmed.mostafa1198@gmail.com>
 * @copyright (c) 2014, Ahmed Mostafa
 * @version 1.0
 */
 $title = "Orders History";
 require_once 'includes/header.php';
 BS1st::checkSession('user_id', 'username');
 
 $UID = $_SESSION['user_id'];
 $getOrders = BS1st::SQL("SELECT * FROM orders WHERE uid = '".$UID."' ORDER BY id DESC");
 if(BS1st::rowsNum($getOrders) == 0){
	echo "<div class='alert alert-info'>You Didn't Submit Any Order Yet .</div>";
 }else{
	?>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<tr>
				<th>#Id</th>
				<th>Link</th>
				<th>Type</th>
				<th>Quantity</th>
				<th>Success Count</th>
				<th>Remaining Count</th>
				<th>Status</th>
				<th>Completed In</th>
				<th>Date</th>
			</tr>
<?php
	while($order = BS1st::fetchAssoc($getOrders)) :
?>
			<tr>
				<td><?=$order['id'];?></td>
				<td><?=$order['link'];?></td>
				<td><?=$order['type'];?></td>
				<td><?=$order['quantity'];?></td>
				<td><?=$order['success_count'];?></td>
				<td><?=$order['quantity'] - $order['success_count'];?></td>
				<td><?=$order['status'];?></td>
				<td><?=$order['completed_in'];?></td>
				<td><?=$order['date'];?></td>
			</tr>
<?php
	endwhile;
	echo "</table>
	</div>";
 }
 
 include_once 'includes/footer.php';