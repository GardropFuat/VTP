<?php
/*
 * File Name:      dashboard.php
 * Parent File:    index.php
 * Description:
 * Created:        09/27/2012
 * Last Modified:  Anudeep 10/25
 * Copyright:      Echostar Systems @ http://www.echostar.com/
 */

$ytUrl = (empty($_REQUEST['ytUrl'])) ? "http://www.youtube.com/watch?v=kweUVUCYRa8" : $_REQUEST['ytUrl']; 
$videoId = getYtVideoId($ytUrl);
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
            <div id="playerFrame">
                <!-- will be replaced by Video from Popcorn javaScript-->
            </div>
        </div>
        <div id="videoInfo"  style="height:<?= $playerHeight;?> px;width:50%;float:right;">
            <div id="addTagFormDiv" style="display:none;" align="center">
                <b>Add Tag</b>
                <!-- Form to add tag for the specific video-->
                <form id="addTagForm" name="addTagForm" onSubmit="return validateTagInfo();" action="addTag.php" method="POST" enctype="multipart/form-data">
                    <table>
                        <tbody>
                            <tr>
                                <td>Start Time:</td>
                                <td>
                                    <input type="text" id="tagStartTime" value="0:0:0" style="width:50px;" disabled>
                                    <input type="text" name="tagStartTime" value="0" style="display:none">
                                    <input type="button" value="Use Current Time" onClick="updateVideoTime('tagStartTime')">
                                </td>
                            </tr>
                            <tr>
                                <td>End Time</td>
                                <td>
                                    <input type="text" id="tagEndTime" value="0:0:0" style="width:50px;" disabled>
                                    <input type="text" name="tagEndTime" value="0" style="display:none">
                                    <input type="button" value="Use Current Time" onClick="updateVideoTime('tagEndTime')">
                                </td>
                            </tr>
                            <tr>
                                <td>Type:</td>
                                <td>
                                    <input type="radio" name="tagType" value="comment" onClick="showHideTagTypes('commentTr')"/>Comment
                                    <input type="radio" name="tagType" value="image" onClick="showHideTagTypes('imageTr')" checked/>Image
                                    <input type="radio" name="tagType" value="map" onClick="showHideTagTypes('mapTr')"/>Map
                                    <input type="radio" name="tagType" value="link" onClick="showHideTagTypes('linkTr')"/>Web Link
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr class="commentTr" style="display:none;">
                                <td>Comment:</td>
                                <td><textarea rows='4' cols='25' id='comment' name='comment'></textarea></td>
                            </tr>
                            <tr class="imageTr">
                                <td>Source:</td>
                                <td>
                                    <input type="radio" name="imageSrc" value="webLink" onClick="imageSrcChange('webLink');" checked/>Web
                                    <input type="radio" name="imageSrc" value="upload" onClick="imageSrcChange('upload');"/>My Computer
                                </td>
                            </tr>
                            <tr class="imageTr" id="imgSrcLink">
                                <td>Link:</td>
                                <td>
                                    <input type="text" name="imageUrl" style="width:250px;" placeholder="http://example.com/01.jpg"/>
                                </td>
                            </tr>
                            <tr class="imageTr" id="imgSrcUpload" style="display:none;">
                                <td>Upload:</td>
                                <td>
                                    <input type="file" accept="image/*" name="imageUpload" id="imageUpload"> 
                                </td>
                            </tr>
                            <tr class="mapTr" style="display:none;">
                                <td>Marker Title:</td>
                                <td><input name="markerTitle" id="markerTitle" maxlength="25"></td>
                            </tr>
                            <tr class="mapTr" style="display:none;">
                                <td style="font-size:11px;">Drag and drop the marker to the prefered location</td>
                                <td style="display:none;">
                                    <!-- Hidden Stuff for form data-->
                                    <input type="text" name="lng" id="lng" value=''>
                                    <input type="text" name="lat" id="lat" value=''>
                                </td>
                            </tr>
                            <tr class="mapTr" style="display:none;">
                                <td></td>
                                <td id="map_canvas" class="map"></td>
                            </tr>
                            <tr class="linkTr" style="display:none;">
                                <td>Url:</td>
                                <td><input name="webLink" id="webLink" placeholder="http://www.google.com"/></td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
                    <div id="addTagFormError" class="error"></div>
                    <input type="text" name="videoId" value="<?=$videoId;?>" style="display:none">
                    <img id="imgPreview" style="display:none;" onError="invalidImageUrl();" onLoad="validImageUrl();">
                    <input type="button" id="previewImgUrl" value="Preview" onClick="previewImgLink();"/>
                    <input type="submit" id="saveAddTagForm" value="Save"/>
                    <input type="button" value="Cancel" onClick="hideAddTagForm();"/>
                </form>
            </div>
            <div id="tagDescription" style="overflow-y:auto;"><!-- Display Picture/Other tags here--></div>
        </div>
    </div>
    <div id="tagControls" style="width:50%">
            Show Tags:
            <input type="radio" name="tagFilter"/>None
            <input type="radio" name="tagFilter"/>Friends
            <input type="radio" name="tagFilter" checked/>All
            <div style="float:right;">
                <a href="#" onClick="showAddTagForm('<?=$videoId;?>');">
                    <!--<img class="ui-icon ui-icon-plusthick"/> -->Add Tag
                </a>
            </div>
    </div>
    <div id="addFavorite"> 
        <?php
        if (!empty($_SESSION['vtpUserId'])) {
            if(checkFavorite($_SESSION['vtpUserId'], $videoId)){
                echo "Currently in favorites";
            }
            else{
                echo '<a id="favLink" href="#" onClick="make_favorite();">Add to Favorites </a>';
            }
            //if (isset($_GET['favorite']) && !checkFavorite($_SESSION['vtpUserId'], $videoId)) 
            //{
            //	make_favorite($videoId);
            //}
        }
        ?>
    </div>

    <div id="commentsDiv">
        <div id="commentsTbl">
            No Comments
        </div>
    </div>
    
    <div id="map"></div>
</div>