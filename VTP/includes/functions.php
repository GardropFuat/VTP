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

//  Generates script for image tags
function imageTagJs($videoTag) {
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

function generateVideoScript($videoId) {
    global $Db;
    $videoTags = $Db->getYTTags($videoId);
    //  create YT player 
    //  rel = 0 will disable related videos suggestion at end of each video
    $content = "var ytVideo = Popcorn.smart( '#playerFrame', 'http://www.youtube.com/watch?v=".$videoId."&rel=0' );";
    
    foreach($videoTags as $videoTag) {
        $action = $videoTag['action'].'TagJs';
        $content = $content.$action($videoTag);
    }
    
    return $content;
}
?>