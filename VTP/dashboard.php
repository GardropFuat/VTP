<?php
/*
 * File Name:      dashboard.php
 * Parent File:    index.php
 * Description:
 * Created:        09/27/2012
 * Last Modified:  Anudeep 10/25
 * Copyright:      Echostar Systems @ http://www.echostar.com/
 */


$userId = $_SESSION['vtpUserId'];
$posArray = $Db->getContainerPos($userId);
$posArray = $posArray[0];
//print_r($posArray);
//echo($posArray['tagContainer1_x']);
//echo($posArray['tagContainer1_y']);
?>
<div id="container">
    <div id="contentTop">
        <div class="videoTitle" id="videoTitle"><?= $videoTitle; ?></div>
        <div id="playerDiv" style="width:50%" >
            <div id="playerFrame">
                <!-- will be replaced by Video from Popcorn javaScript(bodyJS.php) -->
            </div>
            <div id="tagControls">
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
                <a id="favLink" href="#"></a>
            </div>
            <div id="commentsDiv">
                <div id="commentsTbl">                    
                </div>
            </div>
        </div>
        <div id="videoInfo"  style="height:<?= $playerHeight;?> px;width:50%;float:right;">
            <div id="addTagFormDiv" style="display:none;" align="center">
                <!-- Form to add tag for the specific video-->
                <form class="form" id="addTagForm" name="addTagForm" onSubmit="return validateTagInfo();" action="addTag.php" method="POST" enctype="multipart/form-data">
                    <h3>Add Tag</h3>
                    <p>
                        <label style="padding-left:50px;">Start Time:</label>
                        <input type="text" id="tagStartTime" value="0:0:0" style="width:50px;" disabled>
                        <input type="text" name="tagStartTime" value="0" style="display:none">
                        <input type="button" value="Use Current Time" onClick="updateVideoTime('tagStartTime')" style="width:140px;">
                    </p>    
                    <p>
                        <label style="padding-left:50px;">End Time:</label>
                        <input type="text" id="tagEndTime" value="0:0:0" style="width:50px;" disabled>
                        <input type="text" name="tagEndTime" value="0" style="display:none">
                        <input type="button" value="Use Current Time" onClick="updateVideoTime('tagEndTime')" style="width:140px;">
                    </p>    
                    <p>
                        <label style="padding-left:50px;">Type:</label>
                        <input type="radio" name="tagType" value="comment" onClick="showHideTagTypes('commentTr')"/>Comment
                        <input type="radio" name="tagType" value="image" onClick="showHideTagTypes('imageTr')" checked/>Image
                        <input type="radio" name="tagType" value="map" onClick="showHideTagTypes('mapTr')"/>Map
                        <input type="radio" name="tagType" value="link" onClick="showHideTagTypes('linkTr')"/>Web Link
                    </p>
                    <p class="commentTr" style="display:none;">
                        <label style="vertical-align:top;">Comment:</label>
                        <textarea rows='4' cols='25' id='comment' name='comment'></textarea>
                    </p>
                    <p  class="imageTr">
                        <label style="padding-left:50px;">Source:</label>
                        <input type="radio" name="imageSrc" value="webLink" onClick="imageSrcChange('webLink');" checked/>Web
                        <input type="radio" name="imageSrc" value="upload" onClick="imageSrcChange('upload');"/>My Computer
                    </p>
                    <p class="imageTr" id="imgSrcLink">
                        <label style="padding-left:50px;">Link:</label>
                        <input type="text" name="imageUrl" style="width:250px;" placeholder="http://example.com/01.jpg"/>
                    </p>
                    <p class="imageTr" id="imgSrcUpload" style="display:none;">
                        <label style="padding-left:50px;">Upload:</label>
                        <input type="file" accept="image/*" name="imageUpload" id="imageUpload" style="width:300px;"> 
                    </p>
                    <p  class="mapTr" style="display:none;">
                        <label style="padding-left:50px;">Marker Title:</label>
                        <input name="markerTitle" id="markerTitle" maxlength="25" style="width:150px;">
                    </p>
                    <p  class="mapTr" style="display:none;">
                        <label style="padding-left:50px;">Drag and drop the marker to the prefered location</label>
                        <!-- Hidden Stuff for form data-->
                        <input type="text" name="lng" id="lng" value='' style="display:none;">
                        <input type="text" name="lat" id="lat" value='' style="display:none;">
                    </p>
                    <p class="mapTr map" id="map_canvas"style="display:none;margin-left: 150px;"></p>
                    <p class="linkTr" style="display:none;">
                        <label style="padding-left:50px;">Url:</label>
                        <input name="webLink" id="webLink" placeholder="http://www.google.com" style="width:150px;"/>
                    </p>
                    <p style="margin:0px;">
                        <label style="color:red;" id="addTagFormError" class="error"></label>
                        <input type="text" name="videoId" id="videoId" value="" style="display:none">
                        <input type="text" name="videoSource" id="videoSource" value="" style="display:none">
                        <img id="imgPreview" style="padding:0px 50px;display:none;" onError="invalidImageUrl();" onLoad="validImageUrl();">
                    </p>
                    <p>
                        <label style="padding-left:50px;"></label>
                        <input type="button" id="previewImgUrl" value="Preview" onClick="previewImgLink();" style="width:80px;"/>
                        <input type="submit" id="saveAddTagForm" value="Save" style="width:50px;"/>
                        <input type="button" value="Cancel" onClick="hideAddTagForm();" style="width:75px;"/>
                    </p>
                </form>
            </div>
            <!--<div id="tagDescription" style="overflow-y:auto;position: relative; left: <?echo($posArray['tagContainer1_x']);?>px; top: <?echo($posArray['tagContainer1_y']);?>px"><!-- Display Picture/Other tags here </div> -->
            <div id="tagDescription" style="overflow-y:auto"><!-- Display Picture/Other tags here--></div>
            <div id="map">
                <div id="actualMap" style="margin-left:150px;max-height:400px;max-width:400px;"></div>
            </div>
        </div>
    </div>    
</div>