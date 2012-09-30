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
//  style="border: 2px solid rgb(161, 161, 161); left: 100px; position: absolute; width: 100px; top: 150px; height: 100px;

?>

<div id='header'>
    <table>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td>Url:<input type="text" id="ytUrl"/></td>
            <td><button>Load</button></td>
        </tr>
    </table>
</div>


<div id="playerDiv">
    <div id="tags" style="position:absolute;"></div>
    
    <div id="tag" style="border: 2px solid rgb(161, 161, 161); left: 100px; position: absolute; width: 100px; top: 150px; height: 100px;>
        <a href="https:\\www.google.com">test</a>
    </div>
    <div id="player" style="position:relative; z-index:0;">
        <iframe id="playerFrame" 
                type="text/html" 
                width="<?= $playerWidth; ?>" height="<?= $playerHeight; ?>"
                src="http://www.youtube.com/embed/<?= $videoId; ?>?enablejsapi=1&html5=1"
                allowfullscreen 
                frameborder="0">
        </iframe>    
    </div>
</div>

<script>
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // 3. This function creates an <iframe> (and YouTube player)
    //    after the API code downloads.
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
        height: '<?= $playerHeight; ?>',
        width: '<?= $playerWidth; ?>',
        videoId: '<?= $videoId; ?>?enablejsapi=1&html5=1',
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
        });
    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
            setTimeout(stopVideo, 1000);
            done = true;
        }
    }
    
    function stopVideo() {
        player.stopVideo();
    }
</script>