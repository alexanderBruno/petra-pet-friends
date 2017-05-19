<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.png" type="image/png">

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
    <div class="logo">
      <p class="fa fa-paw" aria-hidden="true"></p>
      <p class="title">Petra</p>
    </div>

    <div class="links">
      <a class="btn btn-default" href="{{ url('/map') }}">Mapa</a>
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
