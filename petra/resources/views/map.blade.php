@extends('layouts.mapapp')

@section('content')
    <!-- Modal informatiu-->
    @if (session('mesage') OR session('confirmation'))
      <div class="modal fade" id="information" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2 class="modal-title azulito"><i class="fa fa-info-circle" aria-hidden="true"></i> Informació</h2>
          </div>
          <div class="modal-body">

            @if(session('mesage')=='notLoged')
              <h3 class="error">Has d'accedir per poder afegir llocs. Senyor desactivador de Javascripts, així no!</h3>
            @elseif(session('mesage')=='faltaInfo')
              <h3 class="error">Falta informació bàsica. No es pot afegir el lloc.</h3>
            @elseif(session('mesage')=='addMarker')
              <h3 class="correcte">Lloc afegit correctament.</h3>
              <p><strong>Tan aviat com sigui possible, comprobarem la informació introduïda del lloc.</strong></p>
              <p><strong>En cas de que sigui correcte, el teu lloc estarà disponible públicament a la nostra web.</strong></p>
              <p>Ens guardem el dret d'eliminar/editar qüalsevol lloc afegit a aquest web.</p>
            @elseif(session('mesage')=='diferentID')
              <h3 class="error">No pots mirar els llocs que han afegit altres</h3>
            @elseif(session('mesage')=='noPoints')
              <h3 class="warning">Encara no tens cap lloc</h3>
              <p><strong>Encara no hi ha cap lloc teu aprovat per els nostres administradors.</strong></p>
              <p><strong>Però no et preocupis, si n'has afegit algun, segurament s'aprovara en les pròximes hores.</strong></p>
              <p><strong>Si no, pots afegir-ne amb el botó &nbsp;<a class="enlace azulito"><i class="fa fa-plus"></i> Afegir lloc</a> del mapa.</strong></p>
            @elseif(session('confirmation')=='pointnotpublic')
              <h3 class="error">Aquest lloc està ocult!</h3>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tancar</button>
          </div>
        </div>

      </div>
      </div>
    @endif
    <!--Error Ajax -->
    <div class="modal fade" id="information_ajax" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title azulito"><i class="fa fa-info-circle" aria-hidden="true"></i> Informació</h2>
        </div>
        <div class="modal-body">
            <h3 class="warning">No s'ha pogut afegir el lloc a favorits</h3>
            <p><strong>És molt provable que no hagis accedit al web.</strong></p>
            <p><strong>Si no és així, prova-ho més tard. O bé contacta'ns</strong></p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tancar</button>
          <a href="{{ route('login') }}"><button type="button" class="btn btn-primary rosita"><i class="fa fa-sign-in" aria-hidden="true"></i> Accedir</button></a>
          <a href="{{ route('register') }}"><button type="button" class="btn btn-primary rosita"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrar-se</button></a>
        </div>
      </div>

    </div>
    </div>

    <!-- Menu per mostrar punts-->
    <div class="map panel panel-info ancho">
      <div class="map panel-heading">Què vols buscar?</div>
      <div class="map panel-body">
        <!--ul class="map nav navbar-nav"-->
        <ul class="map nav navbar-nav">
          <li class="bien"><a class="map a augmentar ba_color_map" href="/map" title="Tots els llocs"><i class="fa fa-home" aria-hidden="true"></i></a></li>
          <li class="bien"><a class="map a augmentar ba_color_vet" href="/map/vet" title="Veterinaris"><i class="fa fa-heartbeat"></i></a></li>
          <li class="bien"><a class="map a augmentar ba_color_park" href="/map/park" title="Parcs"><i class="fa fa-futbol-o" aria-hidden="true"></i></a></li>
          <li class="bien"><a class="map a augmentar ba_color_pipican" href="/map/pipican" title="Pipicans"><i class="fa fa-tree" aria-hidden="true"></i></a></li>
          <li class="bien"><a class="map a augmentar_mes ba_color_hotel_can" href="/map/hotel_can" title="Hotels pet friendly"><i class="fa fa-h-square" aria-hidden="true"></i></a></li>
          <li class="bien"><a class="map a augmentar_mes ba_color_protectora" href="/map/protectora" title="Protectores"><i class="fa fa-shield" aria-hidden="true"></i></a></li>
          <li class="bien"><a class="map a augmentar ba_color_botiga" href="/map/botiga" title="Botiges"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
          <li class="bien"><a class="map a augmentar_mes ba_color_rest" href="/map/rest" title="Restaurants pet friendly"><i class="fa fa-cutlery" aria-hidden="true"></i></a></li>

          @if (!Auth::guest())
            <li class="bien"><a class="map a augmentar ba_color_meus" href="/map/meus/{{ Auth::id() }}" title="Els meus llocs"><i class="fa fa-flag" aria-hidden="true"></i></a></li>
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
                  <h4 class="modal-title">Afegir lloc</h4>
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

                  <!--div class="columna"-->
                  <div class="funkyradio">
                    @foreach ($services as $service)
                      <div class="funkyradio-primary junticos">
                          <input id="checkbox{{ $loop->iteration }}" type="checkbox" name="point_serveis{{ $loop->iteration }}" value="{{ $service->service_code }}"/>
                          <label for="checkbox{{ $loop->iteration }}">
                            <i class="fa {{ $service->icon }} form_icon" aria-hidden="true"></i>&nbsp; {{ $service->name }}
                          </label>
                      </div>
                    @endforeach
                  </div>
                  <!--/Serveis-->

                  <!--Type Point-->
                  <div class="form-group">
                    <label>Tipus de lloc</label>
                    <select name="type_point" class="form-control">
                      <option value="NULL" selected>Escull un tipus de lloc</option>
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
                  <button id="boto_enviar" type="submit" name="submit" class="btn btn-primary home_submit rosita amaga"><i class="fa fa-map-marker fa-1x" aria-hidden="true"></i>&nbsp;&nbsp;Afegir lloc</button>

              </div>
              </form>

                @endif



          </div>
      </div>
    </div>


    <div id="map_map"></div>

    <script>
    $(window).on('load',function(){
        $('#information').modal('show');
        //$("#").modal();
    });

        var map;
        var infoWindow;
        var newMarker = null;

        // Crea el mapa i el event que tenca els infowindows
        function initMap() {
            map = new google.maps.Map(document.getElementById('map_map'), {
                zoom: 15,
                center: new google.maps.LatLng(41.384466,2.189278),
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
                map.setZoom(15);
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
         icon: '/images/markers/red_marker.png',
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

         //Codi Favorits
         var faved = false;

         for (var i = 0; i < favsdone.length; i++) {
           if (id == favsdone[i].id_point){
             faved = true;
             break;
           }
         }
         if (faved == true){
            var point_fav_or_faved = '<i id="map_faved_'+id+'" class="fa fa-heart map_faved ves" onclick="faved('+id+')" aria-hidden="true"></i>';
         }else{
           var point_fav_or_faved = '<i id="map_fav_'+id+'" class="fa fa-heart map_fav ves" onclick="fav('+id+')" aria-hidden="true"></i>';
         }

         var latDest = latlng.lat();
         var lngDest = latlng.lng();

          // Contingut de l'infowindow
          var pointInfo = ''+
          '<div id="media">'+
            '<div class="media-left media-middle">'+
              '<img class="infoimg" src="/images/avatars/points/'+imatge+'" alt="Imatge_'+nom+'"/>'+
            '</div>'+
            '<div class="media-body">'+
              '<a class="lletra enlace" id="enlace" href="/point/'+id+'"><h4 class="media-heading nom">'+nom+'</h4></a>'+
              estrellitas+'<p id="nums" class="lletra">'+valoracio+'</p><br>'+
              '<div class="ves">'+
              '<a class="lletra enlace ves" href="https://www.google.es/maps/dir//'+latDest+','+lngDest+'/@'+',15z"><h6>Ves-hi</h6></a>'+
              point_fav_or_faved+
              '</div>'
            '</div>'+
          '</div>';

          // Afegeix el contingut a l'InfoWindow
          infoWindow.setContent(pointInfo);

          // Obre l'InfoWindow en el mapa i marcador actual
          infoWindow.open(map, marker);
       });
    }

    // Crea el boto per poder afegir marcadors
    function CenterControl(controlDiv, map) {

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.title = 'Fes clic per afegir un lloc';
        controlUI.id = 'botoCentrat';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.id = 'textBotoCentrat';
        var botoText = '<a class="home_post_options enlace azulito" data-toggle="modal" href="#marker_modal_form"><i class="fa fa-plus"></i> Afegir lloc</a>';
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
      }else{
        newMarker.setPosition(location);
      }

      }


      function fav(id) {
        var heart = $("#map_fav_"+id);
        if (heart.hasClass('map_fav')) {
          $.ajax({
                type: 'GET',
                url: '/map/favpoint/'+id,
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_fav').addClass('map_faved');
                },
                error: function(data){
                    console.log('error', data);
                    //alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                    $('#information_ajax').modal('show');
                }
                });
        } else {
          $.ajax({
                type: 'GET',
                url: '/map/dropfavpoint/'+id,
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_faved').addClass('map_fav');
                },
                error: function(data){
                    console.log('error', data);
                    //alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                    $('#information_ajax').modal('show');
                }
                });
        }

      };


      function faved(id) {
        var heart = $("#map_faved_"+id);
        if (heart.hasClass('map_fav')) {
          $.ajax({
                type: 'GET',
                url: '/map/favpoint/'+id,
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_fav').addClass('map_faved');
                },
                error: function(data){
                    console.log('error', data);
                    //alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                    $('#information_ajax').modal('show');
                }
                });
        } else {          
          $.ajax({
                type: 'GET',
                url: '/map/dropfavpoint/'+id,
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_faved').addClass('map_fav');
                },
                error: function(data){
                    console.log('error', data);
                    //alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                    $('#information_ajax').modal('show');
                }
                });
        }

      };


      </script>

      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDlGndNUTLX0ZKoCcBq-YyvrhS7YQjyX8&callback=initMap">
      </script>

@endsection
