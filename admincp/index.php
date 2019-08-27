<?php
$title = "Admin CPanel";
require_once '../includes/admin_header.php';
if(!isset($_SESSION['user_id']) && !isset($_SESSION['username'])){
	header("Location: ../index.php");
	exit;
}else if(!isset($_SESSION['admin_id'])){
	if(isset($_POST['adminlogin'])){
		$adminname = BS1st::postValues($_POST['adminname']);
		$adminpass = BS1st::postValues($_POST['adminpass']);
		$getAdmin = BS1st::SQL("SELECT * FROM `admins` WHERE adminname = '".$adminname."' AND adminpass = '".$adminpass."'");
		if(BS1st::rowsNum($getAdmin) == 0)
			echo "<div class='alert alert-danger'>Admin name or password is Wrong .</div>";
		else{
			$admin = BS1st::fetchAssoc($getAdmin);
			$_SESSION['admin_id'] = $admin['id'];
			header("Location: index.php");
		}
	}
?>
	<form action=""  method="POST" class="center-block" role="form" style="width: 30%;">
		<div class="form-group">
			<label for="adminname">Admin name</label>
			<input type="text" name="adminname" class="form-control" id="adminname" />
		</div>
		<div class="form-group">
			<label for="adminpass">Admin Password</label>
			<input type="password" name="adminpass" class="form-control" id="adminpass" />
		</div>
		<button type="submit" class="btn btn-default btn-lg btn-block" name="adminlogin">Admin - Log In</button>
	</form>
<?php
}else{
	echo "<br /><center>";
	if(!isset($_GET['page'])){
		if(isset($_POST['submit'])){
			$orderType = BS1st::postValues($_POST['orderType']);
			switch($orderType){
				case "FBpageWorldLikes" : 
					BS1st::SocialActions("likes", "POST", "Facebook");
				break;
				case "FBpageForeignLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'agnaby'");
				break;
				case "FBpageArabicLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'arabic' OR category = 'khaligy'");;
				break;
				case "FBpageGulfLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'khaligy'");;
				break;
				case "FBpostWorldLikes" : 
					BS1st::SocialActions("likes", "POST", "Facebook");
				break;
				case "FBpostForeignLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'agnaby'");
				break;
				case "FBpostArabicLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'arabic' OR category = 'khaligy'");;
				break;
				case "FBpostGulfLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'khaligy'");;
				break;
				case "FBcommentWorldLikes" : 
					BS1st::SocialActions("likes", "POST", "Facebook");
				break;
				case "FBcommentForeignLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'agnaby'");
				break;
				case "FBcommentArabicLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'arabic' OR category = 'khaligy'");;
				break;
				case "FBcommentGulfLikes" :
					BS1st::SocialActions("likes", "POST", "Facebook", "AND category = 'khaligy'");;
				break;
				case "InstafollowersWorldFollowers" :
					BS1st::SocialActions("relationship", "POST", "Instagram", null, "users/", "action=follow");
				break;
				case "InstafollowersForeignFollowers" :
					BS1st::SocialActions("relationship", "POST", "Instagram", "AND category = 'agnaby'", "users/", "action=follow");
				break;
				case "InstafollowersArabicFollowers" :
					BS1st::SocialActions("relationship", "POST", "Instagram", "AND category = 'arabic' OR category = 'khaligy'", "users/", "action=follow");
				break;
				case "InstafollowersGulfFollowers" :
					BS1st::SocialActions("relationship", "POST", "Instagram", "AND category = 'khaligy'", "users/", "action=follow");
				break;
				case "InstalikesWorldLikes" :
					BS1st::SocialActions("likes", "POST", "Instagram", null, "media/");
				break;
				case "InstalikesForeignLikes" :
					BS1st::SocialActions("likes", "POST", "Instagram", "AND category = 'agnaby'", "media/");
				break;
				case "InstalikesArabicLikes" :
					BS1st::SocialActions("likes", "POST", "Instagram", "AND category = 'arabic' OR category = 'khaligy'", "media/");
				break;
				case "InstalikesGulfLikes" :
					BS1st::SocialActions("likes", "POST", "Instagram", "AND category = 'khaligy'", "media/");
				break;
			}
		}

		?>
		<h3>Execute Orders | Admin Cpanel</h3>
		<h4>:. Statics .:</h4>
		<?php
			//Facebook Statics
			$FBworldSQL 			= BS1st::SQL("SELECT * FROM `fb_subscribers`");
			$FBworld 				= BS1st::rowsNum($FBworldSQL);
			$FBforeignSQL 			= BS1st::SQL("SELECT * FROM `fb_subscribers` WHERE category = 'agnaby'");
			$FBforeign 				= BS1st::rowsNum($FBforeignSQL);
			$FBarabicSQL 			= BS1st::SQL("SELECT * FROM `fb_subscribers` WHERE category = 'araby'");
			$FBarabic 				= BS1st::rowsNum($FBarabicSQL);
			$FBgulfSQL 				= BS1st::SQL("SELECT * FROM `fb_subscribers` WHERE category = 'khaligy'");
			$FBgulf					= BS1st::rowsNum($FBgulfSQL);
			//Instagram Statics
			$InstaworldSQL 			= BS1st::SQL("SELECT * FROM `insta_subscribers`");
			$Instaworld 			= BS1st::rowsNum($InstaworldSQL);
			$InstaforeignSQL 		= BS1st::SQL("SELECT * FROM `insta_subscribers` WHERE category = 'agnaby'");
			$Instaforeign 			= BS1st::rowsNum($InstaforeignSQL);
			$InstaarabicSQL 		= BS1st::SQL("SELECT * FROM `insta_subscribers` WHERE category = 'araby'");
			$Instaarabic 			= BS1st::rowsNum($InstaarabicSQL);
			$InstagulfSQL 			= BS1st::SQL("SELECT * FROM `insta_subscribers` WHERE category = 'khaligy'");
			$Instagulf				= BS1st::rowsNum($InstagulfSQL);
		?>
		<p style='font-size: 18px'>:. Facebook .: World Subscribers = > ( <b style='color: brown'><?=$FBworld;?></b> ) |~| 
		Foreign Subscribers = > ( <b style='color: red'><?=$FBforeign;?></b> ) |~| 
		Arabic Subscribers = > ( <b style='color: green'><?=$FBarabic;?></b> ) |~| 
		Gulf Subscribers = > ( <b style='color: blue'><?=$FBgulf;?></b> )</p>
		<p style='font-size: 18px'>:. Instagram .: World Subscribers = > ( <b style='color: brown'><?=$Instaworld;?></b> ) |~| 
		Foreign Subscribers = > ( <b style='color: red'><?=$Instaforeign;?></b> ) |~| 
		Arabic Subscribers = > ( <b style='color: green'><?=$Instaarabic;?></b> ) |~| 
		Gulf Subscribers = > ( <b style='color: blue'><?=$Instagulf;?></b> )</p>
		<hr />
		</center>
			<?php if(isset($_GET['type'])) echo "<center><div class='alert alert-info'>The Order Type IS : <b style='color: #f80'>".$_GET['type']."</b></div></center>"; ?>
		<form action=""  method="POST" class="center-block" role="form" style="width: 30%;">
			<div class="form-group">
				<label for="link">Link Id or Username</label>
				<input type="text" name="link" readonly="readonly" value="<?php (isset($_GET['link'])) ? print $_GET['link'] : null; ?>" class="form-control" id="link" />
			</div>
			<div class="form-group">
				<label for="quantity">Quantity (1000 = 1000)</label>
				<input type="text" name="quantity" value="<?php (isset($_GET['quantity'])) ? print $_GET['quantity'] : null; ?>" class="form-control" id="quantity" />
				<input type="hidden" name="orderDate" value="<?php (isset($_GET['date'])) ? print $_GET['date'] : null;?>" class="form-control" />
				<input type="hidden" name="orderID" value="<?php (isset($_GET['execute'])) ? print $_GET['execute'] : null;?>" class="form-control" />
				<input type="hidden" name="orderType" value="<?php (isset($_GET['type'])) ? print $_GET['type'] : null;?>" class="form-control" />
			</div>
			<button type="submit" class="btn btn-default btn-lg btn-block" name="submit">Submit</button>
		</form>

	<?php
	}else{
		echo "<center>";
		$page = $_GET['page'];
		if(empty($page))
			echo "<div class='alert alert-danger'>Enter The Page Name .</div>";
		else{
			$page .= ".php";
			if(file_exists($page)){
				require_once $page;
			}else{
				echo "<div class='alert alert-danger'>The Page Not Found ...</div>";
			}
		}
		echo "</center>";
	}
}
include_once '../includes/footer.php';
?>