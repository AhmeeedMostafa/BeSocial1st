<?php
/**
 * @author Ahmed Mostafa <ahmed.mostafa1198@gmail.com>
 * @copyright (c) 2014, Ahmed Mostafa
 * @version 1.0
 */
class BS1st{
    private static $configInf, $database;
    
    function __construct($host, $dbUser, $dbPass, $dbName){
        self::$configInf = array("Host" => $host,
							  "User" => $dbUser,
							  "Pass" => $dbPass,
							  "Name" =>$dbName
							  );
		
		self::$database = mysqli_connect(self::$configInf['Host'], self::$configInf['User'], self::$configInf['Pass'], self::$configInf['Name']);
		if(self::$database == true)
			mysqli_query(self::$database, "SET NAMES 'utf8'");
		else
			die("Mysqli Connect Error, It's It :- ".mysqli_connect_error(self::$database));
    }
	
	public static function SQL($sql){
		return mysqli_query(self::$database, $sql);
	}
	
	public static function SQLwF($sql){
		$query = mysqli_query(self::$database, $sql);
		return mysqli_fetch_assoc($query);
	}
	
	public static function fetchAssoc($sql){
		return mysqli_fetch_assoc($sql);
	}
	
	public static function rowsNum($result){
		return mysqli_num_rows($result);
	}
	
	public static function fieldsNum($result){
		return mysqli_num_fields($result);
	}
	
	public static function freeResult(){
		return mysqli_free_result(self::$database);
	}
	
	public static function closeDB(){
		return mysqli_close(self::$database);
	}
	
	public static function postValues($post){
		return mysqli_real_escape_string(self::$database, trim(htmlentities($post)));
	}
	
	public static function checkSession($sessionName, $sessionName2){
		if(!isset($_SESSION[$sessionName]) || !isset($_SESSION[$sessionName2])){
			header("Location: index.php");
			exit;
		}
	}
	
