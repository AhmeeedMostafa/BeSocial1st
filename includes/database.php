<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'besocial1st');
if(basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) die(require_once 'index.html');
new BS1st(HOST, USERNAME, PASSWORD, DBNAME);