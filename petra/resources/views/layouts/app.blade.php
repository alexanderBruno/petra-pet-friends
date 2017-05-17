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
    <link href="{{ asset('css/paw_style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/editpost_view.css') }}" rel="stylesheet">
    <link href="{{ asset('css/messages_view.css') }}" rel="stylesheet">
    <link  href="{{ asset('css/editreview_view.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
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
                        @if (Auth::guest())
                          <li><a href="{{ url('/map') }}"><i class="fa fa-map-marker fa-1x" aria-hidden="true"></i> Mapa</a></li>
                        @else
                          <li><a href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i> Inici</a></li>
                          <li><a href="{{ url('/map') }}"><i class="fa fa-map-marker fa-1x" aria-hidden="true"></i> Mapa</a></li>
                          <li><a href="{{ url('/messages') }}"><i class="fa fa-comments" aria-hidden="true"></i> Missatges</a></li>
                          <li><a href="{{ url('/friends') }}"><i class="fa fa-users" aria-hidden="true"></i> Amistats</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Accedir</a></li>
                            <li><a href="{{ route('register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrar-se</a></li>
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



    </div>

    @yield('content')

</body>
</html>
