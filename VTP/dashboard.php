<!--
    File Name:      dashboard.php
    Parent File:    index.php
    Description:
    Created:        09/27/2012
    Last Modified:  Anudeep 10/25
    Copyright:      Echostar Systems @ http://www.echostar.com/
-->
<?php
if($_POST["ytUrl"] == ""){$_POST["ytUrl"] = "http://www.youtube.com/watch?v=kweUVUCYRa8";}
$videoId = getYtVideoId($_POST["ytUrl"]);
//  get video title from youtube
$videoData = file_get_contents("http://youtube.com/get_video_info?video_id=".$videoId);
parse_str($videoData, $videoData);
$videoTitle = $videoData['title'];

$videoLink = "https://www.youtube.com/v/".$videoId."?version=3&enablejsapi=1";
$playerHeight = 340;
$playerWidth = 640;
?>

<div id="container">
    <div id="contentTop">
        <div class="videoTitle"><?= $videoTitle; ?></div>
        <div id="playerDiv" style="width:50%">
            <div id="tagMines" style="display: none; left: 240px; top: 40px; height: 200px; width: 170px;" class="tag">
                &nbsp;&nbsp;&nbsp;
            </div>
            <div id="tagCar" style="top: 150px; height: 100px; display: none; left: 300px; width: 200px;" class="tag">
                &nbsp;&nbsp;&nbsp;
            </div>
            <div id="tagNucor" style="top: 150px; height: 100px; display: none; width: 140px; left: 280px;" class="tag">
                &nbsp;&nbsp;&nbsp;
            </div>
            <div id="tagSae" style="height: 100px; display: none; left: 70px; top: 160px; width: 90px;" class="tag">
                &nbsp;&nbsp;&nbsp;
            </div>
            <div id="playerFrame">
                <!-- will be replaced by Popcorn javaScript-->
            </div>
        </div>
        <div id="tagDescription" style="height:<?= $playerHeight;?> px;width:50%">
            <!-- Display Picture here-->
        </div>
    </div>
    <div id="tagControls" style="width:50%">
            Show Tags: 
            <input type="radio" name="tagFilter"/>None            
            <input type="radio" name="tagFilter"/>Friends
            <input type="radio" name="tagFilter" checked/>All
            <div style="float:right;">
                <a href="#" onClick="addTag('<?=$videoId;?>');">
                    <!--<img class="ui-icon ui-icon-plusthick"/> -->Add Tag
                </a>
            </div>
    </div>
    <div id="commentsDiv">
        <div id="commentsTbl">
            No Comments
        </div>
    </div>
</div>

<div id="JsConsole" style="margin-top:20px;"><!--testing Output console for javascript--></div>
