
<?php
/**
 *
 * File Name:       getFriends
 * Description:     Find the friends that are uploading videos to our site
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Travis 3/05/13
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

//session_start();


//  set default time zone
date_default_timezone_set("America/Denver");

//  display/hide PHP errors 0->hide , 1-> show(default)
ini_set('display_errors', 1);

include("includes/errorLog.php");
include("libraries/facebook-api-php-client/facebook.php");
include("libraries/DbConnector.php");
include("includes/functions.php");

// Create new database instance
$Db = new DbConnector();

// Get user Favorites from DB
//$userId = $_SESSION['vtpUserId'];
//$fav = $Db->getFavorites($userId);

?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Video Tag Portal</title>
                            <!--    Style Sheets   -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <link href="css/jquery.dropdown.css" rel="stylesheet" type="text/css"></link>
        <link href="css/main.css" rel="stylesheet" type="text/css"></link>
                            <!--    Javascript files   -->
        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script src="http://popcornjs.org/code/dist/popcorn-complete.js"></script>
        <script src="libraries/jquery.dropdown.js" type="text/javascript"></script>
        <script src="includes/functions.js" type="text/javascript"></script>
		
		
		
		
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Upload To YouTube</title>
        <style type="text/css">
            label,
            input {
                display: block;
                margin: 0 0 5px 0;
            }
        </style>
        <script language="JavaScript" type="text/javascript">
        
        </script>
    </head>
        <?php
            //print_r ($_SESSION['fb_200590423408456_access_token']);
            function getUserFriendList ($facebook)
            {
                $friends = $facebook->api('me/friends');
                return $friends;
            }

            $test = new Facebook(array(
                'appId'  => '200590423408456',
                'secret' => '22eae2f5ee955789dcf2529993a04ca6',
            ));
            $tester = getUserFriendList($test);
            //print_r($tester);
            echo "<br>";
            $k = $tester['data'];
            
            foreach ($k as $key) {
                if($Db->getFriends($key['id']) ){
                    echo('<img src="http://graph.facebook.com/'.$key[id].'/picture" >');
                    echo($key['name']);
                }
            }
        ?>

    <body>
    </body>
</html>
