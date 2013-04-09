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
include_once( "head_std.php" );

include("libraries/facebook-api-php-client/facebook.php");
?>


        <h1>Friends</h1>
        <?php
            //this gets the facebook frends 
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
            
            echo "<br>";

            //friend pointer
            $k = $tester['data'];

            //get each friend and add their image from facebook to their name on the listing
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

