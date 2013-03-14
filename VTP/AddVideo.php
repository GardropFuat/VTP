<?php
/**
 *
 * File Name:       AddVideo.php
 * Description:     Base file for the project.
 * Author:
 * Created:         1/24/13
 * Last Modified:   Travis 2/2/13
 * Copyright:       Echostar Systems @ http://www.echostar.com/
 */

include_once( 'head_std.php' );

if( isset( $_POST['video_title'] ) && isset( $_POST['video_description'] ) ) {
    $video_title = stripslashes( $_POST['video_title'] );
    $video_description = stripslashes( $_POST['video_description'] );
    include_once( 'get_youtube_token.php' );
}

$nexturl = urlencode(curPageURL());

if(isset( $_GET['id']) && isset($_GET['status']))
{
    $unique_id = $_GET['id'];
    $status = $_GET['status'];
}

?>

<!-- Step 1 of the youtube upload process -->
<?php if( empty( $_POST['video_title'] ) && !isset($unique_id) ) : ?>
    <table>
        <form action="<?=curPageURL();?>" method="post">
            <tr><td><label for="video_title">Video Title</label></td></tr>
            <tr><td><input type="text" name="video_title" /></td></tr>
            <tr><td><label for="video_description">Video Description</label></td></tr>
            <tr><td><textarea id="video-description" name="video_description"></textarea></td></tr>
            <tr><td><label for="category">Category</label></td>
                <td>
                <select id="category" name="category">
                    <option>Film</option>
                    <option>Autos</option>
                    <option>Music</option>
                    <option>Animals</option>
                    <option>Sports</option>
                    <option>Travel</option>
                    <option>Shortmov</option>
                    <option>Games</option>
                    <option>Videblog</option>
                    <option>People</option>
                    <option>Comedy</option>
                    <option>Entertainment</option>
                    <option>News</option>
                    <option>Howto</option>
                    <option>Education</option>
                    <option>Tech</option>
                    <option>Nonprofit</option>
                    <option>Movies</option>
                    <option>Movies_anime_action</option>
                    <option>Movies_action_adventure</option>
                    <option>Movies_classics</option>
                    <option>Movies_comedy</option>
                    <option>Movies_documentary</option>
                    <option>Moves_drama</option>
                    <option>Movies_family</option>
                    <option>Movies_foreign</option>
                    <option>Movies_horror</option>
                    <option>Movies_sci_fi_fantasy</option>
                    <option>Movies_thriller</option>
                    <option>Movies_shorts</option>
                    <option>Shows</option>
                    <option>Trailers</option>
            </select></td></tr>
            <tr><td><label for="video_keywords">Video Keywords</label></td></tr>
            <tr><td><input type="text" name="video_keywords"/></td></tr>
            <tr><td><input type="submit" value="Proceed to Step 2" /></td></tr>
        </form> <!-- /form -->
    </table>
        <?php echo ($response->token);?>
<!-- Step 2 -->
<?php elseif( isset($response) && $response->token != '' ) : ?>
        <h4>Title:</h4>
        <p><?php echo $video_title; ?></p>
        <h4>Description:</h4>
        <p><?php echo $video_description; ?></p>
        <form action="<?php echo( $response->url ); ?>?nexturl=<?=$nexturl;?>" method="post" enctype="multipart/form-data">
            <p class="block">
                <label>Upload Video</label>
                <span class="youtube-input">
                    <input id="file" type="file" name="file" />
                </span>
            </p>
            <input type="hidden" name="token" value="<?php echo( $response->token ); ?>"/>
            <input type="hidden" name="video_keywords" value="<?php echo( $_POST['video_keywords']); ?>"/>
            <input type="hidden" name="category" value="<?php echo( $_POST['category']); ?>"/>
            <input type="submit" value='Upload'>
        </form>

<!-- Final Step -->
<?php elseif( isset($unique_id)  && $status = '200' ) : ?>
        <div id="video-success">
            <h4>Video Successfully Uploaded!</h4>
            <form action="index.php" method="post">
                <p>Here is your url to view your video in YouTube:<a href="http://www.youtube.com/watch?v=<?php echo $unique_id; ?>" target="_blank">http://www.youtube.com/watch?v=<?php echo $unique_id; ?></a></p>
                <p>The video should be up any moment but could take up to 3 hours to be finished, Please Be Patient.
                <input type="hidden" name="ytUrl" value="http://www.youtube.com/watch?v=<?php echo $unique_id; ?>"/>
                <input type="submit" value="Finish" />
        </div> <!-- /div#video-success -->
<?php
  endif;

if(isset($videoEntry)) {
    $state = $videoEntry->getVideoState();
    echo "Here";
    if (isset($state)) {
        echo 'Upload status for video ID ' . $videoEntry->getVideoId() . ' is ' .
        $state->getName() . ' - ' . $state->getText() . "\n";
    } else {
        echo "Not able to retrieve the video status information yet. " .
                    "Please try again later.\n";
    }
}
?>
<script src="includes/GoogleAuth.js"></script>
<?php
    include_once( 'tail_std.php' );
?>