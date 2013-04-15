<?php
/*
 *
 * File Name:       functions.php
 * Description:     Useful general functions
 * Created:         10/19/2012
 * Last Modified:   Anudeep 10/25/12
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */
 
$mapTagCount = 0;

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
    global $Db;

    $videoTag['name'] = $Db->getFirstName($videoTag['userId']);
    $videoTag['content'] = json_encode($videoTag['content']);
    $script = $script."video.code({
                        start: ".$videoTag['start'].",
                        end: ".$videoTag['end'].",
                        onStart: function( ) {
                            showComment('".$videoTag['id']."', '".$videoTag['content']."', '".$videoTag['name']."');
                        },
                        onEnd: function( ) {
                            hideComment('".$videoTag['id']."');
                        }                        
                    });";
    $mapTagCount++;
    return $script;
}

// generates JS code for Map Tags
function mapTagJs($videoTag) {
    global $mapTagCount;
    $script = "content[".$mapTagCount."] = JSON.parse('".$videoTag['content']."');";
    $script = $script."video.code({
                        start: ".$videoTag['start'].",
                        end: ".$videoTag['end'].",
                        onStart: function( ) {
                            showMarker(".$mapTagCount.", content[".$mapTagCount."][0]['markerTitle'], content[".$mapTagCount."][2]['lat'], content[".$mapTagCount."][1]['lng']);
                        },
                        onEnd: function( ) {
                            hideMarker(".$mapTagCount.");
                        }                        
                    });";
    $mapTagCount++;
    return $script;
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

// Returns current page url
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

// Gives current page path
function curPath()
{
    $pagePath = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pagePath .= "s";
    }
    
    $pagePath .= "://";
    
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pagePath .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
    } else {
        $pagePath .= $_SERVER["SERVER_NAME"];
    }

    $reqUri = $_SERVER['REQUEST_URI'];
    
    // remove query at the end of the link
    $pos = strpos($reqUri, '?');
    if($pos !== false) {
        // remove queries at the end
        $reqUri = substr($reqUri, 0, $pos);
    }
    
    // remove filename at the end
    $pos = strripos($reqUri, '/');
    if($pos !== false && $pos !== strlen($reqUri)) {
        $pagePath = $pagePath.substr($reqUri, 0, $pos).'/';
    }
    
    return $pagePath;
}
// generates Javascript Redirect 
function jsRedirect($location, $newPage = false)
{
    $code = "<script>window.location = '".$location."';</script>";
    if($newPage) {
        $code = "<html><head>".$code."</head><body></body></html>";
    }
    echo $code;
}

/********************************************************************
// Function: 			Shorten
// Description:			Shortens the strings which have more charecters than the allowed.
// @param $string: 		String that should be shortened.
// @param $max: 		maximum charecters allowed in the string 
//						default max = 27 which is idle for data tables
********************************************************************/
function Shorten($string, $max = '27') {
	if (strlen($string) > $max)
		$string = substr_replace($string, '...', $max);
    return $string;
}
?>