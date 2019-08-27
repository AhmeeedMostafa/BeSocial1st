<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset= utf-8" />
        <title>صفحة تسطيب الإسكربت</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    </head>
    
    <body>
        <div class="container">
        <center><h1>تسطيب الإسكربت لموقعكم <?=$_SERVER['SERVER_NAME'];?></h1></center>
            <?php
                //Config File Name
                $file_name = "../includes/database.php";
				$class_file_name = '../Libs/BeSocial1st_Class.php';
                if(!isset($_GET['step'])):
            ?>
            <p><b>أهلا بك فى صفحة تسطيب الإسكربت, قبل البدء فى تسطيب الإسكربت نحتاج للمعلومات التاليه عن قاعدة البيانات :</b>
                <ol>
                    <li>اسم المستضيف لقاعدة البيانات</li>
                    <li>اسم قاعدة البيانات</li>
                    <li>اسم المستخدم لقاعدة البيانات</li>
                    <li>كلمة المرور لقاعدة البيانات</li>
                </ol>
            </p>
            <b><p>عادة يكون اسم المستضيف لقاعدة البيانات ( localhost ) لكن من الممكن ان يكون اسم آخر على استضافتك .</p></b>
            <a href="?step=connect" style="font-size: 18px;" class="btn btn-primary btn-lg btn-block" role="button">.:: ابدأ الآن ::.</a>
            <?php
                endif;
                if(isset($_GET['step']) && $_GET['step'] == 'connect'){
                    //Check if click on connect button
                    if(isset($_POST['Connect'])){
                        //get inputs value
                        $DB_host        = $_POST['db_host'];
                        $DB_name        = $_POST['db_name'];
                        $DB_user        = $_POST['db_user'];
                        $DB_pass        = $_POST['db_pass'];
                        //check if this file exists or no
                        if(!file_exists($file_name)){
                            //data to put in config file
                            $data = "<?php
define('HOST', '{$DB_host}');
define('USERNAME', '{$DB_user}');
define('PASSWORD', '{$DB_pass}');
define('DBNAME', '{$DB_name}');
if(basename(\$_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once 'index.html');
new BS1st(HOST, USERNAME, PASSWORD, DBNAME);";
                            //put contents in config file
                            $create_file = file_put_contents($file_name, $data);
                            //check if contetns put
                            if(isset($create_file)){
								require_once $class_file_name;
                                require_once $file_name;
                                die("<b><span class='text-center'><p class='alert alert-success'>تم الإنتهاء من خطوة الإتصال بقاعدة البيانات .</p></span></b>
                                <a href='?step=1' role='button' class='btn btn-success btn-lg btn-block'>تسطيب الإسكربت</a>");
                            }
                        }else{
                            die ("<span class='text-center'><h3 class='alert alert-danger'>هذا الملف ( ".$file_name." ) موجود بالمجلد, من فضلك أحذفه ثم اعد محاولة كتابه البيانات .</h3></span>");
                        }
                    }
            ?>
                    <h4>أدخل بيانات الإتصال بقاعدة البيانات, يمكنك الإستعانه بالشركه المستضيفه لموقعك للإستفسار عن هذه البيانات .</h4>
                    <form method="POST" action="" role="form">
                        <div class="form-group">
                            <label for="db_host">اسم المستضيف *</label>
                            <input type="text" class="form-control" id="db_host" placeholder="اسم المستضيف للقاعده" name="db_host" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="db_name">اسم قاعدة البيانات *</label>
                            <input type="text" class="form-control" id="db_name" placeholder="اسم قاعدة البيانات" name="db_name" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="db_user">اسم المستخدم *</label>
                            <input type="text" class="form-control" id="db_user" placeholder="اسم مستخدم قاعدة البيانات" name="db_user" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="db_pass">كلمة المرور</label>
                            <input type="password" class="form-control" id="db_pass" placeholder="كلمة مرور مستخدم قاعدة البيانات" name="db_pass" />
                        </div>
                        <input type="submit" value="الإتصال بقاعدة البيانات" class="btn btn-primary btn-lg btn-block" name="Connect" />
                    </form>
            <?php
                }else{                   
                    if(isset($_GET['step']) && $_GET['step'] == 1){
                        if(file_exists($file_name)){
							require_once $class_file_name;
                            require_once $file_name;
                        }else
                            die("<span class='text-center'><h3 class='alert alert-danger'>لم نجد ملف الإتصال بمجلدك من فضلك اذهب و حاول التسطيب من جديد</h3></span>");
                            
                        $CT_FB_users = BS1st::SQL("CREATE TABLE IF NOT EXISTS `users` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `username` varchar(60) NOT NULL,
								  `password` varchar(100) NOT NULL,
								  `balance` float NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;");
    
    			         if(isset($CT_FB_users))
                            echo "<b><span class='text-center'><p class='alert alert-success'>تم إنشاء الجدول الأول و الإنتهاء من الخطوه الأولى .</p></span></b>
                            <a href='?step=2' class='btn btn-primary btn-lg btn-block' role='button'>الخطوه الثانيه</a>";
                    }
                    
                    if(isset($_GET['step']) && $_GET['step'] == 2){
                        if(file_exists($file_name)){
							require_once $class_file_name;
                            require_once $file_name;
                        }else
                            die("<span class='text-center'><h3 class='alert alert-danger'>لم نجد ملف الإتصال بمجلدك من فضلك اذهب و حاول التسطيب من جديد</h3></span>");
                            
                        $CT_admins = BS1st::SQL("CREATE TABLE IF NOT EXISTS `admins` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `adminname` varchar(150) NOT NULL,
								  `adminpass` varchar(150) NOT NULL,
								  `exec_orders_no` int(11) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
        				if(isset($_POST['signup'])){
        				    $name 			= BS1st::postValues($_POST['name']);
        					$password 		= BS1st::postValues($_POST['password']);
        					if(empty($name) || empty($password)){
        						echo "<h4 class='alert alert-danger'>يرجى إدخال جميع الحقول ...</h4>";
        					}else{
        						$add_admin = BS1st::SQL("INSERT INTO admins (adminname, adminpass, exec_orders_no) VALUES ('".$name."', '".$password."', '0')");
								$add_user = BS1st::SQL("INSERT INTO `users` (username, password, balance) VALUES ('".$name."', '".$password."', '1000')");
        						if(isset($add_admin) && isset($add_user)){
        							die ("<b><span class='text-center'><p class='alert alert-success'>تم إضافة المدير بنجاح .</p></span></b><a href='?step=3' class='btn btn-success btn-lg btn-block' role='button'>الخطوه الثالثه</a>");
        						}
        					}
        				}
                        
                        if(isset($CT_admins)){
        				?>
            				<h3 class="text-center"><span class='text-center'><p class="alert alert-info">تسجيل مدير ...</p></span></h3>
                            
            				<form action="" method="POST" role="form">
                            <div class="form-group">
                                <label for="name">الإسم *</label>
                                <input type="text" class="form-control" id="db_host" placeholder="الإسم" name="name" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="password">كلمة المرور *</label>
                                <input type="password" class="form-control" id="password" placeholder="كلمة المرور" name="password" required="required" />
                            </div>
                            <input type="submit" value="تسجيل" class="btn btn-primary btn-lg btn-block" name="signup" />
            				</form>
                        <?php
    			         }
                    }
                    
                    if(isset($_GET['step']) && $_GET['step'] == 3){
                        if(file_exists($file_name)){
							require_once $class_file_name;
                            require_once $file_name;
                        }else
                            die("<span class='text-center'><h3 class='alert alert-danger'>لم نجد ملف الإتصال بمجلدك من فضلك اذهب و حاول التسطيب من جديد</h3></span>");
                            
                        $CT_orders = BS1st::SQL("CREATE TABLE IF NOT EXISTS `orders` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `uid` int(11) NOT NULL,
								  `type` varchar(50) NOT NULL,
								  `link` varchar(1000) NOT NULL,
								  `quantity` int(11) NOT NULL,
								  `date` varchar(40) NOT NULL,
								  `status` varchar(30) NOT NULL,
								  `lsubscriber_used` int(11) NOT NULL,
								  `success_count` int(11) NOT NULL,
								  `completed_in` varchar(40) NOT NULL,
								  `notify` tinyint(1) NOT NULL,
								  `price` float NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;");
    			         if(isset($CT_orders))
                            echo "<b><span class='text-center'><p class='alert alert-success'>تم الإنتهاء من إنشاء الجدول الثالث بنجاح , يرجى تكملة تسطيب الإسكربت و تكملة باقى الخطوات .</p></span></b><a href='?step=4' class='btn btn-primary btn-lg btn-block' role='button'>الخطوه الرابعه</a>";
                    }
                    
                    if(isset($_GET['step']) && $_GET['step'] == 4){
                        if(file_exists($file_name)){
							require_once $class_file_name;
                            require_once $file_name;
                        }else
                            die("<span class='text-center'><h3 class='alert alert-danger'>لم نجد ملف الإتصال بمجلدك من فضلك اذهب و حاول التسطيب من جديد</h3></span>");
                            
                        $CT_FB_subscribers = BS1st::SQL("CREATE TABLE IF NOT EXISTS `fb_subscribers` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `access_token` text NOT NULL,
								  `csite_id` varchar(150) NOT NULL,
								  `name` varchar(150) NOT NULL,
								  `country` varchar(80) NOT NULL,
								  `category` varchar(60) NOT NULL,
								  `date` varchar(30) NOT NULL,
								  `birthday` varchar(30) NOT NULL,
								  `email` varchar(250) NOT NULL,
								  `gender` varchar(15) NOT NULL,
								  `country_code` varchar(6) NOT NULL,
								  `continent` varchar(80) NOT NULL,
								  `continent_code` int(6) NOT NULL,
								  `fb_location` varchar(150) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1518 ;");
    			         if(isset($CT_FB_subscribers))
                            echo "<b><span class='text-center'><p class='alert alert-success'>تم الإنتهاء من إنشاء الجدول الرابعه و تم الإنتهاء من الخطوه الرابعه .</p></span></b><a href='?step=5' class='btn btn-primary btn-lg btn-block' role='button'>الخطوه الخامسه</a>";
                    }
                    
                    if(isset($_GET['step']) && $_GET['step'] == 5){
                        if(file_exists($file_name)){
							require_once $class_file_name;
                            require_once $file_name;
                        }else
                            die("<span class='text-center'><h3 class='alert alert-danger'>لم نجد ملف الإتصال بمجلدك من فضلك اذهب و حاول التسطيب من جديد</h3></span>");
                            
                        $CT_INSTA_subscribers = BS1st::SQL("CREATE TABLE IF NOT EXISTS `insta_subscribers` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `access_token` text NOT NULL,
								  `csite_id` varchar(150) NOT NULL,
								  `name` varchar(150) NOT NULL,
								  `country` varchar(80) NOT NULL,
								  `category` varchar(60) NOT NULL,
								  `date` varchar(30) NOT NULL,
								  `country_code` varchar(6) NOT NULL,
								  `continent` varchar(80) NOT NULL,
								  `continent_code` int(6) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;");
    			         if(isset($CT_INSTA_subscribers))
                            echo "<b><span class='text-center'><p class='alert alert-success'>تم الإنتهاء من إنشاء الجدول الخامس و الإنتهاء من الخطوه الخامسه .</p></span></b><a href='?step=6-last' class='btn btn-primary btn-lg btn-block' role='button'>الخطوه السادسه ( الأخيره )</a>";
                    }
                    
                    if(isset($_GET['step']) && $_GET['step'] == '6-last'){
                        if(isset($_REQUEST['deleteInstall'])){
							/*
							$contents = scandir('../install', 1);
							foreach($contents as $content){
								if(is_file($content))
									unlink($content);
								else{
									$dirContents = scandir($content, 1);
									foreach($dirContents as $dirContent)
										unlink($content."/".$dirContent);
									rmdir($content);
								}
							}
							
                            if(is_dir('../install')){
                                $deleteDir = rmdir('../install');
                                if(isset($deleteDir)){
                                    echo "<h3 class='alert alert-success'>تم حذف مجلد التسطيب بنجاح, جارى تحويلك للصفحه الرئيسية للم بوقع بعد 4 ثوانى .</h3>";
                                    echo "<meta http-equiv='refresh' content='4; url=/index.php' />";
                                }
                            }else{
                                echo "<span class='text-center'><h3 class='alert alert-danger'>لم نجد مجلد التسطيب من فضلك أحذفه انت يدوياً إن كان مازال موجوداً</h3></span>";
                            }*/
                        }
                        
                        if(isset($_REQUEST['unDeleteInstall'])){
                            echo "<h3 class='alert alert-danger'>عدم حذفك لمجلد التسطيب قد يستغله البعض <br /> وان وجدت موقعك مقفول فسيكون السبب هو عدم حذف مجلد التسطيب ( هذا إن لم يتواجد سبب آخر ) .</h3>";
                            die ("<span class='text-center'><p><b>إذا أردت حذفه إضغط </b> <a href='?step=6-last&deleteInstall' class='btn btn-success btn-lg' role='button'>هنا</a> <b> أو إضغط </b><a href='/index.php' class='btn btn-danger btn-lg' role='button'>هنا</a><b> إذا اردت الذهاب للصفحه الرئيسية .</b></p></span>");
                        }
                    
                        echo "<h3 class='alert alert-warning'>هذه الخطوه مختصه بحذف مجلد التسطيب حتى لا يتم إستغلاله من طرف الأشخاص الأخرون , فهل تريد حذفه ؟</h3>";
                        echo "<b><span class='text-center'><p class='alert alert-info'>إذا لم تحذفه من الممكن إستغلاله من قبل الأخرون .<br />إذا لم يحذف تلقائياً عند الضغط على الخيار نعم فأحذفه انت يدوياً .</p></span></b>";
                        echo "<a href='?step=6-last&deleteInstall' class='btn btn-success btn-lg'>نعم</a> &nbsp; <a href='?step=6-last&unDeleteInstall' class='btn btn-danger btn-lg'>لا</a>";
                    }
                }
            ?>
        </div>
    </body>
</html>