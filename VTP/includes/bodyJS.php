<?php
/*
 *
 * File Name:           bodyJS.php
 * Description:         Contains JS code to include at end of the <body>
 * Author:
 * Created:             10/25/2012
 * Last Modified:       Anudeep 10/25/12
 * Copyright:           Echostar Systems @ http://www.echostar.com/
 */

if(!empty($videoId)) {
    // set player height and width
    echoScript("$('#playerFrame').height(".$playerHeight.")"); //    .width(".$playerWidth.")");

    // generate player and set actions
    $ytContent = generateVideoScript($videoId);
    echoScript( $ytContent );

    //Enter test Mode
    videoTestMode();
}
?>

<script type="text/javascript">
var tagTypes = Array("commentTr", "imageTr", "mapTr", "linkTr");
var formError = new Array(false, '');

/*
 * Hides Add tag form and shows pictures
 */
function hideAddTagForm() {
    $('#tagDescription').css('display', 'block');
    $('#addTagFormDiv').css('display', 'none');
}

/*
 * Hides pictures and shows Add tag form
 */
function showAddTagForm(videoId) {
    $('#tagDescription').css('display', 'none');
    $('#addTagFormDiv').css('display', 'block');
}

/*******************************************************************************/
showAddTagForm('<?=$videoId;?>');
/*******************************************************************************/

/*
 * shows selected tag type and hides rest others
 * Requires all possible adtypes in "tagTypes" array
 */
function showHideTagTypes(tagType) {
    $.each(tagTypes, function(index, value) {
        if(tagType === value) {
            $('.' + tagType).css('display', 'block');
        } else {
            $('.' + value).css('display', 'none');
        }
    });
}

/*
 * Tests the url for valid image
 */
function testImageUrl(url) {
    $("<img>", {
        src: url,
        error: function() { inValidImage();},
        load: function() { formError = Array(false, ''); }
    });
    return true;
}

/*
 * Tests the url for valid image
 */
function inValidImage() {
    formError = Array(true, '*Link is not a valid image');
}

/*
 * Gets the video time and Converts it into hh:mm:ss format and fills into the field id
 */
function updateVideoTime(idName) {
    var currentTime;
    var hours = 0;
    var seconds = parseInt(ytVideo.currentTime() % 60, 10);
    var minutes = parseInt(ytVideo.currentTime() / 60, 10);
    if(minutes > 60) {
        hours =  parseInt(minutes / 60, 10);
        minutes = parseInt(minutes % 60, 10)
    }
    currentTime = hours + ':' + minutes + ':' + seconds;
    
    // show hh:mm:ss in disabled form 
    $('#' + idName).val(currentTime);
    //  show seconds in the hidden form 
    $('[name=' + idName + ']').val(ytVideo.currentTime());
}

/*
 * Validates the new tag info before adding into DB
 */
function validateTagInfo() {
    var formError = Array(false, '');
    var tagStartTime =  $('[name=tagStartTime]').val();
    var tagEndTime = $('[name=tagEndTime]').val();
    var tagType = radioVal('tagType');
    if(tagStartTime <= tagEndTime) {
        switch(tagType) {
            case 'image':
                var imageSrc = radioVal('imageSrc');
                switch(imageSrc) {
                    case 'webLink':
                        var imageUrl = $('[name=imageUrl]').val();
                        if(imageUrl === ''  || typeof imageUrl === 'undefined' || imageUrl == null) {
                            formError = Array(true, '*Please provide image Url');
                        }else {
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////////////////////////////////////testImageUrl(imageUrl);/////////////////////////////////////////////
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                            ////////////////////////////////////////////////////////////////////////////////////////////////////////
                        }
                        break;
                    case 'upload':
                        imagePath = $('[name=imageUpload]').val();
                        if(imagePath === ''  || typeof imagePath === 'undefined' || imagePath == null) {
                            formError = Array(true, '*Please choose Image to upload');
                        }
                        break;
                    default:
                        formError['0'] = false;
                        formError['1'] = 'Please make Image source selection';
                        break;
                }
                break
            default:
                formError[0] = true;
                formError[1] = "*Please select a Tag Type";
                break;
        }
    }else {
        formError[0] = true;
        formError[1] = "*End Time cannot be greater than Start Time."
    }
    
    //  Display Error Message
    if(formError[0] === true) {
        $('#addTagFormError').html(formError[1]);
        return false;
    }else {
        $('#addTagFormError').html(formError[1]);
        return false;
        // $('#addTagFormError').html('');
        // return true;
    }
}
//makes a favorite a favorite
function make_favorite() {
		var user = "<?php echo $_SESSION['vtpUserId'];?>";
		var video = "<?php echo $videoId;?>";
		$('#favLink').html("Currently in Favorites");
		var query = "r="+video;
		$.post("MakeFav.php",query);
}
</script>