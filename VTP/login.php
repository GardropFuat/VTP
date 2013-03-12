<?php
/*
 *
 * File Name:       login.php
 * Description:     processes user authentication and 
 * Created:         10/19/2012
 * Last Modified:   Anudeep 10/29/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

include_once 'config.php';

if( !empty($_REQUEST['login']) && ($_REQUEST['login'] == 'logout') ) {
    session_destroy();
}else{
    //Invalid request
}

header("location: index.php");
exit;
?>