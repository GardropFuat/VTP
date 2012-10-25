<?php

require_once 'libraries/openid.php';
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.

try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('localhost');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            $openid->required = array('contact/email');
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="?login" method="post">
    <button>Login with Google</button>
</form>
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) {
            // logged in
            echo 'logged in<br/>';
            echo $openid->identity.'<br/>';
            $test = $openid->getAttributes();
            print_r($test);
        }else{
            // NOT logged in
        }
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>