	public static function FBRequests($Router, $postData, $method){
		if($method == 'POST'){
			$graph_url= "https://graph.facebook.com/{$Router}";
		}else{
			$graph_url= "https://graph.facebook.com/{$Router}?{$postData}"; 
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $graph_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if($method == 'POST'){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		return json_decode($output , true);
	}
	
	public static function InstaRequests($url, $method, $postData){
		// https://api.instagram.com/v1/users/search?q=username&client_id=clientid to get user id
		// https://api.instagram.com/oembed?url=http://instagram.com/p/oAgWLhIUYk to get media id
		$ch = curl_init();
		$instagramUrl = "https://api.instagram.com/v1/";
		curl_setopt($ch, CURLOPT_URL, $instagramUrl.$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($method == 'POST'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		}
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$output = curl_exec($ch);
		if(curl_errno($ch) > 0)
			return "Connect Error :- <b style='color: red'>".curl_error($ch)."</b>".curl_close($ch);
		curl_close($ch);
		return json_decode($output, true);
	}
	
	public static function SocialActions($action, $method, $ChosenSite, $specify = null, $notFB = null, $postData = null){
		$orderId 	= BS1st::postValues($_POST['orderID']);
		$date 		= BS1st::postValues($_POST['orderDate']);
		$type 		= BS1st::postValues($_POST['orderType']);
		$link 		= BS1st::postValues($_POST['link']);
		$quantity 	= BS1st::postValues($_POST['quantity']);
		
		if(empty($orderId) || empty($date) || empty($link) || empty($quantity) || empty($type)){
			echo "<div class='alert alert-danger'>Please Choose The Order You Want Execute It, From Pending or InProgress Orders Page .</div>";
		}else if(!ctype_digit($quantity)){
			echo "<div class='alert alert-danger'>Quantity Accept Numbers Only .</div>";
		}else{
			$getLinkSQL = BS1st::SQL("SELECT * FROM `orders` WHERE id = '".$orderId."' AND link = '".$link."' AND type = '".$type."' AND date = '".$date."'");
			if(BS1st::rowsNum($getLinkSQL) == 0){
				echo "<div class='alert alert-danger'>No links Found With This Id or Link or type or date, Please Be Sure From The Info of the order and try again .</div>";
			}else{
				$getLink = BS1st::fetchAssoc($getLinkSQL);
				if($getLink['notify'] == 1)
					BS1st::SQL("UPDATE `orders` SET notify = '0' WHERE id = '".$getLink['id']."'");
				if($ChosenSite == "facebook" || $ChosenSite == "Facebook"){
					$Swill_use = BS1st::SQL("SELECT * FROM `fb_subscribers` WHERE id > '".$getLink['lsubscriber_used']."' ".$specify." ORDER BY id ASC LIMIT ".$quantity."");
					$request = "FBRequests";
				}else if($ChosenSite == "instagram" || $ChosenSite == "Instagram"){
					$Swill_use = BS1st::SQL("SELECT * FROM `insta_subscribers` WHERE id > '".$getLink['lsubscriber_used']."' ".$specify." ORDER BY id ASC LIMIT ".$quantity."");
					$request = "InstaRequests";
					if(stripos($type, "Instafollowers") !== false){
						$instaLink = BS1st::InstaRequests("users/search?q=".$getLink['link']."&client_id=e81596b9fcbc466cbf2a6b91de396a3a", "GET", null);
						(isset($instaLink['data'][0]['id'])) ? $getLink['link'] = $instaLink['data'][0]['id'] : '';
					}else{
						$instaLink = BS1st::InstaRequests("oembed?url=http://instagram.com/p/".$getLink['link'], "GET", null);
						(isset($instaLink['media_id'])) ? $getLink['link'] = $instaLink['media_id'] : '';
					}
				}
				if(BS1st::rowsNum($Swill_use) == 0){
					echo "<div class='alert alert-danger'>No Subscribers Found Or All Subscribers Used At This Link .</div>";
				}else{
					echo "<div class='table-responsive'><table class='table table-bordered table-hover'>
					<tr>
						<th>#Id</th>
						<th>Link</th>
						<th>Subscriber Name</th>
						<th>Subscriber #Id</th>
						<th>Subscriber Chosen Site #Id</th>
						<th>Action Status</th>
					</tr>";
					$success_count = 0;
					$failed_count = 0;
					while($subscribers = BS1st::fetchAssoc($Swill_use)){
						$take_action = BS1st::$request($notFB.$getLink['link']."/".$action."?access_token=".$subscribers['access_token'], $method, $postData);
						if($take_action == true && !isset($take_action['meta']['error_message'])){
							echo "<tr><td>".$getLink['id']."</td><td>".$getLink['link']."</td><td>".$subscribers['name']."</td><td>".$subscribers['id']."</td><td>".$subscribers['csite_id']."</td><td style='color: green'>Success</td></tr>";
							$success_count += 1;
							$lsuccess_user = $subscribers['id'];
						}else{
							echo "<tr><td>".$getLink['id']."</td><td>".$getLink['link']."</td><td>".$subscribers['name']."</td><td>".$subscribers['id']."</td><td>".$subscribers['csite_id']."</td><td style='color: red'><b>Failed </b>";
							(isset($take_action['meta']['error_message'])) ? print $take_action['meta']['error_message'] : '';
							echo "</td></tr>";
							$failed_count += 1;
						}
						$lsubscriber = $subscribers['id'];
					}
					echo "</table></div>";
					if($getLink['success_count'] + $success_count >= $getLink['quantity']){
						$updateInfo = BS1st::SQL("UPDATE `orders` SET lsubscriber_used = '".$lsuccess_user."', success_count = success_count + '".$success_count."', completed_in = '".date("Y/m/d - h:i:s a")."', status = 'Completed' WHERE id = '".$getLink['id']."'");
						$updateAdminExec = BS1st::SQL("UPDATE `admin` SET exec_orders_no = exec_orders_no + '1' WHERE id = '".$_SESSION['admin_id']."'");
					}else{
						$updateInfo = BS1st::SQL("UPDATE `orders` SET lsubscriber_used = '".$lsubscriber."', success_count = success_count + '".$success_count."', status = 'In Progress' WHERE id = '".$getLink['id']."'");
					}
					if(isset($updateInfo))
						echo "<div class='alert alert-warning' style='position: relative; top: -154px'>Action Has Been Done Successfully, <b style='color: green'>( ".$success_count." ) Successful</b> Actions &amp; <b style='color: red'>( ".$failed_count." ) Failing </b> Actions .</div>";
				}
			}
		}
	}
}
