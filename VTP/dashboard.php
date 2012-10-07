<!--
    File Name:      dashboard.php
    Parent File:    index.php
    Description:    
    Last Modified:  Anudeep 10/05
    Copyright:      Echostar Systems @ http://www.echostar.com/
-->
<?php

function getVideoId($url){
    $url = parse_url($url);
    parse_str($url['query'], $query);
    return $query['v'];
}

$videoId = getVideoId("http://www.youtube.com/watch?v=HyAjCOw6AcQ");

$videoLink = "https://www.youtube.com/v/".$videoId."?version=3&enablejsapi=1";
$playerHeight = 340;
$playerWidth = 640;
?>

<div id='header'>
    <table margin="auto">
        <tr>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td style="width:400px;">
                Url:    <input type="text" id="ytUrl" style="width: 75%;"/>
                <input type="button" OnClick="stopVideo()" value="Load" />
            </td>
            <td></td>
            <td><a>Liked</a></td>
            <td><a>Faviorites</a></td>
            <td>Login/Sign Up</td>
        </tr>
    </table>
</div>

<div id="container">
    <div id="contentTop">
        <div id="playerDiv">
            <div id="tag_01" style="left: 100px;  width: 100px; top: 150px; height: 100px; display: none;" class="tag">
                <a href="https:\\www.google.com">test</a>
            </div>
            
            <div id="playerFrame">
                <!-- This div will be replaced by the code from JS: onYouTubeIframeAPIReady() -->
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
            <image src="http://dakotatoday.typepad.com/photos/sdetc/techlogo.jpg" alt="SDSM&T Logo" style="height:300px;">
        </div>
    </div>
    <div id="tagControls">
        <table>
            <td>Show Tags: </td>
            <td><input type="radio" name="tagFilter" checked/>None</td>
            <td><input type="radio" name="tagFilter" checked/>Friends</td>
            <td><input type="radio" name="tagFilter"/>All</td>            
        </table>
    </div>
</div>

<script>
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    
    
    var nxtTag = new Array(3, 15);

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
        setInterval(updatePlayerInfo, 1000);
        //  event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;
    function onPlayerStateChange(event) {
        // if (event.data == YT.PlayerState.PLAYING && !done) {
            // setTimeout(stopVideo, 2000);
            // done = true;
        // }
    }
    
    function stopVideo() {
        player.stopVideo();
    }
    
    function time(){
        player.getDuration();
        player.getCurrentTime();
    }
    
    function updatePlayerInfo(){
        var tag = document.getElementById('tag_01');
        if(player && player.getDuration()) {
            if( player.getCurrentTime() >= nxtTag[0] && player.getCurrentTime() <= nxtTag[1] ){
                tag.style.display = 'block';
            }else{
                tag.style.display = 'none';
            }            
        }
    }
    
    
    function displayTag(){
        alert("display tag at 2000");
    }
</script>