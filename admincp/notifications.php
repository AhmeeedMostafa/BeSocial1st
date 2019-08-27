<?php
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once '../Libs/index.html');
$getOrders2Notify = BS1st::SQL("SELECT * FROM `orders` WHERE notify = '1' AND status = 'Pending' ORDER BY id DESC");
$notifyOrder = BS1st::rowsNum($getOrders2Notify);
if($notifyOrder != 0) : ?>
	<span class='alert alert-info' style='padding: 10px'><?=$notifyOrder;?></span>
<?php endif; ?>