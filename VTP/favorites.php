<?php
/**
 *
 * File Name:       favorites.php
 * Description:     Find the friends that are uploading videos to our site
 * Author:
 * Created:         09/27/2012
 * Last Modified:   Travis 3/05/13
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */
include_once( "head_std.php" );

$favVideos = $Db->getFavorites($_SESSION['vtpUserId']);

if(!empty($_SESSION['facebookId'])) {
    $profileImgSrc = 'http://graph.facebook.com/'.$_SESSION['facebookId'].'/picture';
}else if(!empty($_SESSION['googleId'])){
    $profileImgSrc = (empty($_SESSION['googleProfileImg'])) ? 'images/unknown_person.jpg':$_SESSION['googleProfileImg'];
}else{
    die('Restricted access. Contact administrator.');
}

?>
        
<script type='text/javascript'>
    function getlink (selectedSite) {
      document.site.ytUrl.value = selectedSite;
      document.site.submit() ;
    }
</script>


<h1><?php echo $_SESSION['vtpUserName']; ?></h1>
<img src="<?=$profileImgSrc;?>" height="100" width"100"><br>

<div id="profileContainer">
    <div id="favorites" style="width:50%; float:left;">
        <h2>Favorites</h2>

       <table class="videoResults" style="cursor:pointer;">
            <?php
                if(empty($favVideos)) {
                    echo 'No Videos were found';
                }else {
                    foreach ($favVideos as $video)
                    {
                        //  get video title from youtube
                        $link = "https://gdata.youtube.com/feeds/api/videos/".$video['videoId']."?v=2";
                        $xml = simplexml_load_file($link);
                        $videoTitle = $xml->title;
                        $matches = $xml->xpath('media:group/media:description');
                        $videoDes = Shorten($matches[0], 100);
                        $imgSrc = '//img.youtube.com/vi/'.$video['videoId'].'/2.jpg';
                        echo '<tr onclick="window.location = \'index.php?ytUrl=http://www.youtube.com/watch?v='.$video['videoId'].'\'" >';
                        echo '<td><img src="'.$imgSrc.'" alt="'.$videoTitle.'"/></td>';
                        echo '<td id="info"><span><span id="title">'.$videoTitle.'</span><br/>';
                        echo '<span id="description">'.$videoDes.'</span></span></td></tr>';
                    }
                }
            ?>
        </table>
    </div>
    <div id="uploads" style="width:50%; float:right;">
        <h2>Uploads</h2>
        <table class="videoResults" style="cursor:pointer;">
            <?php
                if(!empty($_SESSION['access_token'])) {
                    $link = 'http://gdata.youtube.com/feeds/api/users/default/uploads?oauth_token='.$_SESSION['access_token'];
                    $xml = simplexml_load_file($link);
                    if(empty($xml->entry)) {
                        echo 'No videos were found';
                    }else{
                        foreach($xml->entry as $entry) {
                            $videoId = end(explode('/', $entry->id));
                            $videoTitle = $entry->title;
                            $videoDes = $entry->content;
                            $imgSrc = '//img.youtube.com/vi/'.$videoId.'/2.jpg';
                            echo '<tr onclick="window.location = \'index.php?ytUrl=http://www.youtube.com/watch?v='.$videoId.'\'" >';
                            echo '<td style="width:185px;"><img src="'.$imgSrc.'" alt="'.$videoTitle.'"/></td>';
                            echo '<td id="info"><span><span id="title">'.$videoTitle.'</span><br/>';
                            echo '<span id="description">'.$videoDes.'</span></span></td></tr>';
                        }
                    }
                }else{
                    echo 'Please link you google account to see the uploads';
                }
            ?>
        </table>
    </div>
</div>
<?php
    include_once( "tail_std.php" );
?>