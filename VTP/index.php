<?php
/**
 *
 * File Name:       index.php
 * Description:     Base file for the project.
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Anudeep 10/09/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

// perform login operations
if( $_REQUEST['action'] == 'login') {
    if($_REQUEST['method'] == 'google') {
        include_once 'libraries/googleAuthentication.php';
    } else if($_REQUEST['method'] == 'facebook') {
        include_once 'libraries/facebookAuthentication.php';
    }
}

//  std header
include_once 'head_std.php';

//  main code 
include_once 'dashboard.php';
?>

<script src="includes/search.js"></script>

<?php
//std tail
include_once 'tail_std.php';
?>