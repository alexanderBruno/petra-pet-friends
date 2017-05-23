@extends('layouts.mapapp')

@section('content')
    <!-- Resultat Afegir Marcador-->
    @if(session('mesage')=='notLoged')
      <p>Has d'accedir per poder afegir llocs. Puto desactivador de Javascripts!</p>
    @elseif(session('confirmation')=='faltaInfo')
      <p>Falta informació bàsica del lloc. No es pot afegir.</p>
    @endif
    <!-- Menu per mostrar punts-->
    <div class="map panel panel-info">
      <div class="map panel-heading">Què vols buscar?</div>
      <div class="map panel-body">
        <ul class="map nav navbar-nav">
          <li><a class="map a" href="/map"><i class="glyphicon glyphicon-home"></i></a></li>
          <li><a class="map a" href="/map/vet"><i class="glyphicon glyphicon-adjust"></i></a></li>
          <li><a class="map a" href="/map/park"><i class="glyphicon glyphicon-bell"></i></a></li>
          <li><a class="map a" href="#"><i class="glyphicon glyphicon-user"></i></a></li>
          <li><a class="map a" href="#"><i class="glyphicon glyphicon-cd"></i></a></li>
          <li><a class="map a" href="#"><i class="glyphicon glyphicon-picture"></i></a></li>
          <li><a class="map a" href="#"><i class="glyphicon glyphicon-leaf"></i></a></li>
          @if (!Auth::guest())
            <li><a class="map a" href="#"><i class="glyphicon glyphicon-flag"></i></a></li>
          @endif
        </ul>
      </div>
    </div>

    <!--Formulari per afegir marcadors-->
    <div class="modal fade" id="marker_modal_form" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title" id="myModalLabel">Afegir marcador</h4>
              </div>

              @if (Auth::guest())
                <div class="modal-body">
                  <p>No has accedit.</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('login') }}"><button type="button" class="btn btn-primary rosita"><i class="fa fa-sign-in" aria-hidden="true"></i> Accedir</button></a>
                    <a href="{{ route('register') }}"><button type="button" class="btn btn-primary rosita"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrar-se</button></a>
                </div>
              @else
                <div class="modal-body">
                  <p id="estat">Has de fer clic al mapa per col·locar el marcador.</p>

                <!-- Formulari -->
                <form id="marker_add_form" action="/map" method="POST" class="point_form amaga" enctype="multipart/form-data">
                  {!! csrf_field() !!}

                  <!--Nom-->
                  <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="point_name" class="form-control" placeholder="Nom del lloc">
                  </div>
                  <!--/Nom-->
                  <!--Descripcio-->
                  <div class="form-group">
                   <label>Descripció</label>
                   <textarea name="point_description" rows="3" class="form-control home_post" placeholder="Descripció"></textarea>
                  </div>
                  <!--/Descripcio-->
                  <!--Imatge-->
                  <label for="home_file-upload" class="home_custom-file-upload">
                      <i class="glyphicon glyphicon-camera"></i> Afegeix una foto del lloc!
                  </label>
                  <input id="home_file-upload" name="point_photo" type="file" class="file home_post_photo" placeholder="Nom del lloc">
                  <!--Imatge-->
                  <!--Serveis-->
                  <br>
                  <label>Serveis</label>
                  <div class="funkyradio">
                    @foreach ($services as $service)
                      <div class="funkyradio-primary junticos">
                          <input id="checkbox{{ $loop->iteration }}" type="checkbox" name="point_serveis" value="{{ $service->service_code }}"/>
                          <label for="checkbox{{ $loop->iteration }}">
                            <img src="/images/service_icons/{{ $service->icon }}" width="20px" height="20px">
                            {{ $service->name }}
                          </label>
                      </div>
                    @endforeach
                  </div>
                  <!--/Serveis-->

                  <!--Type Point-->
                  <div class="form-group">
                    <label>Tipus de marcador</label>
                    <select name="type_point" class="form-control">
                      <option value="NULL" selected>Escull un tipus de marcador</option>
                      @foreach ($markers as $marker)
                        <option value="{{ $marker->marker_code }}">{{ $marker->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <!--/Type Point-->

                  <!--Latitud i longitud-->
                    <input id="latitude" type="text" name="latitude" class="form-control amaga" hidden="hidden">
                    <input id="longitude" type="text" name="longitude" class="form-control amaga" hidden="hidden ">
                  <!--/Latitud i longitud-->

                <!-- Formulari -->

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <!--a href="#"><button type="button" class="btn btn-primary rosita">Enviar</button></a-->
                  <button id="boto_enviar" type="submit" name="submit" class="btn btn-primary home_submit rosita amaga"><i class="fa fa-map-marker fa-1x" aria-hidden="true"></i>&nbsp;&nbsp;Afegir marcador</button>

              </div>
              </form>

                @endif



          </div>
      </div>
    </div>


    <div id="map_map"></div>

    <script>
        var map;
        var infoWindow;
        var newMarker = null;

        // Crea el mapa i el event que tenca els infowindows
        function initMap() {
            map = new google.maps.Map(document.getElementById('map_map'), {
                zoom: 15,
                center: new google.maps.LatLng(41.394,2.167),
                fullscreenControl: true
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

            infoWindow = new google.maps.InfoWindow({maxWidth: 300});

            // Event que tenca la infowindow quan cliques el mapa
            google.maps.event.addListener(map, 'click', function() {
               infoWindow.close();
            });

            // Event que crida a la funció, d'afegir marcador
            map.addListener('click', function(event) {
              addMarker(event.latLng);
            });


            var centerControlDiv = document.createElement('div');
            var centerControl = new CenterControl(centerControlDiv, map);

            centerControlDiv.index = 1;
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);


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

         var id = points[i].id;
         var nom = points[i].name;
         //var descripcio = points[i].description;
         var imatge = points[i].avatar;
         var valoracio = points[i].score;
         var marca = points[i].flag;

         crearMarker(id, latlng, nom, imatge, valoracio, marca);

         // S'afegeixen lat i lng del marcador a bounds
         bounds.extend(latlng);

       }

       // Es defineixen els limits del mapa(Opcional)
       map.fitBounds(bounds);
    }//afegirMarkers()

    // Crea els marcadors, i afegeix el contingut del InfoWindow
    function crearMarker(id, latlng, nom, imatge, valoracio, marca){
      var opcions = {
         map: map,
         position: latlng,
         title: nom,
         animation: google.maps.Animation.DROP
      }
      if(marca != null){
        var opcions = {
           map: map,
           position: latlng,
           icon: '/images/markers/'+marca,
           title: nom,
           animation: google.maps.Animation.DROP
        }
      }
       var marker = new google.maps.Marker(opcions);


       // Quan es clica un marcador, es defineix el contingut de l'infowindow i s'obre
       google.maps.event.addListener(marker, 'click', function() {
         var pawStar = Math.round(valoracio);
         var estrellitas = '<div class="valoration">';
         for (var i = 1; i <= 5; i++) {
           if (i <= pawStar){
             estrellitas += '<label class="full patita_llena"></label>';
           }else{
             estrellitas += '<label class = "full"></label>';
           }
         }
         estrellitas += '</div>';

          // Contingut de l'infowindow
          var pointInfo = ''+
          '<div id="media">'+
            '<div class="media-left media-middle">'+
              '<img class="infoimg" src="/images/avatars/'+imatge+'" alt="Imatge_'+nom+'"/>'+
            '</div>'+
            '<div class="media-body">'+
              '<a class="lletra enlace" id="enlace" href="/point/'+id+'"><h4 class="media-heading nom">'+nom+'</h4></a>'+
              estrellitas+'<p id="nums" class="lletra">'+valoracio+'</p>'+
            '</div>'+
          '</div>';

          // Afegeix el contingut a l'InfoWindow
          infoWindow.setContent(pointInfo);

          // Obre l'InfoWindow en el mapa i marcador actual
          infoWindow.open(map, marker);
       });
    }

    function CenterControl(controlDiv, map) {

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.title = 'Click to recenter the map';
        controlUI.id = 'botoCentrat';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.id = 'textBotoCentrat';
        var botoText = '<a class="home_post_options enlace azulito" data-toggle="modal" href="#marker_modal_form"><i class="fa fa-plus"></i> Afegir marcador</a>';
        controlText.innerHTML = botoText;
        controlUI.appendChild(controlText);

        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener('click', function() {
          if (newMarker){
            document.getElementById("marker_add_form").classList.remove('amaga');
            document.getElementById("boto_enviar").classList.remove('amaga');
            var latText = newMarker.position.lat();
            var lngText = newMarker.position.lng();
            document.getElementById("latitude").value = latText.toFixed(6);
            document.getElementById("longitude").value = lngText.toFixed(6);
            /*var mesage = ''+//'Latitud: '+String(latText)+' Longitud: '+String(lngText)+
            ' LatitudTruncada: '+latText.toFixed(6)+' LongitudTruncada: '+lngText.toFixed(6);*/
            var estat = document.getElementById("estat");
            estat.parentNode.removeChild(estat);
            /*var form = document.getElementById('estat');
            form.innerHTML = mesage;*/

            //alert(mesage);
          }
        });

      }
    //location
    function addMarker(location) {
      //alert(location.lat);
      if (newMarker == null){
        newMarker = new google.maps.Marker({
          position: location,
          map: map,
          draggable:true,
          icon: '/images/markers/new_marker.png'
        });
      }

      }



      </script>

      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDlGndNUTLX0ZKoCcBq-YyvrhS7YQjyX8&callback=initMap">
      </script>

@endsection
