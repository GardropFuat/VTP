<?php
#https://github.com/facebook/facebook-php-sdk
session_start();

require 'facebook-api-php-client/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
    'appId'  => '200590423408456',
    'secret' => '22eae2f5ee955789dcf2529993a04ca6',
 ));

// Get User ID
$user = $facebook->getUser();

if ($user) {
    try {
        // get user profile details
        $user_profile = $facebook->api('/me');
        
        //  Set session variable to access this data in other pages
        $_SESSION['vtpUserId'] = $user_profile['id'];
        $_SESSION['vtpUserName'] = $user_profile['first_name'];
        $_SESSION['vtpUserType'] = 'facebook';
        $_SESSION['vtpFBLogoutUrl']= $facebook->getLogoutUrl();
        
        //  add user to DB
        require 'DbConnector.php';
        $Db = new DbConnector();
        $Db->addFBUser($user_profile['id']);
        
        // Redirect to home page
        header('location: ../index.php');
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
        //  Redirect
        header('Location: notfound.html');
    }
} else {
    //  Redirect to Facebook Authentication approval page
    $loginUrl = $facebook->getLoginUrl();
    header('location: '.$loginUrl);
}
?>
