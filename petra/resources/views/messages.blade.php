@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Usuaris de la web</div>

                <div class="messages panel-body">
                @foreach($users as $user)
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
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
