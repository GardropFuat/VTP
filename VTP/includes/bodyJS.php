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

$playerHeight = 340;
$playerWidth = 640;

// find the requsted
$requestedPage = explode('/', $_SERVER['SCRIPT_NAME']);
$requestedPage = end($requestedPage);

if( !empty( $_REQUEST['vimeoUrl'] ) && ($requestedPage == 'index.php') ) {
    $vimeoUrl = $_REQUEST['vimeoUrl'];
    $videoSource = 'vimeo';
    $videoId = getViemoVideoId($vimeoUrl);

    //  get video info from vimeo
    $videoData = simplexml_load_file("http://vimeo.com/api/v2/video/".$videoId.".xml");
    $videoTitle = $videoData->video->title;

    $videoLink = "http://player.vimeo.com/video/".$vimeoUrl;

    // set player height and width & update video Info
    echoScript("$('#playerFrame').height(".$playerHeight.").width(".$playerWidth.")");
    echoScript("$('#videoTitle').text('".$videoTitle."')");
    echoScript("$('[name=videoId]').attr('value', '".$videoId."')");
    echoScript("$('[name=videoSource]').attr('value', '".$videoSource."')");

        // Check if video is favorite
    $isFavorite = $Db->isFavorite($userId, $videoId);
    if( $userId && $isFavorite ) {
        echoScript('$("#favLink").html("Currently in favorites").attr("onClick", "")');
    }else {
        echoScript('$("#favLink").html("Add to Favorites").attr("onClick", "make_favorite()")');
   }

    // generate player and set actions
    $viemoContent = generateVimeoVideoScript($videoId, $_SESSION['tagFilter']);
    echoScript( $viemoContent );
    echoScript( "$('#container').css('display', 'block');" );
}else if( !empty( $_REQUEST['ytUrl'] ) && ($requestedPage == 'index.php') ) {
    $ytUrl = $_REQUEST['ytUrl'];
    $videoSource = 'youtube';

    $videoId = getYtVideoId($ytUrl);

    $link = "https://gdata.youtube.com/feeds/api/videos/".$videoId."?v=2";
    $xml = simplexml_load_file($link);
    $videoTitle = $xml->title;

    $videoLink = "https://www.youtube.com/v/".$videoId."?version=3&enablejsapi=1";

    // set player height and width & update video Info
    echoScript("$('#playerFrame').height(".$playerHeight.")");
    echoScript("$('#videoTitle').text('".$videoTitle."')");
    echoScript("$('[name=videoId]').attr('value', '".$videoId."')");
    echoScript("$('[name=videoSource]').attr('value', '".$videoSource."')");
    $isFavorite = $Db->isFavorite($userId, $videoId);
    if( $userId && $isFavorite ) {
        echoScript('$("#favLink").html("Currently in favorites").attr("onClick", "")');
    }else {
        echoScript('$("#favLink").html("Add to Favorites").attr("onClick", "make_favorite()")');
    }
    // generate player and set actions
    $ytContent = generateYTVideoScript($videoId, $_SESSION['tagFilter']);
    echoScript( $ytContent );
    echoScript( "$('#container').css('display', 'block');" );
} else {
    echoScript( "loadSearch = true;" );
}
?>

<script type="text/javascript">
var YOUTUBE_DEVELOPER_KEY = 'AI39si7zLxgtuhVYtL4GcpnoWpgtanI0Ye3G1FyOdyvrJmhS-n2X6KK7eJDYZS7n5nI9WM_7ny0ZzBhcztbrlia3DHIPOXEAdQ';
var tagTypes = Array("commentTr", "imageTr", "mapTr", "linkTr");
var formError = new Array(false, '');
var isImgUrlTested = false;
var isTagsHidden = false;

$(document).ready(function() {
    imageSrcChange('webLink');
    if(loadSearch)
    {
        processSearch();
    }

    $('[name=tagFilter]').change(function(e){
        switch($(this).val())
        {
            case 'none':
                isTagsHidden = true;
                window.location = '<?=curPageUrl();?>&t=0';
                // hideTags();
                break;
            case 'friends':
                isTagsHidden = false;
                window.location = '<?=curPageUrl();?>&t=1';
                break;
            case 'all':
                isTagsHidden = false;
                window.location = '<?=curPageUrl();?>&t=2';
                // showTags();
                break;
        }
    });
});

/*
 * Hides Add tag form and shows pictures
 */
function hideAddTagForm() {
    $('#addTagFormDiv').css('display', 'none');
    if(!isTagsHidden)
        showTags();
}

/*
 * Hides pictures and shows Add tag form
 */
