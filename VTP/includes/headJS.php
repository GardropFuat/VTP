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
var map;
var mapMarker;

$(document).ready(function() {
    // map options
    var mapOptions = {
        zoom: 3,
        center: new google.maps.LatLng(55.06780214639464, -124.47629916088863),
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

    //  create and link a marker to the map
    mapMarker = new google.maps.Marker({
        position: new google.maps.LatLng(44.07432896362102, -103.20676791088863),
        map: map,
        draggable: true,
        title: 'Set the Title'
    });

    google.maps.event.addListener(mapMarker, 'click', function() {
        map.setZoom(8);
        map.setCenter(mapMarker.getPosition());
    });
});

// on window resize set player height
$(window).resize(function() {
    $('#playerDiv').height('50%');
    $('#tagdescription').height('50%');
});

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
</script>