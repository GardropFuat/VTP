<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 300px; width:300px; }
    </style>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlbflcsqSg7b3-Nq-Ggo_4PVzo-MC4Y7s&sensor=true"></script>
    <script type="text/javascript">
        //Ref:    https://developers.google.com/maps/documentation/javascript/tutorial
        var markerLat;
        var markerLng;

        function initialize() {
            var mapOptions = {
                zoom: 3,
                center: new google.maps.LatLng(44.07432896362102, -103.20676791088863),
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

            //  create and link a marker to the map
            var marker = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                draggable: true,
                title: 'Set the Title Set the Title Set the Title Set the Title Set the Title Set the Title Set the Title Set the Title Set the Title Set the Title '
            });

            //  zoom in when marker is clicked
            google.maps.event.addListener(marker, 'click', function() {
                map.setZoom(8);
                map.setCenter(marker.getPosition());
            });

            //copy marker location into global variables
            google.maps.event.addListener(marker, 'drag', function() {
                markerLat = marker['position']['Ya'];
                markerLng = marker['position']['Za'];
            });
            console.log(marker.getPosition());
        }
    </script>
  </head>
  <body onload="initialize()">
    <div id="map_canvas" class="map"></div>
  </body>
</html>