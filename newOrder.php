<?php if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once 'Libs/index.html'); ?>
<form action=""  method="POST" class="center-block" role="form" style="width: 30%;">
<?php
BS1st::checkSession('user_id', 'username');
	if(isset($_POST['order'])){
		$UID 		= $_SESSION['user_id'];
		$type 		= BS1st::postValues($_POST['type']);
		$link 		= BS1st::postValues($_POST['link']);
		$quantity 	= BS1st::postValues($_POST['quantity']);
		$date 		= date("Y/m/d - h:i:s a");
		
		if(empty($link)){
			echo "<div class='alert alert-danger'>Link Field Required .</div>";
		}else if(empty($quantity)){
			echo "<div class='alert alert-danger'>Quantity Field Required .</div>";
		}else if(!ctype_digit($quantity)){
			echo "<div class='alert alert-danger'>Quantity Accept Numbers Only .</div>";
		}else if((stripos($type, "comment") || stripos($type, "post")) && $quantity < 200){
			echo "<div class='alert alert-danger'>The Minimum of Quantity is 200 .</div>";
		}else if($quantity < 1000){
			echo "<div class='alert alert-danger'>The Minimum of Quantity is 1000 .</div>";
		}else{
			switch($type) :
				case "FBpageWorldLikes" : 
					$price = 0.60 * ($quantity / 1000);
				break;
				case "FBpageForeignLikes" :
					$price = 0.70 * ($quantity / 1000);
				break;
				case "FBpageArabicLikes" :
					$price = 0.80 * ($quantity / 1000);
				break;
				case "FBpageGulfLikes" :
					$price = 0.90 * ($quantity / 1000);
				break;
				case "FBpostWorldLikes" : 
					$price = 0.35 * ($quantity / 1000);
				break;
				case "FBpostForeignLikes" :
					$price = 0.40 * ($quantity / 1000);
				break;
				case "FBpostArabicLikes" :
					$price = 0.45 * ($quantity / 1000);
				break;
				case "FBpostGulfLikes" :
					$price = 0.50 * ($quantity / 1000);
				break;
				case "FBcommentWorldLikes" : 
					$price = 0.35 * ($quantity / 1000);
				break;
				case "FBcommentForeignLikes" :
					$price = 0.40 * ($quantity / 1000);
				break;
				case "FBcommentArabicLikes" :
					$price = 0.45 * ($quantity / 1000);
				break;
				case "FBcommentGulfLikes" :
					$price = 0.50 * ($quantity / 1000);
				break;
				case "InstafollowersWorldFollowers" :
					$price = 0.70 * ($quantity / 1000);
				break;
				case "InstafollowersForeignFollowers" :
					$price = 0.80 * ($quantity / 1000);
				break;
				case "InstafollowersArabicFollowers" :
					$price = 0.90 * ($quantity / 1000);
				break;
				case "InstafollowersGulfFollowers" :
					$price = 1.00 * ($quantity / 1000);
				break;
				case "InstalikesWorldLikes" :
					$price = 0.65 * ($quantity / 1000);
				break;
				case "InstalikesForeignLikes" :
					$price = 0.75 * ($quantity / 1000);
				break;
				case "InstalikesArabicLikes" :
					$price = 0.85 * ($quantity / 1000);
				break;
				case "InstalikesGulfLikes" :
					$price = 0.95 * ($quantity / 1000);
				break;
			endswitch;
			$getUser = BS1st::SQLwF("SELECT balance FROM `users` WHERE id = '".$UID."'");
			if($getUser['balance'] < $price){
				echo "<div class='alert alert-danger'>You Do not have Enough Balance To Submit This Order .</div>";
			}else{
				$newOrder = BS1st::SQL("INSERT INTO `orders` (uid, type, link, quantity, date, status, lsubscriber_used, success_count, completed_in, notify, price) VALUES ('".$UID."', '".$type."', '".$link."', '".$quantity."', '".$date."', 'Pending', '0', '0', '0', '1', '".$price."')");
				$updateBalance = BS1st::SQL("UPDATE `users` SET balance = balance - '".$price."' WHERE id = '".$UID."'");
				if($newOrder == true && $updateBalance == true)
					echo "<div class='alert alert-success'>Order Has Been Submited Successfully, it will finish with in 24 hours .</div>";
				else
					echo "<div class='alert alert-danger'>There is something wrong please try again later .</div>";
			}
		}
	}
?>
    <div class="form-group">
        <label for="type">Order Type</label>
        <select name="type" class="form-control" id="type">
			<option value="FBpageWorldLikes">Facebook Fanpage, World Likes (1000 = 0.60$)</option>
			<option value="FBpageForeignLikes">Facebook Fanpage, Foreign Likes (1000 = 0.70$)</option>
			<option value="FBpageArabicLikes">Facebook Fanpage, Arabic Likes (1000 = 0.80$)</option>
			<option value="FBpageGulfLikes">Facebook Fanpage, Gulf Likes (1000 = 0.90$)</option>
			<option value="FBpostWorldLikes">Facebook Post, World Likes (200 = 0.35$)</option>
			<option value="FBpostForeignLikes">Facebook Post, Foreign Likes (200 = 0.40$)</option>
			<option value="FBpostArabicLikes">Facebook Post, Arabic Likes (200 = 0.55$)</option>
			<option value="FBpostGulfLikes">Facebook Post, Gulf Likes (200 = 0.50$)</option>
			<option value="FBcommentWorldLikes">Facebook Comment, World Likes (200 = 0.35$)</option>
			<option value="FBcommentForeignLikes">Facebook Comment, Foreign Likes (200 = 0.40$)</option>
			<option value="FBcommentArabicLikes">Facebook Comment, Arabic Likes (200 = 0.45$)</option>
			<option value="FBcommentGulfLikes">Facebook Comment, Gulf Likes (200 = 0.50$)</option>
			<option value="InstafollowersWorldFollowers">Instagram Followers, World Followers (1000 = 0.70$)</option>
			<option value="InstafollowersForeignFollowers">Instagram Followers, Foreign Followers (1000 = 0.80$)</option>
			<option value="InstafollowersArabicFollowers">Instagram Followers, Arabic Followers (1000 = 0.90$)</option>
			<option value="InstafollowersGulfFollowers">Instagram Followers, Gulf Followers (1000 = 1.00$)</option>
			<option value="InstalikesWorldLikes">Instagram Likes, World Likes (1000 = 0.65$)</option>
			<option value="InstalikesForeignLikes">Instagram Likes, Foreign Likes (1000 = 0.75$)</option>
			<option value="InstalikesArabicLikes">Instagram Likes, Arabic Likes (1000 = 0.85$)</option>
			<option value="InstalikesGulfLikes">Instagram Likes, Gulf Likes (1000 = 0.95$)</option>
		</select>
    </div>
    <div class="form-group">
        <label for="link">Link Id or Username <br />(Ex : https://ex.com/<u>123456789</u> or <u>test</u>)</label>
        <input type="text" name="link" placeholder='Ex : testpage' value="<?php (isset($_POST['link'])) ? print $_POST['link'] : null; ?>" class="form-control" id="link" />
    </div>
	<div class="form-group">
        <label for="quantity">Quantity (1000 = 1000)</label>
        <input type="text" name="quantity" value="<?php (isset($_POST['quantity'])) ? print $_POST['quantity'] : null; ?>" class="form-control" id="quantity" />
    </div>
    <button type="submit" class="btn btn-default btn-lg btn-block" name="order">Order</button>
</form>