<?php ob_start(); session_start();
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once 'index.html');
require_once 'Libs/BeSocial1st_Class.php'; require_once 'database.php'; ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="Libs/bootstrap/css/bootstrap.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title;?></title>
<meta name="author" content="Ahmed Mostafa" />
<meta name="version" content="1.0" />
<meta name="description" content="make your order to get the services for most social sites quickly and cheaper , make order easy to use also you order finish in little time very fast with us you will be the first in social site" />
</head>

<body style="background-color: #fff; padding-top: 100px;">
    
<!-- Navbar Start -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    
    <div class="container-fluid">
        
        <div class="navbar-header">
            
            <a class="navbar-brand" href="#">BeSocial1st</a>
            
        </div>
        <?php
            if(isset($_SESSION['user_id']) && isset($_SESSION['username'])):
         ?>
        <div style="padding-left: 420px" class="collapse navbar-collapse">
            
            <ul class="nav navbar-nav">
                
                <li>
                    <a href="index.php">New Order</a>
                </li>
                <li>
                    <a href="history.php">Orders History</a>
                </li>
                <li>
                    <a href="balance.php">Balance</a>
                </li>
                <li>
                    <a href="faq.php">F.A.Q</a>
                </li>
            </ul>
			<p style="padding-top: 8px; padding-right: 4px" class="nav navbar-nav navbar-right">Welcome <b><a href='settings.php' title='Go To Your Settings'><?=$_SESSION['username'];?></a></b> &nbsp;&nbsp; <a class="btn btn-default" href="logout.php">Log Out</a></p>

        </div>
		
        <?php endif; ?>
    </div>
    
</nav>
<!-- Navbar End /-->

<div class="container-fluid">