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

function getViemoVideoId($url){
    $url = explode('/', $url);
    return end($url);
}

function parseUrl($url, $key) {
    $isShortUrl = strpos($url, 'youtu.be/');
    
    if($isShortUrl === false) {
        $url = parse_url($url);
        parse_str($url['query'], $query);
        return $query[$key];
    } else {
        $url = explode('/', $url);
        return end($url);
    }
}

// add script tags to JavaScript
function echoScript($jsCode) {
    echo "<script type='text/javascript'>".$jsCode."</script>";
}

//  Generates script for image tags
function imageTagJs($videoTag) {
    $script = "video.image({
                    start: ".$videoTag['start'].",
                    end: ".$videoTag['end'].",
                    href: '',
                    src: '".$videoTag['content']."',
                    text: '',
                    target: 'tagDescription'
                });";
    return $script;
}

function commentTagJs($videoTag) {
    // $script = "video.timeline({
                    // start: ".$videoTag['start'].",
                    // target: 'commentsTbl',
                    // title: '',
                    // text: '".$videoTag['content']."',
                    // innerHTML: ''                    
                // });";
    // return $script;    

    $script = 'video.timeline({
                start: 1,
                target: "commentsTbl",
                title: "This is a title",
                text: "this is some interesting text that goes inside",
                innerHTML: "Click here for <a href=\'http://www.google.ca\'>Google</a>" ,
                direction: "down"
              })';
    //  return $script;
    return '';
}

function mapTagJs($videoTag) {
    $script = "var content = JSON.parse('".$videoTag['content']."');";
    $script = $script."video.googlemap({
                        start: ".$videoTag['start'].",
                        end: ".$videoTag['end'].",
                        type: 'ROADMAP',
                        target: 'map',
                        lat: content[1]['lng'],
                        lng: content[2]['lat'],
                        onmaploaded: alert('Map Loaded')
                    })";
    //  return $script;
    return '';
}

function generateYTVideoScript($videoId) {
    global $Db;
    $videoTags = $Db->getYTTags($videoId);
    //  create YT player 
    //  rel = 0 will disable related videos suggestion at end of each video
    $content = "var video = Popcorn.smart( '#playerFrame', 'http://www.youtube.com/watch?v=".$videoId."&rel=0' );";
    
    foreach($videoTags as $videoTag) {
        $action = $videoTag['action'].'TagJs';
        $content = $content.$action($videoTag);
    }    
    return $content;
}

function generateVimeoVideoScript($videoId) {
    global $Db;
    $videoTags = $Db->getViemoTags($videoId);
    //  create YT player 
    //  rel = 0 will disable related videos suggestion at end of each video
    $content = "var video = Popcorn.vimeo( '#playerFrame', 'http://player.vimeo.com/video/".$videoId."' );";
    
    foreach($videoTags as $videoTag) {
        $action = $videoTag['action'].'TagJs';
        $content = $content.$action($videoTag);
    }    
    return $content;
}

function checkFavorite($userId, $videoId){
	global $Db;
	return	$Db->isFavorite($userId, $videoId);
}

function addToFavorites($userId, $videoId){
	global $Db;
	return $Db->addFavorites($userId, $videoId);
}

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    
    $pageURL .= "://";
    
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    
    return $pageURL;
}
?>