@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Editar perfil</h3></div>

                <div class="panel-body">
                  <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" class="form-control" id="nom">
                  </div>
                  <div class="form-group">
                    <label for="pwd">Contrasenya:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                  <div class="form-group">
                   <label for="description">Descripció:</label>
                   <textarea class="form-control" rows="5" id="description"></textarea>
                  </div>
                  <div class="changeavatar">
                    <label for="input-avatar">Avatar</label><br/>
                    <img src="images/avatars/{{$user->avatar}}" class="editprofile_avatarimg" alt="avatarimg"/>
                    <br/><br/><input id="input-avatar" type="file" class="file">
                  </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
