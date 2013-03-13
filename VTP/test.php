<?php
include_once 'config.php';

$url = "http://accounts.google.com/o/oauth2/token";
// $url = "http://www.inkbarreltv.com/inkbarrelDev/admin/live/test.php";

$params = array(    
                    "code" => $_REQUEST['code'], 
                    "client_id" => urlencode(GOOGLE_CLIENT_ID), 
                    "client_secret" => "2I5UR3U8xD5Fgpb__Wm_-TPD", 
                    "redirect_uri" => urlencode("http://vtp.host-ed.me/vtp/prototype/06/test.php"),
                    "grant_type" => "authorization_code");

$data = $params;

$params = "code=".$_REQUEST['code']."&client_id=".urlencode(GOOGLE_CLIENT_ID)."&client_secret=2I5UR3U8xD5Fgpb__Wm_-TPD"; 
$params = $params."&redirect_uri=".urlencode("http://vtp.host-ed.me/vtp/prototype/06/test.php")."&grant_type=authorization_code";

// // use key 'http' even if you send the request to https://... 
// $options = array('http' => array(
                                // 'method'  => 'POST',
                                // 'content' => http_build_query($data),
                                // 'header'=> "Host: accounts.google.com\n Content-Type: application/x-www-form-urlencoded"
                                // ));
// $context  = stream_context_create($options);
// $result = file_get_contents($url, false, $context);

// echo "</br>******************************************************</br>";
// var_dump($url);     
// echo "</br>******************************************************</br>";
// var_dump($data);
// echo "</br>******************************************************</br>";
// var_dump($result);
// echo "</br>******************************************************</br>";








$client_id = urlencode(GOOGLE_CLIENT_ID);
$client_sec = "2I5UR3U8xD5Fgpb__Wm_-TPD";  
$redirect_uri = urlencode("http://vtp.host-ed.me/vtp/prototype/06/index.php");
$code = $_REQUEST['code'];
$post="code=$code&client_id=$client_id&client_secret=$client_sec&redirect_uri=$redirect_uri&grant_type=authorization_code";
//  $post = urlencode($post);
 //the following curl request is made to get the authorization token
$ch=curl_init();
$url="https://accounts.google.com/o/oauth2/token";
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch,CURLOPT_AUTOREFERER,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch,CURLOPT_POST,1); 
curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$json=curl_exec($ch);
curl_close($ch);

print_r($json);
















// function post_request($url, $data, $referer='') {
 
    // // Convert the data array into URL Parameters like a=b&foo=bar etc.
    // $data = http_build_query($data);
    // print_r($data);
    // // parse the given URL
    // $url = parse_url($url);
 
    // if ($url['scheme'] != 'http') { 
        // die('Error: Only HTTP request are supported !');
    // }
 
    // // extract host and path:
    // $host = $url['host'];
    // $path = $url['path'];
 
    // // open a socket connection on port 80 - timeout: 30 sec
    // $fp = fsockopen($host, 80, $errno, $errstr, 30);
 
    // if ($fp){
 
        // // send the request headers:
        // fputs($fp, "POST /o/oauth2/token HTTP/1.1 \r\n");
        // fputs($fp, "Host: accounts.google.com \r\n");
 
        // if ($referer != '')
            // fputs($fp, "Referer: $referer\r\n");
 
        // fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        // fputs($fp, "Content-length: ". strlen($params) ."\r\n");
        // fputs($fp, "Connection: close\r\n\r\n");
        // fputs($fp, $params);
 
        // $result = ''; 
        // while(!feof($fp)) {
            // // receive the results of the request
            // $result .= fgets($fp, 128);
        // } 
    // }
    // else { 
        // return array(
            // 'status' => 'err', 
            // 'error' => "$errstr ($errno)"
        // );
    // }
 
    // // close the socket connection:
    // fclose($fp);
 
    // // split the result header from the content
    // $result = explode("\r\n\r\n", $result, 2);
 
    // $header = isset($result[0]) ? $result[0] : '';
    // $content = isset($result[1]) ? $result[1] : '';
 
    // // return as structured array:
    // return array(
        // 'status' => 'ok',
        // 'header' => $header,
        // 'content' => $content
    // );
// }


// // Send a request to example.com 
// $result = post_request($url, $params);
 
// if ($result['status'] == 'ok'){
 
    // // Print headers 
    // echo $result['header']; 
 
    // echo '<hr />';
 
    // // print the result of the whole request:
    // echo $result['content'];
    // echo date("H:m:s");
// }
// else {
    // echo 'A error occured: ' . $result['error']; 
// }









die();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
         <meta charset="UTF-8" />
        <meta name="google" value="notranslate" />
        <meta http-equiv="Content-Language" content="en_US" />
        <title>Video Tag Portal</title>
                            <!--    Style Sheets   -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <link href="css/jquery.dropdown.css" rel="stylesheet" type="text/css"></link>
        <link href="css/main.css" rel="stylesheet" type="text/css"></link>
                            <!--    Javascript files   -->
        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
        <script src="http://popcornjs.org/code/dist/popcorn-complete.js"></script>
        <script src="libraries/jquery.dropdown.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s&sensor=true"></script>
        <script src="includes/functions.js" type="text/javascript"></script>
        <?php
            include 'includes/headJS.php';
        ?>
    </head>
    <body>
    <script>
            console.log('started');
            var code = "<?=$_REQUEST['code'];?>";
            var clientId = encodeURIComponent("<?=GOOGLE_CLIENT_ID;?>");
            var client_secret = "2I5UR3U8xD5Fgpb__Wm_-TPD";
            var redirect_uri = encodeURIComponent("http://vtp.host-ed.me/vtp/prototype/06/test.php");
            var grant_type = "authorization_code";
            
            var url = "http://accounts.google.com/o/oauth2/token/";
            var params = "code=<?=$_REQUEST['code'];?>"+"&client_id="+encodeURIComponent("<?=GOOGLE_CLIENT_ID;?>")+"&client_secret=2I5UR3U8xD5Fgpb__Wm_-TPD"+"&redirect_uri="+encodeURIComponent("http://vtp.host-ed.me/vtp/prototype/06/test.php")+"&grant_type=authorization_code";
            var data = params;
            // $.post(url, params, function(response){
                    // console.log('Response = '+ response);
            // });

            $.ajax({
                type: 'POST',
                url: url,
                crossDomain: true,
                data: data,
                success: function(responseData, textStatus, jqXHR) {
                    console.log('success');
                },
                error: function (responseData, textStatus, errorThrown) {
                    console.log(responseData);
                    console.log('POST failed.');
                }
            });
            
            $.ajax({
                url: url,
                data: { "code":code, "clientId":clientId, "client_secret": client_secret, "redirect_uri": redirect_uri, "grant_type": grant_type },
                type: "POST",
                timeout: 30000,
                dataType: "text", // "xml", "json"
                success: function(data) {
                    // show text reply as-is (debug)
                    alert(data);

                    // show xml field values (debug)
                    //alert( $(data).find("title").text() );

                    // loop JSON array (debug)
                    //var str="";
                    //$.each(data.items, function(i,item) {
                    //  str += item.title + "\n";
                    //});
                    //alert(str);
                },
                error: function(jqXHR, textStatus, ex) {
                    alert(textStatus + "," + ex + "," + jqXHR.responseText);
                }
            });
    </script>
    </body>
</html>