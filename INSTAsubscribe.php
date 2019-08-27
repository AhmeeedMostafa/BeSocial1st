<?php $title = "Instagram Subscribe"; require_once "includes/header.php"; require_once "visitorlocation/loc.php" ?>
<script type="text/javascript">
	if(location.hash){
		var $hash = location.hash.replace('#access_token=', '');
		var $q = location.search;

		if($q.search('done=true&') == -1) {
			location.href = '?done=true&access_token='+$hash;
		}
	}
</script>
<center>


<?php
if(isset($_GET['access_token']) && isset($_GET['done'])){
		$access_token = $_GET['access_token'];
		if(empty($access_token) || empty($_GET['done'])){
			echo "<div class='alert alert-danger'>Please, Go LogIn Again &amp; Don't Make Any Thing Till You Get The Success Message .</div>";
		}else{
			$checkAccess_token = BS1st::InstaRequests("users/self/?access_token=".$access_token, "GET", null);
			if(isset($checkAccess_token['meta']['error_type'])){
				if($checkAccess_token['meta']['error_message'] == "The access_token provided is invalid.")
					echo "<div class='alert alert-danger'>Invalid Access Token .</div>";
				else
					echo "<div class='alert alert-danger'>".$checkAccess_token['meta']['error_message']."</div>";
			}else{
				$SID = $checkAccess_token['data']['id']; // subscriber ID
				$getSameId = BS1st::SQL("SELECT * FROM insta_subscribers WHERE csite_id = '".$SID."'");
				if(BS1st::rowsNum($getSameId) >= 1){
					echo "<div class='alert alert-danger'>This User Is Subscriber With Us Before .</div>";
				}else{
					$SAT = $access_token; // subscriber Access Token
					$SNE = $checkAccess_token['data']['full_name']; // subscriber Name
					$SCY = $Country_Name; // Country Name
					$SCC = $Country_Code3; // Country Name Code 2 letters
					$SCT = $Continent_Name; // Continent Name
					$STC = $Continent_Code; //Continent Name Code
					$SSD = date("Y/m/d - h:i:s a"); // subscriber subscribe Date
					switch($SCY){
						case "Iran" :
							$SCG = "khaligy"; // subscriber Category
						break;
						case "Saudi Arabia" :
							$SCG = "khaligy"; // subscriber Category
						break;
						case "United Arab Emirates" :
							$SCG = "khaligy"; // subscriber Category
						break;
						case "Kuwait" :
							$SCG = "khaligy"; // subscriber Category
						break;
						case "Qatar" :
							$SCG = "khaligy"; // subscriber Category
						break;
						case "Oman" :
							$SCG = "khaligy"; // subscriber Category
						break;
						case "Bahrain" :
							$SCG = "khaligy"; // subscriber Category
						break;
						case "Iraq" :
							$SCG = "khaligy"; // subscriber Category
						break;
						default :
							($SCY == 'Egypt' || $SCY == 'Yemen' || $SCY == 'Sudan' || $SCY == 'Libya' || $SCY == 'Tunisia' || $SCY == 'Algeria' || $SCY == 'Morocco' || $SCY == 'Mauritania' || $SCY == 'Somalia' || $SCY == 'Djibouti' || $SCY == 'Jordan' || $SCY == 'Syria' || $SCY == 'Lebanon' || $SCC == 'PS' || $SCY == 'Comoros') ? $SCG = "araby" : $SCG = "agnaby";
						break;
					}
					$addsubscriber = BS1st::SQL("INSERT INTO `insta_subscribers` (access_token, csite_id, name, country, category, date, country_code, continent, continent_code) VALUES ('".$SAT."', '".$SID."', '".$SNE."', '".$SCY."', '".$SCG."', '".$SSD."', '".$SCC."', '".$SCT."', '".$STC."')");
					if($addsubscriber == true)
						echo "<div class='alert alert-success'>You Have Been Subscriber With Us Successfully .</div>";
				}
			}
		}
	}
?>
<br />
<br />
<br />
<br />
<br />
<h3 class="alert alert-info">Go To This Link <a href="https://instagram.com/oauth/authorize/?client_id=e81596b9fcbc466cbf2a6b91de396a3a&scope=likes+relationships+comments+basic&redirect_uri=http://localhost/besocial1st/instasubscribe.php&response_type=token">Here</a> &amp; Accept On The Permissions</h3>
<br />
<br />
<h4 class='alert alert-warning'><span style='color: red'>Note : </span><span style='color: #f80'>We Will Use Your Access Token in Making Like & Follow For Profiles on Instagram .</span></h4>
</center>
<?php include_once "includes/footer.php"; ?>