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
                  <form action="" method="POST" class="editprofile_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                      <label>Nom:</label>
                      <input type="text" name="editprofile_name" class="form-control" value="{{$user->name}}">
                      <!-- <p name="editprofile_name" editprofile-data-editable>{{$user->name}}</p> -->
                    </div>
                    <div class="form-group">
                     <label>Descripció:</label>
                     @if ($user->description=="")
                        <textarea name="editprofile_description" class="form-control" placeholder="Encara sense descripció"></textarea>
                     @else
                        <textarea name="editprofile_description" class="form-control">{{$user->description}}</textarea>
                     @endif
                       <!-- <p name="editprofile_description" editprofile-data-editable class="editprofile_description">Encara sense descripció</p> -->

                       <!-- <p name="editprofile_description" editprofile-data-editable class="editprofile_description">{{$user->description}}</p> -->
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
                    <div class="form-group">
                      <label>Avatar:</label><br/>
                      <img src="images/avatars/{{$user->avatar}}" class="editprofile_avatarimg" alt="avatarimg"/>
                      <br/><br/><input name="editprofile_avatar" type="file" class="file">
                    </div>


                    <button type="submit" name="submit" class="btn btn-primary editprofile_submit">Guardar canvis</button>
                  </form>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
