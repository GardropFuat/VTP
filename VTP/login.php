<?php

require_once 'libraries/openid.php';
$openid = new LightOpenID('localhost');

if( (!empty($_POST['login']) && $_POST['login'] == 'google') || $openid->mode ) {
    echo 'loop_10';
    if(!$openid->mode) {
        $openid->identity = 'https://www.google.com/accounts/o8/id';
        $openid->required = array('contact/email');
        echo "<script>window.open('".$openid->authUrl()."', '_blank', 'fullscreen=no,location=no,toolbar=no,top=500,left=500,html=no')</script>";
    } elseif($openid->mode == 'cancel') {
        //  $_SESSION['vtpUserName'] = '';
        //  $_SESSION['vtpUserId'] = '';
        echo 'loop_cancel';
        header("location: index.php");
    } else {
        if($openid->validate()) {
            // logged in
            echo 'logged in<br/>';
            echo $openid->identity.'<br/>';
            $test = $openid->getAttributes();
            print_r($test);
        }else{
            // NOT logged in
            echo 'Loop_14';
        }
    }
}else if((!empty($_POST['login'])) && ($_POST['login'] == 'facebook')) {
    echo 'facebook not implemented yet';
}else{
    echo 'Loop_100';
}

echo "<br/>";
?>