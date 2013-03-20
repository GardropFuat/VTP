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
        <div class="form" align="center">
            <form action="<?=curPageURL();?>" method="post">
                <h1>Upload Video: Step 1</h1>
                <p>
                    <label style="padding-left:50px;">Title</label>
                    <input type="text" name="video_title"/>
                </p>
                <p>
                    <label style="vertical-align:top;">Description</label>
                    <textarea id="video-description" name="video_description" style="height:100px;"></textarea>
                </p>
                <p>
                    <label>Category</label>
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
                    </select>
                </p>
                <p>
                    <label style="padding-left:10px;">Keywords</label>
                    <input type="text" name="video_keywords"/>
                </p>
                <p>
                    <label style="padding-left:10px;"><input type="checkbox" name="disclaimer"/>Allow VTP to upload this video into YouTube</label>                    
                </p>
                <p>
                    <input type="submit" id="submitBtn" value="Proceed to Step 2" style="width:180px;" disabled/>
                    <input type="button" value="Cancel" onClick="window.location='index.php'" style="width:100px;"/>
                </p>
            </form> <!-- /form -->
        </div>
        <?php echo ($response->token);?>
<!-- Step 2 -->
<?php elseif( isset($response) && $response->token != '' ) : ?>
        <div class="form" align="center">
            <table cellspacing="15">
            <tr>
                <td style="float:right"><label>Title&nbsp;</label></td>
                <td><span style="width:380px;"><?=$video_title;?></span></td>
            </tr>
            <tr>
                <td style="float:right;"><label>Description&nbsp;</label></td>
                <td><span style="width:380px;"><?=$video_description;?></span></td>
            </tr>
            <form action="<?php echo( $response->url ); ?>?nexturl=<?=$nexturl;?>" method="post" onSubmit='return validateFile();' enctype="multipart/form-data">
            <tr class="block">
                <td style="float:right;padding-top:10px;"><label>Upload Video</label></td>
                <td><span class="youtube-input">
                    <input id="file" type="file" name="file" accept='video/*'/>
                </span></td>
            </tr>
            </table>
                <input type="hidden" name="token" value="<?php echo( $response->token ); ?>"/>
                <input type="hidden" name="video_keywords" value="<?php echo( $_POST['video_keywords']); ?>"/>
                <input type="hidden" name="category" value="<?php echo( $_POST['category']); ?>"/>
                <input type="submit" value='Upload' style="width: 120px;">
            </form>
        </div>
<!-- Final Step -->
<?php elseif( isset($unique_id)  && $status = '200' ) : ?>
        <div id="video-success" class="form">
            <h4>Video Successfully Uploaded!</h4>
            <p>Here is your url to view your video on VTP: <a href="index.php?ytUrl=http://www.youtube.com/watch?v=<?php echo $unique_id; ?>" target="_SELF">here</a></p>
            <p>The video should be up any moment but could take up to 3 hours to be finished, Please Be Patient.</p>
            <p><input type="hidden" name="ytUrl" value="http://www.youtube.com/watch?v=<?php echo $unique_id; ?>"/></p>
            <input type="button" value="Finish" onClick="window.location='index.php'"/>
        </div> <!-- /div#video-success -->
<?php
    endif;

    if(isset($videoEntry)) {
        $state = $videoEntry->getVideoState();
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

<script>
    $('[name=disclaimer]').change(function() {
        if(this.checked) {
            $('#submitBtn').attr('disabled', false);
        }else {
            $('#submitBtn').attr('disabled', true);
        }
    });
    
    function  validateFile(){
        if($('#file').val() !== '')
            return true;
        return false;
    }
</script>

<?php
    include_once( 'tail_std.php' );
?>