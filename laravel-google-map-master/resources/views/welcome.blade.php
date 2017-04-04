<?php 
    if(isset($marks)){
        $markers = json_decode($marks);
    } else {
        $markers = "";
    }
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
            #map {
                height: 400px;
                width: 100%;
            }

        </style>
    </head>
    <body>
        <h3>Google Maps</h3>
        <div id="map"></div>
        <input type="button" id="show_markers" value = "Show Markers">
        <input type="button" id="show_clusters" value = "Show Clusters">
        <script>
        var markers = [];
        var markerCluster = "";
        var map;
          var obj = <?php echo json_encode($markers); ?>;
          function initMap() {
            var lat = obj[0].latitude;
            var lng = obj[0].longitude;
            var center = {lat, lng};
            map = new google.maps.Map(document.getElementById('map'), {
              zoom: 4,
              center: center
            });
          }
          $(document).ready(function(){
            $('#show_markers').click(function(){
                if(markers == ""){
                    for (var i = obj.length - 1; i >= 0; i--) {
                        var marker = new google.maps.Marker({
                          position: new google.maps.LatLng(obj[i].latitude, obj[i].longitude),
                          map: map
                        });
                        markers.push(marker);
                    }
                } else {
                    for (var i = 0; i < markers.length; i++ ) {
                        markers[i].setMap(null);
                      }
                      markers.length = 0;
                }
                if(markerCluster != ""){
                    markerCluster.clearMarkers();
                }
                google.maps.event.trigger(map, 'resize');
            }); 
            $('#show_clusters').click(function(){
                if(markerCluster == ""){
                    markerCluster = new MarkerClusterer(map, markers,{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                } else {
                    markerCluster.clearMarkers();
                    markers.length = 0;
                    markerCluster = "";
                }
            }); 
          });
        </script>
        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkeh-HTvbDgIvMie9xcljtxTJiVgxp3II&callback=initMap">
        </script>
        
        </script>
    </body>
</html>