function showAddTagForm(videoId) {
    if('<?=$_SESSION["vtpUserId"]?>' === '') {
        alert("Please login to add a tag.");
    }else {
        hideTags();
        $('#addTagFormDiv').css('display', 'block');
    }
}


function showTags() {
    $('#tagDescription').css('display', 'block');
    $('#map').css('display', 'block');
    $('#commentsDiv').css('display', 'block');
}

function hideTags() {
    $('#tagDescription').css('display', 'none');
    $('#map').css('display', 'none');
    $('#commentsDiv').css('display', 'none');
}


/*
 * shows selected tag type and hides rest others in Add tag Form
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
    var seconds = parseInt(video.currentTime() % 60, 10);
    var minutes = parseInt(video.currentTime() / 60, 10);
    if(minutes > 60) {
        hours =  parseInt(minutes / 60, 10);
        minutes = parseInt(minutes % 60, 10)
    }
    currentTime = hours + ':' + minutes + ':' + seconds;

    // show hh:mm:ss in disabled form
    $('#' + idName).val(currentTime);
    //  show seconds in the hidden form
    $('[name=' + idName + ']').val(video.currentTime());
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
                $("[name=lng]").val(mapMarker['position'].lng());
                $("[name=lat]").val(mapMarker['position'].lat());
                break;
            case 'link':
                var link = $('[name=webLink]').val();
                if(!validateURL(link)) {
                    formError[0] = true;
                    formError[1] = "*Please provide a valid Url.";
                }
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
        formError[1] = "*Start Time cannot be greater than End Time.";
    }

    //  Display Error Message
    if(formError[0] === true) {
        $('#addTagFormError').html(formError[1]+'<br/>');
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
    $.post("MakeFav.php", query);
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

function getVevoInfo(videoId) {
    $.getJSON( "http://youtube.com/get_video_info", "video_id="+ videoId +"&el=vevo", function(response){
        console.log(response);
    });
}

function validateURL(textval) {
    var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
    return urlregex.test(textval);
}

//adds the ability to move the individual div's on a page
//the key is to make them relative to the screen such that
//different screen sizes have similar orintations
$(function() {
    $( "#tagDescription" ).draggable({
        drag: function(){
            var offset = $(this).offset();
            var xPos = offset.left;
            var yPos = offset.top;
        },
        stop: function(){
            var finalOffset = $(this).offset();
            var finalxPos = finalOffset.left  - (screen.width/2);
            var finalyPos = finalOffset.top -169;
            var container_type = "tagContainer1"
            $.post("CapturePos.php", 'data=' + finalxPos+ '&data2=' + finalyPos +'&data3=' +container_type );
        }
    });
  });

$(function() {
    $( "#playerFrame" ).draggable({
        drag: function(){
            var offset = $(this).offset();
            var xPos = offset.left;
            var yPos = offset.top;
        },
        stop: function(){
            var finalOffset = $(this).offset();
            var finalxPos = finalOffset.left;
            var finalyPos = finalOffset.top -169;
            var container_type = "player"
            $.post("CapturePos.php", 'data=' + finalxPos+ '&data2=' + finalyPos +'&data3=' +container_type );
        }
    });
  });


$(function() {
    $( "#commentsTbl" ).draggable({
        drag: function(){
            var offset = $(this).offset();
            var xPos = offset.left;
            var yPos = offset.top;
        },
        stop: function(){
            var finalOffset = $(this).offset();
            var finalxPos = finalOffset.left;
            var finalyPos = finalOffset.top;
            var container_type = "comment"
            $.post("CapturePos.php", 'data=' + finalxPos+ '&data2=' + finalyPos +'&data3=' +container_type );
        }
    });
  });

$(function() {
    $( "#videoTitle" ).draggable({
        drag: function(){
            var offset = $(this).offset();
            var xPos = offset.left;
            var yPos = offset.top;
        },
        stop: function(){
            var finalOffset = $(this).offset();
            var finalxPos = finalOffset.left;
            var finalyPos = finalOffset.top;
            var container_type = "videoTitle"
            $.post("CapturePos.php", 'data=' + finalxPos+ '&data2=' + finalyPos +'&data3=' +container_type );


            //an attempt at making a cookie to hold the oriantation of the screen values
            /*function setCookie(cookieName, finalxPos+'_'+finalyPos, exp ){
                cookieName = "videoTitleCookie";
                cookieValue = finalxPos+'_'+finalyPos;
                var exp = new Date();
                exp.setTime(exp.getTime()+(1000 * 60 * 60 * 24));//this is one day before it expires
                document.cookie = cookieName+"="+escape(cookieValue) + ";expires="+expire.toGMTString();
            }*/

        }
    });
  });
</script>