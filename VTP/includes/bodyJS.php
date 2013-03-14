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

    //  Enter test Mode
    //  videoTestMode();
}
?>

<script type="text/javascript">
var tagTypes = Array("commentTr", "imageTr", "mapTr", "linkTr");
var formError = new Array(false, '');
var isImgUrlTested = false;

$(document).ready(function() {
    imageSrcChange('webLink');
});

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

/*
 * shows selected tag type and hides rest others
 * Requires all possible adtypes in "tagTypes" array
 */
function showHideTagTypes(tagType) {
    $('#previewImgUrl').hide();
    $('#addTagFormError').html('');
    formError = Array(false, '');
    $('#saveAddTagForm').attr('disabled', false);
    
    $.each(tagTypes, function(index, value) {
        if(tagType === value) {
            $('.' + tagType).css('display', 'block');
        } else {
            $('.' + value).css('display', 'none');
        }
    });
    
    // resize maps
    if(tagType === 'mapTr')
        google.maps.event.trigger(map, 'resize');
    else if(tagType === 'imageTr')
        imageSrcChange('webLink');
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
    var tagStartTime =  parseInt($('[name=tagStartTime]').val());
    var tagEndTime = parseInt($('[name=tagEndTime]').val());
    var tagType = radioVal('tagType');
    
    if(tagStartTime < tagEndTime) {
        switch(tagType) {
            case 'comment':
                var comment = $('[name=comment]').val();
                if(comment === ''  || typeof comment === 'undefined' || comment == null) {
                    formError = Array(true, '*Please enter your comment');
                }
                break;
            case 'image':
                var imageSrc = radioVal('imageSrc');
                switch(imageSrc) {
                    case 'webLink':
                        var imageUrl = $('[name=imageUrl]').val();
                        if(imageUrl === ''  || typeof imageUrl === 'undefined' || imageUrl == null) {
                            formError = Array(true, '*Please provide image Url');
                        }else {
                            // do nothing 
                            //      image url validation should be done from imageSrcChange()
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
                break;
            case 'map':
                var markerTitle = $('[name=markerTitle]').val();
                if(markerTitle === ''  || typeof markerTitle === 'undefined' || markerTitle == null) {
                    formError = Array(true, '*Please provide title for marker');
                }
                // update form data
                $("[name=lng]").val(mapMarker['position']['Ya']);
                $("[name=lat]").val(mapMarker['position']['Za']);
                break;
            case 'link':
                break;
            default:
                formError[0] = true;
                formError[1] = "*Please select a Tag Type";
                break;
        }
    }else if(tagStartTime == tagEndTime) {
        formError[0] = true;
        formError[1] = "*End Time cannot be equal to Start Time.";
    }else{
        formError[0] = true;
        formError[1] = "*End Time cannot be greater than Start Time.";
    }
    
    //  Display Error Message
    if(formError[0] === true) {
        $('#addTagFormError').html(formError[1]);
        formError = Array(false, '');
        return false;
    }else {
        $('#addTagFormError').html('');
        formError = Array(false, '');
        return true;
    }
}

//makes a favorite a favorite
function make_favorite() {
    var user = "<?php echo $_SESSION['vtpUserId'];?>";
    var video = "<?php echo $videoId;?>";
    //$('#favLink').html("Currently in Favorites");
    $('#favLink').slideUp();
    var query = "r=" + video;
    $.post("MakeFav.php", query, function(theResponse){
        console.log(theResponse);
    });
}

/*
 * Called when Image Tag source is changed
 */
function imageSrcChange(src) {
    if(src === 'webLink') {
        $('#imgSrcUpload').hide(); 
        $('#imgSrcLink').show();        
        $('#previewImgUrl').show();
        $('#saveAddTagForm').attr('disabled', true);
    }else if(src === 'upload') {
        $('#imgSrcLink').hide();
        $('#imgSrcUpload').show();
        $('#previewImgUrl').hide();
        $('#saveAddTagForm').attr('disabled', false);
        $('#imgPreview').css('display', 'none');
        formError = Array(false, '');
        $('#addTagFormError').html(formError[1]);
    }
}

/*
 * Loads the image link for preview
 * Link is received form 'imageUrl' field
 */
function previewImgLink() {
    var imageUrl = $('[name=imageUrl]').val();
    $('#imgPreview').attr('src', imageUrl).css('display', 'block');
    $('#saveAddTagForm').val('Save').attr('onClick', 'submitAddTagForm();');
}

/*
 * called when the preview image link is good
 */
function validImageUrl() {
    formError = Array(false, '');
    $('#saveAddTagForm').attr('disabled', false);
    $('#addTagFormError').html(formError[1]);
}

/*
 * called when the preview image link is bad
 */
function invalidImageUrl() {
    formError = Array(true, '*Link is not a valid image');
    $('#saveAddTagForm').attr('disabled', true);
    $('#addTagFormError').html(formError[1]);
}

$(function() {
    $( "#tagDescription" ).draggable().resizable();
  });

</script>