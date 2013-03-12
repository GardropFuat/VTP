<?php
// Ref: https://google-api-javascript-client.googlecode.com/hg/samples/authSample.html
//      https://code.google.com/p/google-api-javascript-client/wiki/ReferenceDocs

?>

<html>
    <head>
        <meta charset="utf-8">
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    </head>
    <body>
        <div>Please allow popups to complete the action</div>
        <script src="https://apis.google.com/_/scs/apps-static/_/js/k=oz.gapi.en.IOaFQMAHVRI.O/m=client/am=UQE/rt=j/d=1/rs=AItRSTNYuZ6HDkdZho3xDZgOVYkx4qGWPQ/cb=gapi.loaded_0" async=""></script>
        <script type="text/javascript">
            var clientId = '52837008745-ooej09e6nrgama8p8ptl3p8f5qtomt42.apps.googleusercontent.com';
            var apiKey = 'AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s';
            var scopes = Array('https://www.googleapis.com/auth/userinfo.profile',
                                'https://www.googleapis.com/auth/youtube');

            function handleClientLoad() {
                gapi.client.setApiKey(apiKey);
                window.setTimeout(checkAuth,1);
            }

            function checkAuth() {
                gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
            }

            function handleAuthResult(authResult) {
                //  console.log("handleAuthResult(authResult)" + authResult);
                var authorizeButton = document.getElementById('authorize-button');
                if (authResult && !authResult.error) {
                    makeApiCall();
                } else {
                    handleAuthClick();
                    $('#authorize-button').click();
                }
            }

            function handleAuthClick(event) {
                gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
                return false;
            }

            function logResponse(response) {
                var userId = response.result.id;
                var userName = response.result.given_name;
                console.log(userId + " " + userName);
            }

            // Load the API and make an API call.  Display the results on the screen.
            function makeApiCall() {
                gapi.client.load('oauth2', 'v2', function() {
                    var request = gapi.client.oauth2.userinfo.get();
                    request.execute(logResponse);
                });
            }
        </script>
        <script src="https://apis.google.com/js/client.js?onload=handleClientLoad" gapi_processed="true"></script>
        <iframe name="oauth2relay1737989546" id="oauth2relay1737989546" src="https://accounts.google.com/o/oauth2/postmessageRelay?parent=https%3A%2F%2Fgoogle-api-javascript-client.googlecode.com#rpctoken=571716944&amp;forcesecure=1" style="width: 1px; height: 1px; position: absolute; left: -100px;" class="broke-endless-pages"></iframe><iframe src="https://accounts.google.com/o/oauth2/auth?client_id=837050751313&amp;scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fplus.me&amp;immediate=true&amp;proxy=oauth2relay1737989546&amp;redirect_uri=postmessage&amp;origin=https%3A%2F%2Fgoogle-api-javascript-client.googlecode.com&amp;response_type=token&amp;state=611715701%7C0.35655846&amp;authuser=0" style="width: 1px; height: 1px; position: absolute; left: -100px;"></iframe>
    </body>
</html>