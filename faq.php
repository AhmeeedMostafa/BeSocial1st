<?php
$title = "FAQ";
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__))
	require_once 'includes/header.php';
$SworldCountSql 	= BS1st::SQL("SELECT * FROM `fb_subscribers`");
$SforeignCountSql 	= BS1st::SQL("SELECT * FROM `fb_subscribers` WHERE category = 'agnaby'");
$SarabicCountSql 	= BS1st::SQL("SELECT * FROM `fb_subscribers` WHERE category = 'araby'");
$SgulfCountSql 		= BS1st::SQL("SELECT * FROM `fb_subscribers` WHERE category = 'araby' OR category = 'khaligy'");

$SworldCount 		= BS1st::rowsNum($SworldCountSql);
$SforeignCount 		= BS1st::rowsNum($SforeignCountSql);
$SarabicCount 		= BS1st::rowsNum($SarabicCountSql);
$SgulfCount 		= BS1st::rowsNum($SgulfCountSql);

$SinstaworldCountSql 		= BS1st::SQL("SELECT * FROM `insta_subscribers`");
$SinstaforeignCountSql 		= BS1st::SQL("SELECT * FROM `insta_subscribers` WHERE category = 'agnaby'");
$SinstaarabicCountSql 		= BS1st::SQL("SELECT * FROM `insta_subscribers` WHERE category = 'araby' OR category = 'khaligy'");
$SinstagulfCountSql 		= BS1st::SQL("SELECT * FROM `insta_subscribers` WHERE category = 'khaligy'");

$SinstaworldCount 			= BS1st::rowsNum($SinstaworldCountSql);
$SinstaforeignCount 		= BS1st::rowsNum($SinstaforeignCountSql);
$SinstaarabicCount 			= BS1st::rowsNum($SinstaarabicCountSql);
$SinstagulfCount 			= BS1st::rowsNum($SinstagulfCountSql);
?>
<div style="padding-left: 100px">
<h3 style="font-weight: bold">* Our Services FAQs *</h3>
<p>
All Usernames or ObjectID you Insert Must Be Valid And The Right One You Want the service Execute to it ...
<br />
- Our Service Execute By Sites' Admin To Review The Order's Link First And Check The Link's Contains ...
<br />
- Our Service Isn't Get Much Time In Execute it's Few Hours Take To start Execute The Order But The Order Complete In The Same Time We Start ...
<br />
- We Accept Only PayPal Method Till Now To Charge Your Account, Maybe Soon Will Be available Other Methods :) ...
<br />
<b><u>- Maximum Order Per One Page/Profile :</u></b>
<ul>
	<li>Facebook Page, Post &amp; Comment World Likes => <b><?=$SworldCount;?></b></li>
	<li>Facebook Page, Post &amp; Comment Foreign Likes => <b><?=$SforeignCount;?></b></li>
	<li>Facebook Page, Post &amp; Comment Arabic Likes => <b><?=$SarabicCount;?></b></li>
	<li>Facebook Page, Post &amp; Comment Gulf Likes => <b><?=$SgulfCount;?></b></li>
	<li>Instagram Profile &amp; Pictures World Followers/Likes => <b><?=$SinstaworldCount;?></b></li>
	<li>Instagram Profile &amp; Pictures Foreign Followers/Likes => <b><?=$SinstaforeignCount;?></b></li>
	<li>Instagram Profile &amp; Pictures Arabic Followers/Likes => <b><?=$SinstaarabicCount;?></b></li>
	<li>Instagram Profile &amp; Pictures Gulf Followers/Likes => <b><?=$SinstagulfCount;?></b></li>
</ul>
<b><u>- How To Fill Field Link Into Order :</u></b>
<br />
&nbsp;Correct Entry Is The <b>Object ID</b> or <b>Object Username</b> only without the domain link , Example : http://ex.com/<b>myid</b> , "<b>myid</b>" is the Object ID or Object Username So The Correct Entry Will be : <b>myid</b>
<br />
<br />
<b>- Soon Will Available Other Social Sites Services ...</b>
<br />
<br />
<b><u>- Services Prices :</u></b>
<ul>
	<li>Facebook Fanpage, World Likes <b>(1000 = 0.60$)</b></li>
	<li>Facebook Fanpage, Foreign Likes <b>(1000 = 0.70$)</b></li>
	<li>Facebook Fanpage, Arabic Likes <b>(1000 = 0.80$)</b></li>
	<li>Facebook Fanpage, Gulf Likes <b>(1000 = 0.90$)</b></li>
	<li>Facebook Post, World Likes <b>(200 = 0.35$)</b></li>
	<li>Facebook Post, Foreign Likes <b>(200 = 0.40$)</b></li>
	<li>Facebook Post, Arabic Likes <b>(200 = 0.55$)</b></li>
	<li>Facebook Post, Gulf Likes <b>(200 = 0.50$)</b></li>
	<li>Facebook Comment, World Likes <b>(200 = 0.35$)</b></li>
	<li>Facebook Comment, Foreign Likes <b>(200 = 0.40$)</b></li>
	<li>Facebook Comment, Arabic Likes <b>(200 = 0.45$)</b></li>
	<li>Facebook Comment, Gulf Likes <b>(200 = 0.50$)</b></li>
	<li>Instagram Followers, World Followers <b>(1000 = 0.70$)</b></li>
	<li>Instagram Followers, Foreign Followers <b>(1000 = 0.80$)</b></li>
	<li>Instagram Followers, Arabic Followers <b>(1000 = 0.90$)</b></li>
	<li>Instagram Followers, Gulf Followers <b>(1000 = 1.00$)</b></li>
	<li>Instagram Likes, World Likes <b>(1000 = 0.65$)</b></li>
	<li>Instagram Likes, Foreign Likes <b>(1000 = 0.75$)</b></li>
	<li>Instagram Likes, Arabic Likes <b>(1000 = 0.85$)</b></li>
	<li>Instagram Likes, Gulf Likes <b>(1000 = 0.95$)</b></li>
</ul>
<br />
<b><u>- Orders Status</u></b>
<ul>
	<li>Pending     :- Under Revision</li>
	<li>In Progress :- Working on it</li>
	<li>Completed   :- Finished</li>
	<li>Cancelled   :- Rejected | order cancel reasons :- the page had the maximum order OR the page rejected by the admin .</li>
</ul>
<br />
<b>- These FAQs For Using Our Site <a href="http://<?=$_SERVER['HTTP_HOST'];?>" title="<?=$_SERVER['HTTP_HOST'];?>"><?=$_SERVER['HTTP_HOST'];?></a></b>
</p>
</div>
<?php if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) include_once 'includes/footer.php'; ?>