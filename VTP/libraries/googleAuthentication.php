<?php


// Ref: https://google-api-javascript-client.googlecode.com/hg/samples/authSample.html
//      https://code.google.com/p/google-api-javascript-client/wiki/ReferenceDocs

include_once 'config.php';

if($_REQUEST['method'] == 'google' &&  !empty($_REQUEST['googleId']) &&  $_REQUEST['userName'] != '') {
    include_once 'libraries/DbConnector.php';
    $Db = new DbConnector();

    if( !empty($_SESSION['vtpUserId']) && !empty($_SESSION['facebookId']) ) {
        // Linking Google account
        $Db->linkGoogleAccount($_SESSION['vtpUserId'], $_SESSION['facebookId'], $_REQUEST['googleId']);
    }else {
        // new login
        $_SESSION['vtpUserId'] = $_REQUEST['googleId'];
        $_SESSION['googleId'] = $_REQUEST['googleId'];
        $_SESSION['vtpUserName'] = $_REQUEST['userName'];
        $_SESSION['vtpUserType'] = $_REQUEST['method'];
        $_SESSION['access_token'] = $_REQUEST['access_token'];

        // Add user to DB
        $Db->addGoogleUser($_REQUEST['googleId']);
    }
    // Go back to home page
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
?>
<!---Please allow popups to complete the action--->
<script src="https://apis.google.com/_/scs/apps-static/_/js/k=oz.gapi.en.IOaFQMAHVRI.O/m=client/am=UQE/rt=j/d=1/rs=AItRSTNYuZ6HDkdZho3xDZgOVYkx4qGWPQ/cb=gapi.loaded_0" async=""></script>
<script type="text/javascript">
    var clientId = '<?=GOOGLE_CLIENT_ID;?>';
    var apiKey = '<?=GOOGLE_API_KEY;?>';
    var scopes = Array('https://www.googleapis.com/auth/userinfo.profile',
                        'https://www.googleapis.com/auth/youtube');
    var access_token;
    
    function handleClientLoad() {
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
        setTimeout(function(){
                        $('#popupMsg').css('display', 'block');
                        },5000);
    }

    function checkAuth() {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
    }

    function handleAuthResult(authResult) {
        if (authResult && !authResult.error) {
            // success
            makeApiCall();
        } else {
            handleAuthClick();
        }
    }

    function handleAuthClick(event) {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
        return false;
    }

    // Load the API and make an API call.  Display the results on the screen.
    function makeApiCall() {
        gapi.client.load('oauth2', 'v2', function() {
            var request = gapi.client.oauth2.userinfo.get();
            access_token = gapi.auth.getToken().access_token;
            request.execute(logResponse);
        });
    }

    function logResponse(response) {
        var googleId = response.result.id;
        var userName = response.result.given_name;
        var data = 'action=login&method=google&googleId=' + googleId + '&userName=' + userName + '&access_token=' + access_token;
        window.location.href = 'index.php?' + data;
    }
</script>
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad" gapi_processed="true"></script>