<?php
/**
  * Functions to get access token from Google
  */


function get_oauth2_token($redirect_uri, $grantCode, $grantType) {
	global $refreshToken;
	$oauth2token_url = "https://accounts.google.com/o/oauth2/token";
    $clienttoken_post = array(
                                "client_id" => GOOGLE_CLIENT_ID,
                                "client_secret" => GOOGLE_CLIENT_SECRET
                        );
	
    if ($grantType === "online"){
		$clienttoken_post["code"] = $grantCode;	
		$clienttoken_post["redirect_uri"] = $redirect_uri;
		$clienttoken_post["grant_type"] = "authorization_code";
	}
	
	if ($grantType === "offline"){
		$clienttoken_post["refresh_token"] = $grantCode;
		$clienttoken_post["grant_type"] = "refresh_token";
	}
	
	$curl = curl_init($oauth2token_url);

	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$json_response = curl_exec($curl);
	curl_close($curl);

	$authObj = json_decode($json_response);
    
	//if offline access requested and granted, get refresh token
	if (isset($authObj->refresh_token)){
		$refreshToken = $authObj->refresh_token;
	}

	$accessToken = $authObj->access_token;
	return $accessToken;
}    

// gets access token for provided refresh token
function getAccessToken($refreshToken){
    $accessToken = get_oauth2_token( $redirect_uri, $refreshToken,"offline");
    return $accessToken;
}

//calls Google api and gets the user data
function call_api($accessToken, $url)
{
	$curl = curl_init($url);
 
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);	
	$curlheader[0] = "Authorization: Bearer " . $accessToken;
	curl_setopt($curl, CURLOPT_HTTPHEADER, $curlheader);

	$json_response = curl_exec($curl);
	curl_close($curl);
		
	$responseObj = json_decode($json_response);
    
	return $responseObj;	    
}
?>