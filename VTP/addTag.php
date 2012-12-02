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

require_once("libraries/ImageUpload.php");

$isTagValid = true;

if(empty($_POST['videoId'])) {
    //  Redirect
    header('Location: notfound.html');
}

$videoId = $_POST['videoId'];
$tagStartTime = $_POST['tagStartTime'];
$tagEndTime = $_POST['tagEndTime'];
$tagType = $_POST['tagType'];

switch($tagType) {
    case 'comment':
        break;
    case 'image':
        $imageSrc = $_POST['imageSrc'];
        switch($imageSrc) {
            case 'webLink':
                $imageUrl = $_POST['imageUrl'];
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
        break;
    case 'link':
        break;
    default:
        $isTagValid = false;
        break;
}

if($isTagValid) {
    echo $videoId.";".$tagStartTime.";".$tagEndTime.";".$tagType.";".$content;
    // Create new database instance
    // $Db = new DbConnector();
    // if($Db->addYtTags($videoId, $tagStartTime, $tagEndTime, $tagType, $content)) {
        // header("Location: index.php");
    // }else {
        // header("Location: index.php"); 
    // }
}else {
    echo 'Error: contact admin';
}

?>