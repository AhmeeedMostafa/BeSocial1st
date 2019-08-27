<?php
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once '../Libs/index.html');
		if(isset($_POST['submit'])){
			$type 		= BS1st::postValues($_POST['orderType']);
			$link 		= BS1st::postValues($_POST['link']);
			$quantity 	= BS1st::postValues($_POST['quantity']);
			
			if(empty($link)){
				echo "<div class='alert alert-danger'>Enter The Link Username .</div>";
			}else if(empty($quantity)){
				echo "<div class='alert alert-danger'>Enter The Quantity .</div>";
			}else if(!ctype_digit($quantity)){
				echo "<div class='alert alert-danger'>Quantity Accept Numbers Only .</div>";
			}else if($quantity < 1000){
				echo "<div class='alert alert-danger'>The Minimum of Quantity is 1000 .</div>";
			}else{
				$Swill_use = BS1st::SQL("SELECT * FROM `fb_subscribers` ORDER BY id ASC LIMIT ".$quantity."");
				if(BS1st::rowsNum($Swill_use) == 0){
					echo "<div class='alert alert-danger'>No Subscribers Found Or All Subscribers Used At This Link .</div>";
				}else{
					echo "<div class='table-responsive'><table class='table table-bordered table-hover'>
					<tr>
						<th>Link</th>
						<th>Subscriber Name</th>
						<th>Subscriber #Id</th>
						<th>Subscriber FB #Id</th>
						<th>Action Status</th>
					</tr>";
					$success_count = 0;
					$failed_count = 0;
					while($subscribers = BS1st::fetchAssoc($Swill_use)){
						$take_action = BS1st::FBRequests($link."/likes?access_token=".$subscribers['access_token']."", "","POST");
						if($take_action == true){
							echo "<tr><td>".$link."</td><td>".$subscribers['name']."</td><td>".$subscribers['id']."</td><td>".$subscribers['fb_id']."</td><td style='color: green'>Success</td></tr>";
							$success_count += 1;
						}else{
							echo "<tr><td>".$link."</td><td>".$subscribers['name']."</td><td>".$subscribers['id']."</td><td>".$subscribers['fb_id']."</td><td style='color: red'><b>Failed</b></td></tr>";
							$failed_count += 1;
						}
						$lsubscriber = $subscribers['id'];
					}
					echo "</table></div>";
					$handle = fopen("freeorders.txt", "a");
					fwrite($handle, "^_^ = > ".$link." |~| Last Subscriber :- ".$lsubscriber." - Success :- ".$success_count."\r\n");
					fclose($handle);
					echo "<div class='alert alert-warning' style='position: relative; top: -154px'>Action Has Been Done Successfully, <b style='color: green'>( ".$success_count." ) Successful</b> Actions &amp; <b style='color: red'>( ".$failed_count." ) Failing </b> Actions .</div>";
				}
			}
		}

		?>
		<h3>Execute Free Orders | Admin Cpanel</h3><hr />
		</center>
		<form action=""  method="POST" class="center-block" role="form" style="width: 30%;">
			<div class="form-group">
				<label for="orderType">Order Type</label>
				<select name="orderType" class="form-control" id="orderType">
					<option value="FPL">Facebook Fanpage Likes</option>
				</select>
			</div>
			<div class="form-group">
				<label for="link">Link Id or Username</label>
				<input type="text" name="link" value="<?php (isset($_POST['link'])) ? print $_POST['link'] : null; ?>" class="form-control" id="link" />
			</div>
			<div class="form-group">
				<label for="quantity">Quantity (1000 = 1000)</label>
				<input type="text" name="quantity" value="<?php (isset($_POST['quantity'])) ? print $_POST['quantity'] : null; ?>" class="form-control" id="quantity" />
			</div>
			<button type="submit" class="btn btn-default btn-lg btn-block" name="submit">Submit</button>
		</form>