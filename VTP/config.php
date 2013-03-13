<?php
session_start();

//  set default time zone
date_default_timezone_set("America/Denver");

//  display/hide PHP errors 0->hide , 1-> show(default)
ini_set('display_errors', 1);

include("includes/errorLog.php");

define('GOOGLE_CLIENT_ID', '52837008745-ooej09e6nrgama8p8ptl3p8f5qtomt42.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '2I5UR3U8xD5Fgpb__Wm_-TPD');
define('GOOGLE_API_KEY', 'AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s');
    
define('FACEBOOK_API_ID', '200590423408456');
define('FACEBOOK_SECRET_KEY', '22eae2f5ee955789dcf2529993a04ca6');
?>