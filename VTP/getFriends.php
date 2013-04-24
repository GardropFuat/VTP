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

$facebookIds = $Db->getFbFriendIds($_SESSION['vtpUserId']);

echo '<h1>Friends</h1>';

foreach ($facebookIds as $facebookId) {
    $fbInfo = json_decode(file_get_contents('http://graph.facebook.com/'.$facebookId));
    echo '<a href="friendPage.php?link=http://www.facebook.com/'.$fbInfo->username.'&id='.$facebookId.'&name='.$fbInfo->name.'">'.$fbInfo->name.'</a><br>';
    echo '<img src="http://graph.facebook.com/'.$facebookId.'/picture" ><br>';
}

include_once( "tail_std.php" );

?>

