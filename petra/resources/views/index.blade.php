@extends('layouts.app')

@section('content')

    <div class="index_logo">
      <p class="index fa fa-paw" aria-hidden="true"></p>
      <p class="index_title">Petra</p>
    </div>

    <div class="index_links">
      <a class="btn btn-default" href="{{ url('/map') }}">Mapa</a>
        @if (Auth::check())
            <a class="btn btn-default" href="{{ url('/home') }}">Home</a>
        @else
            <a class="btn btn-default" href="{{ url('/login') }}">Accedir</a>
            <a class="btn btn-default" href="{{ url('/register') }}">Registrar-se</a>
        @endif
    </div>

@endsection
