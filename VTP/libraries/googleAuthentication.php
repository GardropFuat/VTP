<?php
// Ref: http://www.jensbits.com/2012/01/09/google-api-offline-access-using-oauth-2-0-refresh-token/

include_once '../config.php';
include_once 'DbConnector.php';
include_once '../includes/functions.php';
include_once '../includes/getOauth2Token.php';

$Db = new DbConnector();

$redirect_uri = curPageURL();
$pos = strpos($redirect_uri, '?');

if($pos !== false) {
    // remove queries at the end
    $redirect_uri = substr($redirect_uri, 0, $pos);
}

if(isset($_REQUEST['code'])){
    $accessToken = get_oauth2_token( $redirect_uri, $_REQUEST['code'], "online");
}else{
    die("Restricted Access");
}

if (!empty($accessToken)){
    //got access token, get data
    $user = call_api($accessToken, 'https://www.googleapis.com/oauth2/v1/userinfo');
    if( !empty($_SESSION['vtpUserId']) && !empty($_SESSION['facebookId']) ) {
        $_SESSION['access_token'] = $accessToken;

        // Linking Google account
        $Db->linkGoogleAccount($_SESSION['vtpUserId'], $_SESSION['facebookId'], $user->id, $refreshToken);
    }else {
        // new login
        $_SESSION['vtpUserId'] = $user->id;
        $_SESSION['googleId'] = $user->id;
        $_SESSION['vtpUserName'] = $user->name;
        $_SESSION['vtpUserType'] = 'google';
        $_SESSION['googleProfileImg'] = $user->picture;
        $_SESSION['access_token'] = $accessToken;

        // Add user to DB
        $Db->addGoogleUser($_SESSION['googleId'], $refreshToken);
    }
    
    // Go back to home page
    echo <<< HTML
        <html>
            <head>
                <script>
                    window.location = '../index.php';
                </script>
            </head>
            <body></body>
        </html>
HTML;
    die('Redirect Failed');
}
?> 