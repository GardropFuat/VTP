<?php
/*
 *
 * File Name:       login.php
 * Description:     processes user authentication and 
 * Created:         10/19/2012
 * Last Modified:   Anudeep 10/29/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

session_start();

if(!empty($_REQUEST['login'])) {
    if($_REQUEST['login'] == 'google') {
        //  Redirect to Google Authentication Script
        header("location: libraries/googleAuthentication.php");
        
    }else if($_REQUEST['login'] == 'facebook') {
        //  Redirect to Facebook Authentication Script
        header("location: libraries/facebookAuthentication.php");
        
    }else if($_REQUEST['login'] == 'logout') {
        if(!empty($_SESSION['vtpUserType'])) {
            if($_SESSION['vtpUserType'] == 'google') {
                header("location: libraries/googleAuthentication.php?logout=1");
                
            }else if($_SESSION['vtpUserType'] == 'facebook') {
                //  Delete session
                session_destroy();
                header("location: index.php");
            }
        }
    }
}else{
    echo 'login not set';
}
?>