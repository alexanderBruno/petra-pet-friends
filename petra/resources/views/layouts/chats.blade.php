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
    <link rel="stylesheet" href="{{asset('chat/css/reset.css')}}">
    <link rel="stylesheet" href="{{asset('chat/css/style.css')}}">


    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

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

  <div class="container_chat clearfix body_chat">
   @include('partials.peoplelist')

    <div class="chat">
      <div class="chat-header clearfix">
        @if(isset($user))
            <img src="/images/avatars/{{$user->avatar}}" alt="avatar" class="chat_avatarimg" />
        @endif
        <div class="chat-about">
            @if(isset($user))
                <div class="chat-with">{{'Conversa amb ' . @$user->name}}</div>
            @else
                <div class="chat-with">No Thread Selected</div>
            @endif
        </div>
        <i class="fa fa-star"></i>
      </div> <!-- end chat-header -->

      @yield('content')

      <div class="chat-message clearfix">
      <form action="" method="post" id="talkSendMessage">
            <textarea name="message-data" id="message-data" placeholder ="Escriu el teu missatge..." rows="2"></textarea>
            <input type="hidden" name="_id" value="{{@request()->route('id')}}">
            <button type="submit">Enviar</button>
      </form>

      </div> <!-- end chat-message -->

    </div> <!-- end chat -->

  </div> <!-- end container -->


      <script>
          var __baseUrl = "{{url('/')}}"
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js'></script>



        <script src="{{asset('chat/js/talk.js')}}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript">
        var show = function(data) {
            alert(data.sender.name + " - '" + data.message + "'");
        }

        var msgshow = function(data) {
            var html = '<li id="message-' + data.id + '">' +
            '<div class="message-data">' +
            '<span class="message-data-name"> <a href="#" class="talkDeleteMessage" data-message-id="' + data.id + '" title="Delete Messag"><i class="fa fa-close" style="margin-right: 3px;"></i></a>' + data.sender.name + '</span>' +
            '<span class="message-data-time">1 Second ago</span>' +
            '</div>' +
            '<div class="message my-message">' +
            data.message +
            '</div>' +
            '</li>';

            $('#talkMessages').append(html);
        }

        $('#message-data').keypress(function (e) {
          if (e.which == 13) {
            $('form#talkSendMessage').submit();
          }
        });

        $(document).ready(function(){
          $(".chat-history").scrollTop($('.chat-history')[0].scrollHeight);
        //   $("#talkSendMessage").submit(function(e) {
        //     $(".chat-history").scrollTop($('.chat-history')[0].scrollHeight);
        //   });
        });


    </script>
    {!! talk_live(['user'=>["id"=>Auth::id(), 'callback'=>['msgshow']]]) !!}

  </body>
</html>
