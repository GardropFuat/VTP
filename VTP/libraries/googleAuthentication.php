<?php


// Ref: https://google-api-javascript-client.googlecode.com/hg/samples/authSample.html
//      https://code.google.com/p/google-api-javascript-client/wiki/ReferenceDocs

include_once '../config.php';

if(!empty($_REQUEST['code'])) {
    // if( !empty($_SESSION['vtpUserId']) && !empty($_SESSION['facebookId']) ) {
        // // Linking Google account
        // $Db->linkGoogleAccount($_SESSION['vtpUserId'], $_SESSION['facebookId'], $_REQUEST['googleId']);
    // }else {
        // // new login
        // $_SESSION['vtpUserId'] = $_REQUEST['googleId'];
        // $_SESSION['googleId'] = $_REQUEST['googleId'];
        // $_SESSION['vtpUserName'] = $_REQUEST['userName'];
        // $_SESSION['vtpUserType'] = $_REQUEST['method'];
        // $_SESSION['access_token'] = $_REQUEST['access_token'];
        
        // // Add user to DB
        // $Db->addGoogleUser($_REQUEST['googleId']);
    // }
    

    
    
    $client_id = urlencode(GOOGLE_CLIENT_ID);
    $client_sec = "2I5UR3U8xD5Fgpb__Wm_-TPD";  
    $redirect_uri = "http://vtp.host-ed.me/vtp/prototype/06/libraries/googleAuthentication.php";
    $code = $_REQUEST['code'];
    $post="code=$code&client_id=$client_id&client_secret=$client_sec&redirect_uri=$redirect_uri&grant_type=authorization_code";
    $data_string = "code=" . $_REQUEST['code'] . "&client_id=" . $client_id . "&client_secret=" . $client_sec . "&redirect_uri=" . $redirect_uri . "&grant_type=authorization_code";
    
    
    
    //  $post = urlencode($post);
     //the following curl request is made to get the authorization token
    // $ch=curl_init();
    // $url="https://accounts.google.com/o/oauth2/token";
    // curl_setopt($ch,CURLOPT_URL,$url);
    // curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    // curl_setopt($ch,CURLOPT_AUTOREFERER,1);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($ch,CURLOPT_POST,1); 
    // curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    // $json=curl_exec($ch);
    // curl_close($ch);

    
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    // curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    // curl_setopt($ch, CURLOPT_POST,TRUE);
    // curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
    // curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
    // curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded'));
    // $response = curl_exec($ch);
    // curl_close($ch);
    // print_r($response);
    
    
    
    
    
    $fields=array(
        'code'=>  urlencode($code),
        'client_id'=>  urlencode(GOOGLE_CLIENT_ID),
        'client_secret'=>  urlencode($client_sec),
        'redirect_uri'=>  urlencode($redirect_uri),
        'grant_type'=>  urlencode('authorization_code')
    );
    $fields_string='';
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    $fields_string=rtrim($fields_string,'&');
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch,CURLOPT_POST,5);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    print_r($result);
    
    
    
    
    
    
    
    
    // // Go back to home page
    // header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
?>
<!---Please allow popups to complete the action--->
<script src="https://apis.google.com/_/scs/apps-static/_/js/k=oz.gapi.en.IOaFQMAHVRI.O/m=client/am=UQE/rt=j/d=1/rs=AItRSTNYuZ6HDkdZho3xDZgOVYkx4qGWPQ/cb=gapi.loaded_0" async=""></script>
<script type="text/javascript">
    var clientId = '<?=GOOGLE_CLIENT_ID;?>';
    var apiKey = '<?=GOOGLE_API_KEY;?>';
    var config = {
                'client_id': clientId,
                'scope': 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/youtube',
                'immediate': false,
                'response_type': 'code',
                'access_type': 'offline'
    };
    /*****************************************************************************/
    var access_token = '';
    var code = '';
    var http = new XMLHttpRequest();
    /*****************************************************************************/
    
    function handleClientLoad() {
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
        setTimeout(function(){
                        $('#popupMsg').css('display', 'block');
                        },5000);
    }

    function checkAuth() {
        gapi.auth.authorize(config, handleAuthResult);
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
        gapi.auth.authorize(config, handleAuthResult);
        return false;
    }

    // Load the API and make an API call.  Display the results on the screen.
    function makeApiCall() {
        gapi.client.load('oauth2', 'v2', function() {
            var request = gapi.client.oauth2.userinfo.get();
            /********************************************************************************/
            code = gapi.auth.getToken().code;
            // // access_token = gapi.auth.getToken().access_token;
            // // console.log(gapi.auth);
            // // console.log(gapi.auth.getToken());
            
            
            
            // var url = "http://accounts.google.com/o/oauth2/token";
            // var params = "code="+code
                // +"&client_id="+encodeURIComponent(clientId)
                // +"&client_secret=2I5UR3U8xD5Fgpb__Wm_-TPD"
                // +"&redirect_uri="+encodeURIComponent("http://vtp.host-ed.me/vtp/prototype/06/index.php")
                // +"&grant_type=authorization_code";
            // http.open("POST", url, true);

            // //Send the proper header information along with the request
            // http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // // http.setRequestHeader("Content-length", params.length);
            // // http.setRequestHeader("Connection", "close");

            // http.onreadystatechange = function() {//Call a function when the state changes.
                // if(http.readyState == 4 && http.status == 200) {
                    // alert(http.responseText);
                // }
            // }
            // http.send(params);
            /********************************************************************************/
            
            request.execute(logResponse);
        });
    }

    function logResponse(response) {
        // var googleId = response.result.id;
        // var userName = response.result.given_name;
        // var data = 'action=login&method=google&googleId=' + googleId + '&userName=' + userName;
        /********************************************************************************/
        var data = 'action=login&method=google&googleId=1234567890&userName=test' + '&access_token=' + access_token + '&code=' + code;
        /********************************************************************************/
        window.location.href = 'googleAuthentication.php?' + data;
    }
</script>
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad" gapi_processed="true"></script>