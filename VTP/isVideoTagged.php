<?php
/**
  * Checks if the requested YouTube videoIds has any tags in VTP
  */

if(isset($_POST["json"])) {

    include_once 'libraries/DbConnector.php';
    $Db = new DbConnector();

    $jsonInput = stripslashes($_POST["json"]);
    $videoIds = json_decode($jsonInput);

    $taggedVideoIds = Array();
    
    foreach($videoIds as $videoId) {
        $videoId = $videoId[0];
        if($Db->isVideoTagged( $videoId )) {
            array_push($taggedVideoIds, $videoId);
        }
    }
    
    echo json_encode($taggedVideoIds);
}    
?>