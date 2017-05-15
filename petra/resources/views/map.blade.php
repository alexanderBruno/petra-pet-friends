@extends('layouts.mapapp')

@section('content')

    <div id="map_map"></div>

    <script>
        var map;
        var infoWindow;

        // Crea el mapa i el event que tenca els infowindows
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

            infoWindow = new google.maps.InfoWindow();

            // Event que tenca la infowindow quan cliques el mapa
            google.maps.event.addListener(map, 'click', function() {
               infoWindow.close();
            });

            // Crida afegirMarkers(), que afegeix els marcadors
            afegirMarkers();

    }//initMap()


    function afegirMarkers(){

       // Defineix el límit del mapa que es mostra a partir dels marcadors
       var bounds = new google.maps.LatLngBounds();

       // Recorre l'array i crida a crearMarker per cada marcador
       for (var i = 0; i < points.length; i++) {
         //var latitud = points[i].latitude;
         //var longitud = points[i].longitude;
         var latlng = new google.maps.LatLng(points[i].latitude, points[i].longitude);

         var nom = points[i].name;
         var descripcio = points[i].description;
         var imatge = points[i].avatar;
         var valoracio = points[i].score;

         crearMarker(latlng, nom, descripcio, imatge, valoracio);

         // S'afegeixen lat i lng del marcador a bounds
         bounds.extend(latlng);

       }

       // Es defineixen els limits del mapa(Opcional)
       //map.fitBounds(bounds);
    }//afegirMarkers()

    // Crea els marcadors, i afegeix el contingut del InfoWindow
    function crearMarker(latlng, nom, descripcio, imatge, valoracio){
       var marker = new google.maps.Marker({
          map: map,
          position: latlng,
          // icon: default,
          title: nom
       });


       // Quan es clica un marcador, es defineix el contingut de l'infowindow i s'obre
       google.maps.event.addListener(marker, 'click', function() {

          // Contingut de l'infowindow
          var pointInfo = '<div id="content">'+'<div id="siteNotice">'+'</div>'+
          '<h3>'+nom+'</h3>'+
          //'<h3 id="firstHeading" class="firstHeading">'+nom+'</h3>'+
          '<img class="info_img" src="/images/avatars/'+imatge+'" alt="Imatge_'+nom+'"/>'+
          '<div id="bodyContent">'+'<p>'+descripcio+'</p>'+
          '<p>Valoració:'+valoracio+'</p>'
          '</div>'+
          '</div>';

          // Afegeix el contingut a l'InfoWindow
          infoWindow.setContent(pointInfo);

          // Obre l'InfoWindow en el mapa i marcador actual
          infoWindow.open(map, marker);
       });
    }

      </script>

      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDlGndNUTLX0ZKoCcBq-YyvrhS7YQjyX8&callback=initMap">
      </script>

@endsection
