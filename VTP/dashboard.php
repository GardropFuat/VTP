<!--
    File Name:      dashboard.php
    Parent File:    index.php
    Description:
    Created:        09/27/2012
    Last Modified:  Anudeep 10/25
    Copyright:      Echostar Systems @ http://www.echostar.com/
-->
<?php
$videoId = getYtVideoId("http://www.youtube.com/watch?v=BFph8eXlB98&list=UUAwSwbluTDUlhHPivGcBczQ&index=1&feature=plcp");
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
        <div id="playerDiv">
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
        <div id="tagDescription" style="height:<?= $playerHeight;?> px; ">
            <!-- Display Picture here-->
        </div>
    </div>
    <div id="tagControls">
        <table id="tagCtrlsTbl">
            <td>Show Tags: </td>
            <td><input type="radio" name="tagFilter"/>None</td>
            <td><input type="radio" name="tagFilter"/>Friends</td>
            <td><input type="radio" name="tagFilter" checked/>All</td>
            <td width="280px;"></td>
            <td><a href="#"><img class="ui-icon ui-icon-plusthick"/></a></td>
            <td><a href="#">Add Tag</a></td>
        </table>
    </div>
    <div id="commentsDiv">
        <div id="commentsTbl">
            No Comments
        </div>
    </div>
</div>

<div id="JsConsole" style="margin-top:20px;"><!--testing Output console for javascript--></div>
