<?php
/*
 *
 * File Name:       functions.php
 * Description:     Useful general functions
 * Created:         10/19/2012
 * Last Modified:   Anudeep 10/25/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */
 
function getYtVideoId($url){
   return parseUrl($url, 'v');
}

function parseUrl($url, $key) {
    $url = parse_url($url);
    parse_str($url['query'], $query);
    return $query[$key];
}

// add script tags to JavaScript
function echoScript($jsCode) {
    echo "<script type='text/javascript'>".$jsCode."</script>";
}


function imageJsYT($videoTag) {
    $script = "ytVideo.image({
                    start: ".$videoTag['start'].",
                    end: ".$videoTag['end'].",
                    href: '',
                    src: '".$videoTag['content']."',
                    text: '',
                    target: 'tagDescription'
                });";
    return $script;
}

function generateYTConent($videoId) {
    global $Db;
    $videoTags = $Db->getYTTags($videoId);
    // create YT player
    $content = "var ytVideo = Popcorn.youtube( '#playerFrame', 'http://www.youtube.com/watch?v=".$videoId."' );";
    
    foreach($videoTags as $videoTag) {
        $action = $videoTag['action'].'JsYT';
        $content = $content.$action($videoTag);
    }
    
    return $content;
}
?>