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

<div class='header'>
    <table class="headerTable">
        <tr>
            <td style="width:500px;">
                Url:    <input type="text" id="ytUrl" style="width: 80%;"/>
                <input type="button" OnClick="stopVideo()" value="Load" />
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><a href="#">Liked</a></td>
            <td><a href="#">Faviorites</a></td>
            <td><a href="#">Login/Sign Up</a></td>
        </tr>
    </table>
</div>

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
                <iframe id="playerFrame" 
                    type="text/html" 
                    width="<?= $playerWidth; ?>" height="<?= $playerHeight; ?>"
                    src="http://www.youtube.com/embed/<?= $videoId; ?>?enablejsapi=1&html5=1"
                    frameborder="0">
                </iframe>  
            </div>
        </div>
        <div id="tagDescription" style="height:<?= $playerHeight;?> px; ">
            <!-- Display Picture here-->
            <image id="sdsmtImage" src="http://dakotatoday.typepad.com/photos/sdetc/techlogo.jpg" alt="SDSM&T Logo" style="height:300px; margin-top: 20px; display:none;">
            <image id="saeResults" src="images/saeResults.png" alt="See Results at http://students.sae.org/competitions/supermileage/results/2012.pdf" style="height:300px; margin-top: 20px; display:none;">
            <image id="supermileageSae" src="images/supermileageSae.png" alt="More details on Supermileage SAE" style="height:300px; margin-top: 20px; display:none;">
            <image id="mapMines" src="images/mapMines.png" alt="Mines on Google Maps" style="height:300px; margin-top: 20px; display:none;">
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
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    
    var tagMines = new Array(1, 4);
    var tagCar = new Array(9, 15);
    var tagNucor = new Array(16, 22);
    var tagSae = new Array(25, 29);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
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

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        //  event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;
    var showTimer, hideTimer;
    function onPlayerStateChange(event) {        
        if (event.data == YT.PlayerState.PLAYING) {
            if(tagMines[0] > player.getCurrentTime()){
                var start = (tagMines[0] - player.getCurrentTime()) * 1000;
                showTimer = setTimeout( function(){show("tagMines", "sdsmtImage")}, start);
                var end = ( tagMines[1] - player.getCurrentTime() ) * 1000;
                hideTimer = setTimeout( function(){hide("tagMines", "sdsmtImage")}, end);
            }
            if(tagCar[0] > player.getCurrentTime()){
                var start = (tagCar[0] - player.getCurrentTime()) * 1000;
                showTimer = setTimeout( function(){show("tagCar", "supermileageSae")}, start);
                var end = ( tagCar[1] - player.getCurrentTime() ) * 1000;
                hideTimer = setTimeout( function(){hide("tagCar", "supermileageSae")}, end);
            }
            if(tagNucor[0] > player.getCurrentTime()){
                var start = (tagNucor[0] - player.getCurrentTime()) * 1000;
                showTimer = setTimeout( function(){show("tagNucor", "saeResults")}, start);
                var end = ( tagNucor[1] - player.getCurrentTime() ) * 1000;
                hideTimer = setTimeout( function(){hide("tagNucor", "saeResults")}, end);
            }   
            if(tagSae[0] > player.getCurrentTime()){
                var start = (tagSae[0] - player.getCurrentTime()) * 1000;
                showTimer = setTimeout( function(){show("tagSae", "mapMines")}, start);
                var end = ( tagSae[1] - player.getCurrentTime() ) * 1000;
                hideTimer = setTimeout( function(){hide("tagSae", "mapMines")}, end);
            }
        }else if(event.data == YT.PlayerState.PAUSED){
            if(tagMines[0] > player.getCurrentTime()){
                var diff = ( player.getCurrentTime() - tagMines[1] ) * 1000;
                clearTimeout(timer);
            }
        }
    }
    
    function stopVideo() {
        player.stopVideo();
    }
    
    function hide() {
        $.each(arguments, function(i, id) {
            $('#' + id).hide();
        });
    }    
    
    function show() {
        $.each(arguments, function(i, id) {
            $('#' + id).show();
        });
    }
    
    function echo(msg){
        $('#JsConsole').append('<br/>' + msg);
    }
</script>