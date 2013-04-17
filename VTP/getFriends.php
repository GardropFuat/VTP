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



if( $_REQUEST['action'] == 'login') {
    if($_REQUEST['method'] == 'google') {
        include_once 'libraries/googleAuthentication.php';
    } else if($_REQUEST['method'] == 'facebook') {
        include_once 'libraries/facebookAuthentication.php';
    }
}
include_once( "head_std.php" );


?>


        
        <?php
            //['fb_200590423408456_access_token']
            //echo ("you are not logged into facebook");
            if(!$_SESSION['fb_200590423408456_access_token']){
                echo("Please refresh your facebook session.");
                echo ('<div style="padding:10px;height:29px;"><img src="images/facebook_login_icon.png" onClick="window.location.href = \'getFriends.php?action=login&method=facebook\';" alt="Login with Facebook" style="cursor:pointer;"</div>');
                
            }
            else{
                echo ("<h1>Friends</h1>");
                include("libraries/facebook-api-php-client/facebook.php");
                //echo("you are logged in to facebook");
                $facebook = new Facebook(array(
                'appId'  => '200590423408456',
                'secret' => '22eae2f5ee955789dcf2529993a04ca6',
                ));
            
                function getUserFriendList ($facebook)
                {
                    $friends = $facebook->api('me/friends?fields=link,name,id');
                    return $friends;
                }

                $tester = getUserFriendList($facebook);
                //echo ("Here");
                //print_r($tester);
                //echo ("Here");
                echo "<br>";
                $k = $tester['data'];
                $count = 0;
                
                foreach ($k as $key) {
                    if($Db->getFriends($key['id']) ){
                        echo('<a href="friendPage.php?link='.$key['link'].'&id='.$key['id'].'&name='.$key['name'].'">'.$key['name'].'</a><br>');
                        echo('<img src="http://graph.facebook.com/'.$key[id].'/picture" ><br>');
                        $count = $count +1;
                    }
                }
                if($count == 0){
                    echo "You appear to have no friends that use this application.";
                }
            }
            ?>

        <?php
            include_once( "tail_std.php" );
        ?>

