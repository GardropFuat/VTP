<?php
/*
 *
 * File Name:           addTag.php
 * Description:         Adds Tag entry to the DB
 * Author:              Anudeep Potlapally
 * Created:             12/01/2012
 * Last Modified:       Anudeep 12/01/2012
 * Copyright:           Echostar Systems @ http://www.echostar.com/
 */
 
include_once("config.php");
require_once("libraries/ImageUpload.php");
require_once("libraries/DbConnector.php");

$isTagValid = true;

if(empty($_POST['videoId'])) {
    //  Redirect
    header('Location: notfound.html');
}

$videoId = $_POST['videoId'];
$videoSource = $_POST['videoSource'];
$tagStartTime = $_POST['tagStartTime'];
$tagEndTime = $_POST['tagEndTime'];
$tagType = $_POST['tagType'];

switch($tagType) {
    case 'comment':
        $content = $_POST['comment'];
        break;
    case 'image':
        $imageSrc = $_POST['imageSrc'];
        switch($imageSrc) {
            case 'webLink':
                $content = $_POST['imageUrl'];
                break;
            case 'upload':
                $imageUpload = new ImageUpload();
                $file['image'] = $_FILES['imageUpload'];
                if($file['image']['error'] == 0) {
                    $directory = 'images/tags/';
                    $fileName = strtotime("now");
                    $maxSize = 10;  //  MB
                    if($imageUpload->File($file, $directory, $fileName, $maxSize) != '') {
                        $isTagValid = false;
                    }
                    $content = $imageUpload->GetImagePath();
                }else {
                    $isTagValid = false;
                }
                break;
            default:
                $isTagValid = false;
                break;
        }
        break;
    case 'map':
        $content = array();
        array_push($content, array("markerTitle" =>  $_POST['markerTitle']));
        array_push($content, array("lng" =>  $_POST['lng']));
        array_push($content, array("lat" =>  $_POST['lat']));        
        $content = json_encode($content);        
        break;
    case 'link':
        $content = $_POST['webLink'];
        break;
    default:
        $isTagValid = false;
        break;
}

$userId = $_SESSION['vtpUserId'];


if($isTagValid) {
    // Create new database instance
    $Db = new DbConnector();
    if($videoSource == 'vimeo') {
        $Db->addVimeoTags($userId, $videoId, $tagStartTime, $tagEndTime, $tagType, $content);
        $query = '?vimeoUrl=https://vimeo.com/'.$videoId;
    }else if($videoSource == 'youtube'){
        $Db->addYtTags($userId, $videoId, $tagStartTime, $tagEndTime, $tagType, $content);
        $query = '?ytUrl=http://www.youtube.com/watch?v='.$videoId;
    }
    header("Location: index.php".$query); 
    die('Unable to redirect');
}else {
    die('Error: contact admin');
}

?>