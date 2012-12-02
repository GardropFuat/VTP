<!--
    File Name:      dashboard.php
    Parent File:    index.php
    Description:
    Created:        09/27/2012
    Last Modified:  Anudeep 10/25
    Copyright:      Echostar Systems @ http://www.echostar.com/
-->
<?php
$ytUrl = (empty($_POST['ytUrl'])) ? "http://www.youtube.com/watch?v=kweUVUCYRa8" : $_POST['ytUrl']; 
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
                <!-- will be replaced by Video from Popcorn javaScript-->
            </div>
        </div>
        <div id="videoInfo"  style="height:<?= $playerHeight;?> px;width:50%;float:right;">
            <div id="addTagFormDiv" style="display:none;" align="center">
                <b>Add Tag</b>
                <!-- Form to add tag for the specific video-->
                <form id="addTagForm" name="addTagForm" onSubmit="return validateTagInfo();" action="addTag.php" method="POST" enctype="multipart/form-data">
                    <table>
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
                                <input type="radio" name="tagType" value="comment" disabled/>Comment
                                <input type="radio" name="tagType" value="image" onClick="showHideTagTypes('imageTr')" checked/>Image
                                <input type="radio" name="tagType" value="map" disabled/>Map
                                <input type="radio" name="tagType" value="link" disabled/>Web Link
                            </td>
                        </tr>
                        <tr class="commentTr" style="display:none;"></tr>
                        <tr class="imageTr">
                            <td>Source:</td>
                            <td>
                                <input type="radio" name="imageSrc" value="webLink" onClick="$('#imgSrcUpload').hide(); $('#imgSrcLink').show();" checked/>Web
                                <input type="radio" name="imageSrc" value="upload" onClick="$('#imgSrcLink').hide(); $('#imgSrcUpload').show();"/>My Computer
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
                        <tr class="mapTr" style="display:none;"></tr>
                        <tr class="linkTr" style="display:none;"></tr>
                    </table>
                    <br/>
                    <div id="addTagFormError" class="error"></div>
                    <input type="text" name="videoId" value="<?=$videoId;?>" style="display:none">
                    <input type="submit" value="Save"/>
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
    <div id="commentsDiv">
        <div id="commentsTbl">
            No Comments
        </div>
    </div>
</div>