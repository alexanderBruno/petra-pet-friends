@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Missatges</h4></div>

                <div class="messages panel-body">
                  @if(session('confirmation')=='usernotfound')
                    <p class="messages_confirmation_false">Aquest id no està associat ara mateix a cap usuari.</p>
                  @elseif(session('confirmation')=='sameuser')
                    <p class="messages_confirmation_false">Aquest id es el teu! Parla amb altres usuaris!</p>
                  @endif
                  <a href="{{route('message.read', ['id'=>0])}}" class="btn btn-primary btn-group btn-group-justified messages_big_buttonmessage"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;Obrir missatges</a>

                  <ul class="nav nav-tabs messages_tabs">
                    <li class="active"><a data-toggle="tab" href="#lma">Les meves amistats</a></li>
                    <li><a data-toggle="tab" href="#teu">Tots els usuaris</a></li>
                  </ul>

                  <div class="messages tab-content">
                    <div id="lma" class="messages tab-pane fade in active">
                      @if(count($yourfriends)==0)
                        <p class="friends_confirmation_info">Encara no tens cap amistat, anima't a fer alguna!</p>
                      @else
                        @foreach($yourfriends as $yourfriend)
                          @if($yourfriend->id!=Auth::id())
                              <table class="messages table">
                                  <tr>
                                      <td>
                                          <img src="/images/avatars/{{$yourfriend->avatar}}" class="messages_avatarimg" alt="avatarimg"/>
                                          <a class="messages_username" href="{{ url('/profile/'.$yourfriend->id) }}">{{$yourfriend->name}}</a>
                                      </td>
                                      <td>
                                          <a href="{{route('message.read', ['id'=>$yourfriend->id])}}" class="btn btn-primary pull-right messages_buttonmessage"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;Enviar missatge</a>
                                      </td>
                                  </tr>
                              </table>
                              <hr class="messages_hr">
                          @endif
                        @endforeach
                      @endif
                    </div>
                    <div id="teu" class="messages tab-pane fade">
                      @foreach($users as $user)
                        @if($user->id!=Auth::id())
                            <table class="messages table">
                                <tr>
                                    <td>
                                        <img src="/images/avatars/{{$user->avatar}}" class="messages_avatarimg" alt="avatarimg"/>
                                        <a class="messages_username" href="{{ url('/profile/'.$user->id) }}">{{$user->name}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('message.read', ['id'=>$user->id])}}" class="btn btn-primary pull-right messages_buttonmessage"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;Enviar missatge</a>
                                    </td>
                                </tr>
                            </table>
                            <hr class="messages_hr">
                        @endif
                      @endforeach
                    </div>

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
