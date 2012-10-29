<?php

if(!empty($_POST['login'])) {
    switch($_POST['login']) {
        case 'facebook':
            echo 'facebook not implemented yet';
            break;
        case 'google':
            require_once 'libraries/openid.php';
            $openid = new LightOpenID('localhost');
            if(!$openid->mode) {
                $openid->identity = 'https://www.google.com/accounts/o8/id';
                $openid->required = array('contact/email');
                echo "<script>window.open('".$openid->authUrl()."', '_blank', 'fullscreen=no,location=no,toolbar=no,top=500,left=500,html=no')</script>";
            } elseif($openid->mode == 'cancel') {
                echo '<script>self.close();</script>';
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
            break;    
    }
}
echo "<br/>";
?>