<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index_view.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-default navbar-xs" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand"><b>Cerca directe</b> de punts d'interès</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="#"><i class="glyphicon glyphicon-adjust"></i></a></li>
          <li><a href="#"><i class="glyphicon glyphicon-bell"></i></a></li>
          <li><a href="#"><i class="glyphicon glyphicon-user"></i></a></li>
          <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
          <li><a href="#"><i class="glyphicon glyphicon-cd"></i></a></li>
          <li><a href="#"><i class="glyphicon glyphicon-flag"></i></a></li>
          <li><a href="#"><i class="glyphicon glyphicon-picture"></i></a></li>
          <li><a href="#"><i class="glyphicon glyphicon-leaf"></i></a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
      </nav>
    </div>

    <div class="logo">
      <p class="fa fa-paw" aria-hidden="true"></p>
      <p class="title">Petra</p>
    </div>

    <div class="links">
      <a class="btn btn-default" href="{{ url('/mapa') }}">Mapa</a>
        @if (Auth::check())
            <a class="btn btn-default" href="{{ url('/home') }}">Home</a>
        @else
            <a class="btn btn-default" href="{{ url('/login') }}">Accedir</a>
            <a class="btn btn-default" href="{{ url('/register') }}">Registrar-se</a>
        @endif
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
