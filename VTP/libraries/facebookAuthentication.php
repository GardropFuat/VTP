<?php
//  Ref:    https://github.com/facebook/facebook-php-sdk

include_once 'config.php';

require 'libraries/facebook-api-php-client/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array( 'appId'  => FACEBOOK_API_ID, 'secret' => FACEBOOK_SECRET_KEY ));

// Get User ID
$user = $facebook->getUser();

if ($user) {
    try {
        // get user profile details
        $user_profile = $facebook->api('/me');

        include_once 'libraries/DbConnector.php';
        $Db = new DbConnector();

        if( !empty($_SESSION['vtpUserId']) && !empty($_SESSION['googleId']) ) {
            // Linking Google account
            $Db->linkFacebookAccount($_SESSION['vtpUserId'], $user_profile['id'], $_SESSION['googleId']);
        }else {
            // new login
            $_SESSION['vtpUserId'] = $user_profile['id'];
            $_SESSION['facebookId'] = $user_profile['id'];
            $_SESSION['vtpUserName'] = $user_profile['first_name'];
            $_SESSION['vtpUserType'] = 'facebook';
            //  $_SESSION['vtpFBLogoutUrl']= $facebook->getLogoutUrl();

            $Db->addFBUser($user_profile['id']);

            // Redirect to home page
            header('location: index.php');
            exit;
        }
        // Go back to home page
        header('Location: '.$_SERVER['PHP_SELF']);
        exit;
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
        //  Redirect
        header('Location: notfound.html');
        exit;
    }
} else {
    //  Redirect to Facebook Authentication approval page
    $loginUrl = $facebook->getLoginUrl();
    header('location: '.$loginUrl);
    exit;
}
?>
