<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.png" type="image/png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile_view.css') }}" rel="stylesheet">
    <link href="{{ asset('css/editprofile_view.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home_view.css') }}" rel="stylesheet">
    <link href="{{ asset('css/point_view.css') }}" rel="stylesheet"> 


    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                      <div class="logo">
                        <i class="fa fa-paw" aria-hidden="true"></i>
                        <p class="title">{{ config('app.name', 'Laravel') }}</p>
                      </div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                        <li><a href="{{ url('/map') }}"><i class="fa fa-map-marker fa-1x" aria-hidden="true"></i> Map</a></li>
                        <li><a href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                  <img src="/images/avatars/{{Auth::user()->avatar}}" class="navbar_avatarimg" alt="navbar_avatarimg"/> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                  <li><a href="{{ url('/profile/'.Auth::user()->id) }}">El meu perfil</a></li>
                                  <li><a href="{{ url('/editprofile') }}">Editar perfil</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Sortir
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
      $('body').on('mouseover', '[editprofile-data-editable]', function(){
        var $el = $(this);
        if ($el.hasClass('editprofile_description')) {
          var $input = $('<textarea class="form-control"/>').val( $el.text() );
        } else {
          var $input = $('<input class="form-control"/>').val( $el.text() );
        }
        $el.replaceWith( $input );
        var save = function(){
          if ($el.hasClass('editprofile_description')) {
            var $p = $('<p editprofile-data-editable class="editprofile_description"/>').text( $input.val() );
          } else {
            var $p = $('<p editprofile-data-editable />').text( $input.val() );
          }
          $input.replaceWith( $p );
        };
        $input.one('blur', save).focus();
      });
    </script>
    <script>
      for (i = 0; i < document.getElementsByClassName('profile_post_photo').length; i++) {
        var modal = document.getElementsByClassName('profile_modal')[i];
        var img = document.getElementsByClassName('profile_post_photo')[i];
        var modalImg = document.getElementsByClassName("profile_modal-content")[i];
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
        }
        var span = document.getElementsByClassName("profile_close")[i];
        span.onclick = function() {
            modal.style.display = "none";
        }
      }
    </script>
</body>
</html>
