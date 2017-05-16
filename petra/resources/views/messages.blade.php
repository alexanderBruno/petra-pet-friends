@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Usuaris de la web</div>

                <div class="messages panel-body">
                  @if(session('confirmation')=='usernotfound')
                    <p class="messages_confirmation_false">Aquest id no està associat ara mateix a cap usuari.</p>
                  @elseif(session('confirmation')=='sameuser')
                    <p class="messages_confirmation_false">Aquest id es el teu! Parla amb altres usuaris!</p>
                  @endif
                @foreach($users as $user)
                  @if($user->id!=Auth::id())
                      <table class="table">
                          <tr>
                              <td>
                                  <img src="/images/avatars/{{$user->avatar}}" class="messages_avatarimg" alt="avatarimg"/>
                                  <a class="messages_username" href="{{ url('/profile/'.$user->id) }}">{{$user->name}}</a>
                              </td>
                              <td>
                                  <a href="{{route('message.read', ['id'=>$user->id])}}" class="btn btn-success pull-right messages_buttonmessage">Enviar missatge</a>
                              </td>
                          </tr>
                      </table>
                    @endif
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
