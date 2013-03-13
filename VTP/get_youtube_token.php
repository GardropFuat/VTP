
<?php

define("YOUTUBE_DEVELOPER_KEY", 'AI39si7zLxgtuhVYtL4GcpnoWpgtanI0Ye3G1FyOdyvrJmhS-n2X6KK7eJDYZS7n5nI9WM_7ny0ZzBhcztbrlia3DHIPOXEAdQ');
define("GOOGLE_DEVELOPER_KEY", 'AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s');

//  $tokenData = json_decode($_SESSION['token'],true);
$accessToken = $_SESSION['googleId'];


$youtube_video_title = $_POST['video_title']; // This is the uploading video title.
$youtube_video_description = $_POST['video_description']; // This is the uploading video description.
$youtube_video_keywords = $_POST['video_keywords']; // This is the uploading video keywords.
$youtube_video_category = $_POST['category']; // This is the uploading video category. There are only certain categories that are accepted. See below

/*
 * Accepted Categories:
 *
    Film
    Autos
    Music
    Animals
    Sports
    Travel
    Shortmov
    Games
    Videblog
    People
    Comedy
    Entertainment
    News
    Howto
    Education
    Tech
    Nonprofit
    Movies
    Movies_anime_action
    Movies_action_adventure
    Movies_classics
    Movies_comedy
    Movies_documentary
    Moves_drama
    Movies_family
    Movies_foreign
    Movies_horror
    Movies_sci_fi_fantasy
    Movies_thriller
    Movies_shorts
    Shows
    Trailers
 */

$data = '<?xml version="1.0"?>
            <entry xmlns="http://www.w3.org/2005/Atom"
              xmlns:media="http://search.yahoo.com/mrss/"
              xmlns:yt="http://gdata.youtube.com/schemas/2007">
              <media:group>
                <media:title type="plain">' . stripslashes( $youtube_video_title ) . '</media:title>
                <media:description type="plain">' . stripslashes( $youtube_video_description ) . '</media:description>
                <media:category
                  scheme="http://gdata.youtube.com/schemas/2007/categories.cat">'.$youtube_video_category.'</media:category>
                <media:keywords>'.$youtube_video_keywords.'</media:keywords>
              </media:group>
            </entry>';

$headers = array(   "Authorization: Bearer ".$accessToken,
                    "GData-Version: 2",
                    "X-GData-Key: key=".YOUTUBE_DEVELOPER_KEY,
                    "Content-length: ".strlen( $data ),
                    "Content-Type: application/atom+xml; charset=UTF-8"
                );
$curl = curl_init( "http://gdata.youtube.com/action/GetUploadToken"); 
curl_setopt( $curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"] );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $curl, CURLOPT_TIMEOUT, 100 );
curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $curl, CURLOPT_POST, 1 );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
curl_setopt( $curl, CURLOPT_REFERER, true );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $curl, CURLOPT_HEADER, 0 );

$response = simplexml_load_string( curl_exec( $curl ) );
curl_close( $curl );

print_r($response);
?>