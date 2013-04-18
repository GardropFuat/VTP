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

include_once "head_std.php";
include("libraries/facebook-api-php-client/facebook.php");

$facebook = new Facebook(array(
                            'appId'  => '200590423408456',
                            'secret' => '22eae2f5ee955789dcf2529993a04ca6',
                        ));

$fbUserData = $facebook->api('me/friends?fields=id');
$users = $fbUserData['data'];
$facebookIds = '';

foreach ($users as $user) {
    $facebookIds = $user['id'].','.$facebookIds;
}

$facebookIds = substr($facebookIds, 0, -1);

$query = "SELECT * FROM `yttags` 
                    WHERE 
                        `yttags`.`videoId` = '".$videoId."' ";
$result = $Db->getAllRows($query);

var_dump($result);

include_once( "tail_std.php" );

?>