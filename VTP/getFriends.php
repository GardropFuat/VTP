
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
//date_default_timezone_set("America/Denver");

//  display/hide PHP errors 0->hide , 1-> show(default)
//ini_set('display_errors', 1);

//include("includes/errorLog.php");
include("libraries/facebook-api-php-client/facebook.php");
//include("libraries/DbConnector.php");
//include("includes/functions.php");

// Create new database instance
//$Db = new DbConnector();

// Get user Favorites from DB
//$userId = $_SESSION['vtpUserId'];
//$fav = $Db->getFavorites($userId);
include_once( "head_std.php" );
?>


        <h1>Friends</h1>
        <?php
            //print_r ($_SESSION['fb_200590423408456_access_token']);
            function getUserFriendList ($facebook)
            {
                $friends = $facebook->api('me/friends?fields=link,name,id');
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
                    echo('<a href="friendPage.php?link='.$key['link'].'&id='.$key['id'].'&name='.$key['name'].'">'.$key['name'].'</a><br>');
                    echo('<img src="http://graph.facebook.com/'.$key[id].'/picture" ><br>');
                }
            }
        ?>

        <?php
            include_once( "tail_std.php" );
        ?>

