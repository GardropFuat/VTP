<?php
/**
 *
 * File Name:       googleAuthentication.php
 * Description:     Authenticates user accounts with Google
 * Reference:       https://code.google.com/p/google-api-php-client/wiki/GettingStarted
 * Created:         10/29/2012
 * Last Modified:   Anudeep 10/29/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */
session_start();

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_Oauth2Service.php';

$client = new Google_Client();
$client->setApplicationName("Video Tag Portal");
//  Visit https://code.google.com/apis/console?api=plus to generate your
//  oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.

if($_SERVER['HTTP_HOST'] == 'localhost') {
    $client->setClientId('52837008745.apps.googleusercontent.com');
    $client->setClientSecret('Uw0lKxBRLxwVkYCvsHYeJlae');
    $client->setDeveloperKey('AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s');
    $client->setRedirectUri('http://localhost/vtp/libraries/googleAuthentication.php');
}else if($_SERVER['HTTP_HOST'] == "vtp.host-ed.me") {
    $client->setClientId('52837008745-fejaed2r8jd5bb4h1qu5hqtkqcgcal3n.apps.googleusercontent.com');
    $client->setClientSecret('HWnShZc6TAc60cWeglC0bNU1');
    $client->setRedirectUri('http://'.$_SERVER['HTTP_HOST'].'/vtp/libraries/googleAuthentication.php');
    $client->setDeveloperKey('AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s');
}else if($_SERVER['HTTP_HOST'] == 'WEBSITENAME') {
    // Authentication is required for each site at: https://code.google.com/apis/console/#project:PROJECT_ID:access
    //  $client->setClientId('CLIENT_ID');
    //  $client->setClientSecret('CLIENT_SECRET');
    //  $client->setRedirectUri('http://'.$_SERVER['HTTP_HOST'].'/vtp/libraries/googleAuthentication.php');
    //  $client->setDeveloperKey('AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s');
}

$oauth2 = new Google_Oauth2Service($client);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    return;
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) {
    //  Delete session
    session_destroy();
    $client->revokeToken();
    header("location: ../index.php");
}else{
    if ($client->getAccessToken()) {
        // Sucessful login
        $user = $oauth2->userinfo->get();
        /* $user =  Array ( [id] => 1234567890 
                            [email] => id@gmail.com 
                            [verified_email] => 1 
                            [name] => Full Name 
                            [given_name] => FirstName 
                            [family_name] => lastName 
                            [link] => https://plus.google.com/1234567890 
                            [picture] => https://lh5.googleusercontent.com/.../photo.jpg 
                            [gender] => male 
                            [birthday] => 0000-01-01 
                            [locale] => en 
                        );
        */
        // Copy user data into VTP session variables.
        $_SESSION['vtpUserId'] = $user['id'];
        $_SESSION['vtpUserName'] = $user['given_name'];
        $_SESSION['vtpUserType'] = 'google';
        $_SESSION['token'] = $client->getAccessToken();
        
        // Add user to DB
        require 'DbConnector.php';
        $Db = new DbConnector();
        $Db->addGoogleUser($user['id']);
        
        // Go back to home page
        header("location: ../index.php");
    } else {
        $authUrl = $client->createAuthUrl();
        header("location: ".$authUrl);
    }
}
?>