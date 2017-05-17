@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Editar perfil</h3></div>

                <div class="editprofile panel-body">
                  @if(isset($_POST['submit']))
                    <p class="editprofile_confirmation">Canvis realitzats correctament.</p>
                  @endif
                  <form action="#" method="POST" class="editprofile_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group media">
                      <div class="media-left embed-responsive-item">
                        <label>Avatar:</label><br/>
                        <img src="images/avatars/{{$user->avatar}}" class="editprofile_avatarimg" alt="avatarimg"/><br/><br/>
                        <label for="editprofile_file-upload" class="editprofile_custom-file-upload">
                            <i class="glyphicon glyphicon-refresh"></i> Canviar avatar...
                        </label>
                        <input id="editprofile_file-upload" name="editprofile_avatar" type="file" class="file editprofile_avatar">
                      </div>
                      <div class="media-body">
                        <div class="form-group editprofile_postprivacy_group">
                          <label>Qui pot veure les meves publicacions?: </label>
                          <input name="editprofile_postprivacy" type="radio" value=1 <?php if ($user->posts_privacy==1) echo "checked"; ?>> Tothom, vull que les meves publicacions son públiques.
                          <input name="editprofile_postprivacy" type="radio" value=2 <?php if ($user->posts_privacy==2) echo "checked"; ?>> Nomès les meves amistats, els demès no podrán veure res.
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Nom:</label>
                        <input type="text" name="editprofile_name" class="form-control" value="{{$user->name}}">
                      </div>
                      <div class="form-group">
                       <label>Descripció:</label>
                       @if ($user->description=="")
                          <textarea name="editprofile_description" class="form-control editprofile_description" placeholder="Encara sense descripció"></textarea>
                       @else
                          <textarea name="editprofile_description" class="form-control editprofile_description">{{$user->description}}</textarea>
                       @endif
                      </div>
                      <div class="form-group">
                        <label>Tipus de mascota:</label>
                        <select name="editprofile_type_pet" class="form-control">
                          <option value="NULL" <?php if ($user->type_pet=="NULL") echo "selected"; ?>>Escull una</option>
                          <option value="gos" <?php if ($user->type_pet=="gos") echo "selected"; ?>>Gos</option>
                          <option value="gat" <?php if ($user->type_pet=="gat") echo "selected"; ?>>Gat</option>
                          <option value="hamster" <?php if ($user->type_pet=="hamster") echo "selected"; ?>>Hàmster</option>
                          <option value="fura" <?php if ($user->type_pet=="fura") echo "selected"; ?>>Fura</option>
                        </select>
                      </div>
                      <a href="{{url()->previous()}}"><button type="button" class="btn btn-primary editpost_back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Tornar enrere</button></a>
                      <button type="submit" name="submit" class="btn btn-primary editprofile_submit">Guardar canvis</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
