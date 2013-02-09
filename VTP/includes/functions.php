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

function commentTagJs($videoTag) {
    // $script = "ytVideo.timeline({
                    // start: ".$videoTag['start'].",
                    // target: 'commentsTbl',
                    // title: '',
                    // text: '".$videoTag['content']."',
                    // innerHTML: ''                    
                // });";
    // return $script;    

    $script = 'ytVideo.timeline({
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
    $script = $script."ytVideo.googlemap({
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

function videoTestMode() {
    $script = "ytVideo.volume(1);ytVideo.play();";
    echoScript($script);
}

function checkFavorite($userId, $videoId){
	global $Db;
	return	$Db->isFavorite($userId, $videoId);
}

function addToFavorites($userId, $videoId){
	global $Db;
	return $Db->addFavorites($userId, $videoId);
}
?>