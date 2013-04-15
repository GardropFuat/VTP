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
    $profileImg = '<img src="http://graph.facebook.com/'.$_SESSION['facebookId'].'/picture" height="100" width"100"><br>';
}else if(!empty($_SESSION['googleId'])){
    $profileImg = '<img src="'.$_SESSION['googleProfileImg'].'" height="100" width"100"><br>';
}else {
    die('Restricted access. Contact administrator.');
}

?>
        
<script type='text/javascript'>
    function getlink (selectedSite)
    {
      document.site.ytUrl.value = selectedSite ;
      document.site.submit() ;
    }
</script>


<h1><?php echo $_SESSION['vtpUserName']; ?></h1>
<?=$profileImg;?>
<?php
//  echo('<a href='.$facebook['link'].'>View Facebook Profile</a><br>');
?>

<div id="profileContainer">
    <div id="favorites" style="width:50%; float:left;">
        <h2>Favorites</h2>

       <table class="videoResults" style="cursor:pointer;">
            <?php
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
            ?>
        </table>
    </div>
    <div id="uploads" style="width:50%; float:right;">
        <h2>Uploads</h2>
    </div>
</div>
<?php
    include_once( "tail_std.php" );
?>