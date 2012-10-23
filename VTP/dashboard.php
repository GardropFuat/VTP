<!--
    File Name:      dashboard.php
    Parent File:    index.php
    Description:
    Created:        09/27/2012
    Last Modified:  Anudeep 10/05
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
                <!-- This div will be replaced by JS: onYouTubeIframeAPIReady() -->
                Unable to load video...
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


<script  type="text/javascript">
//// Tag Points Should be replace from DB values
var tags = new Array(1, 2, 3, 5, 7, 10, 14, 20);
var tagsStart = {};
    tagsStart[1] = 'action_1';
    tagsStart[2] = 'action_2';
    tagsStart[10] = 'action_10';
    tagsStart[3] = 'action_3';
    tagsStart[5] = 'action_5';
    tagsStart[7] = 'action_7';
    tagsStart[20] = 'action_20';
    tagsStart[14] = 'action_14';

    var player;

    // Load Youtube Iframe Player API
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // Load youtube player with specified youtube videoId
    function onYouTubeIframeAPIReady(playerId) {
        player = new YT.Player('playerFrame', {
            height: '<?= $playerHeight; ?>',
            width: '<?= $playerWidth; ?>',
            videoId: '<?= $videoId; ?>',
            playerVars: { 'html5' : 1 },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    // Player is Ready
    function onPlayerReady(event) {

    }

    //  if palyer state is switched between (UNSTARTED (-1), ENDED (0), PLAYING (1), PAUSED (2), BUFFERING (3), VIDEO CUED (5))
    function onPlayerStateChange(event) {
        if(YT.PlayerState.PLAYING){
            updatePlayerInfo();
        }
    }

    //  Stop Youtube video
    function stopVideo() {
        player.stopVideo();
    }

    // monitors the player time
    function updatePlayerInfo(){
        var played;
        var tagPoint;

        played = parseInt(player.getCurrentTime(), 10);

        if (played) {
            for (var i = 0; tagPoint = tags[i]; i++) {
                if (tagPoint === played) {
                    triggerAction(tagPoint);
                    break;
                }
            }
        }
        //  if video is playing wait 750ms and repeat
        if(YT.PlayerState.PLAYING){
            setTimeout( function(){ updatePlayerInfo(); }, 750);
        }
    }

    // Tag Actions should be implemented here...
    function triggerAction(tagPoint){
        if(tagsStart.hasOwnProperty(tagPoint)) {
            console.log(tagsStart[tagPoint]);
        }
    }

    // hide HTML elements
    // need to pass id's as individual parameters
    function hide() {
        $.each(arguments, function(i, id) {
            $('#' + id).hide();
        });
    }

    // show HTML elements
    // need to pass id's as individual parameters
    function show() {
        $.each(arguments, function(i, id) {
            $('#' + id).show();
        });
    }

</script>