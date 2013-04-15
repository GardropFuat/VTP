<?php
/*
 *
 * File Name:           headJS.php
 * Description:         Contains JS code to include in <head>
 * Author:
 * Created:             10/25/2012
 * Last Modified:       Anudeep 10/25/12
 * Copyright:           Echostar Systems @ http://www.echostar.com/
 */
?>


<script type="text/javascript">
// increase the default animation speed to exaggerate the effect
$.fx.speeds._default = 500;
var googleMap;
var tagMap;
var markersArray = [];
var markersShown = 0;
var content = [];
var map;
var mapMarker;
var loadSearch = false;


// on window resize set player height
$(window).resize(function() {
    $('#playerDiv').height('50%');
    $('#tagdescription').height('50%');
});

// shows markers on Google Maps
function showMarker(index, markerTitle, markerLat, markerLng) {
    if(typeof googleMap !== 'undefined' || typeof tagMap !== 'undefined'){
        markersArray[index] = new googleMap.maps.Marker({
            position: new googleMap.maps.LatLng(markerLat, markerLng),
            map: tagMap,
            draggable: true,
            title: markerTitle
        });
        tagMap.setCenter(markersArray[index].getPosition(), 11);
        googleMap.maps.event.addListener(markersArray[index], 'click', function() {
            tagMap.setZoom(8);
            tagMap.setCenter(markersArray[index].getPosition());
        });
        $('#actualMap').show();
        markersShown++;
    }else {
        setTimeout(function(){
                    showMarker(index, markerTitle, markerLat, markerLng);
                },250);
    }
}

// Hides Markers on Google Maps
function hideMarker(index) {
    if(typeof googleMap !== 'undefined'){
        markersArray[index].setMap(null);
        markersShown--;
        if(markersShown <= 0) {
            markersShown = 0; 
            $('#actualMap').hide();
        }
    }else {
        setTimeout(function(){
                    hideMarker(index);
                },250);
    }
}


// initialize Google Map for Addtag form this is called from head_std.php
// this is for tags
function initializeTagMap()
{
    // map options
    var mapOptions = {
        zoom: 3,
        center: new googleMap.maps.LatLng(41.42889198568996, -101.09739291088863),
        streetViewControl: false,
        mapTypeId: googleMap.maps.MapTypeId.ROADMAP
    };

    tagMap = new googleMap.maps.Map(document.getElementById('actualMap'), mapOptions);
    $('#actualMap').width(300).height(300);
}

// initialize Google Map for Addtag form this is called from head_std.php
// this is for add tag form.
function initializeMap(localGoogle)
{
    googleMap = localGoogle;
    // map options
    var mapOptions = {
        zoom: 3,
        center: new localGoogle.maps.LatLng(55.06780214639464, -124.47629916088863),
        streetViewControl: false,
        mapTypeId: localGoogle.maps.MapTypeId.ROADMAP
    };

    map = new localGoogle.maps.Map(document.getElementById('map_canvas'), mapOptions);

    //  create and link a marker to the map
    mapMarker = new localGoogle.maps.Marker({
        position: new localGoogle.maps.LatLng(44.07432896362102, -103.20676791088863),
        map: map,
        draggable: true,
        title: ''
    });

    localGoogle.maps.event.addListener(mapMarker, 'click', function() {
        map.setZoom(8);
        map.setCenter(mapMarker.getPosition());
    });
}


/*
 * Get the selected value of the radio field
 * @param name: name of the radio field
 */
function radioVal(name) {
    var selectedVal = '';
    var selected = $("input[type='radio'][name='" + name + "']:checked");
    if (selected.length > 0)
        selectedVal = selected.val();
    return selectedVal;
}

function showComment(id, comment, name) {
    comment = '<div id="comment-'+ id +'" class="comment">'+ comment +' - <span style="color:blue;">'+ name +'</span></div>';
    $("#commentsTbl").prepend(comment);
}

function hideComment(id) {
    $('#comment-'+ id ).remove();
}

</script>