<?php
session_start();

//  set default time zone
date_default_timezone_set("America/Denver");

//  display/hide PHP errors 0->hide , 1-> show(default)
ini_set('display_errors', 0);

include("includes/errorLog.php");

/*  Database info    */
define('DB_HOST', 'localhost'); //  host is usually localhost for servers also
define('DB_DB', 'MY_DB_NAME'); //  Database name for vtp
define('DB_USER', 'MY_DB_USER_NAME'); // user Id for the Database
define('DB_PASSWORD', 'MY_DB_PASSWORD');  // password for the Database

/* Google API Data. */
define('GOOGLE_CLIENT_ID', 'MY_GOOGLE_CLIENT_ID');
define('GOOGLE_CLIENT_SECRET', 'MY_GOOGLE_CLIENT_SECRET');
define('GOOGLE_API_KEY', 'MY_GOOGLE_API_KEY');
define("YOUTUBE_DEVELOPER_KEY", 'MY_YOUTUBE_DEVELOPER_KEY');

/* Facebook API Data. */
define('FACEBOOK_API_ID', 'MY_FACEBOOK_API_ID');
define('FACEBOOK_SECRET_KEY', 'MY_FACEBOOK_SECRET_KEY');
?>