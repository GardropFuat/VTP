<?php
/*
 *
 * File Name:           tailJS.php
 * Description:         Contains JS code to include at end of the <body>
 * Author:
 * Created:             10/25/2012
 * Last Modified:       Anudeep 10/25/12
 * Copyright:           Echostar Systems @ http://www.echostar.com/
 */

if(!empty($videoId)) {
    // set player height and width
    echoScript("$('#playerFrame').height(".$playerHeight.").width(".$playerWidth.")");
    // generate YT player and set actions
    $ytContent = generateYTConent($videoId);
    echoScript( $ytContent );
}
?>