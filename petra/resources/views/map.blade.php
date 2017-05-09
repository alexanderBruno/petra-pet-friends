@extends('layouts.mapapp')

@section('content')

    <div id="map_map"></div>

    <script>
        var map;
        //https://developers.google.com/maps/documentation/javascript/examples/map-geolocation?hl=es-419
        function initMap() {
            map = new google.maps.Map(document.getElementById('map_map'), {
                zoom: 15,
                center: new google.maps.LatLng(41.394,2.167),

            });



            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
            });
            }


          // Create a <script> tag and set the USGS URL as the source.
        var script = document.createElement('script');
          // This example uses a local copy of the GeoJSON stored at
          // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
        document.getElementsByTagName('head')[0].appendChild(script);
        }

        // Loop through the results array and place a marker for each
        // set of coordinates.
        window.eqfeed_callback = function(results) {
          for (var i = 0; i < results.features.length; i++) {
            var coords = results.features[i].geometry.coordinates;
            var latLng = new google.maps.LatLng(coords[1],coords[0]);
            var marker = new google.maps.Marker({
              position: latLng,
              map: map
            });

            var contentString = '<div id="content">'+'<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
            '<div id="bodyContent">'+
            'Contingut de prova = '+String(i)
            '</div>'+
            '</div>';

            afegirFinestra(marker, contentString);
          }
          function afegirFinestra(marker, contingutFinestra) {
            var infowindow = new google.maps.InfoWindow({
              content: contingutFinestra
            });

            marker.addListener('click', function() {
              infowindow.open(marker.get('map_map'), marker);
            });
          }
        }



      </script>

      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDlGndNUTLX0ZKoCcBq-YyvrhS7YQjyX8&callback=initMap">
      </script>

@endsection