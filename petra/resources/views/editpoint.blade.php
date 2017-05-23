@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Editar lloc</h3></div>

                <div class="editprofile panel-body">
                  @if(isset($_POST['submit']))
                    <p class="editprofile_confirmation">Canvis realitzats correctament.</p>
                  @endif
                  <form action="#" method="POST" class="editprofile_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group media">
                      <div class="media-left embed-responsive-item">
                        <label>Avatar:</label><br/>
                        <img src="/images/avatars/points/{{$point->avatar}}" class="editprofile_avatarimg" alt="avatarimg"/><br/><br/>
                        <label for="editprofile_file-upload" class="editprofile_custom-file-upload">
                            <i class="glyphicon glyphicon-refresh"></i> Canviar avatar...
                        </label>
                        <input id="editprofile_file-upload" name="editpoint_avatar" type="file" class="file editprofile_avatar">
                      </div>
                      <div class="media-body">
                        <div class="form-group editprofile_postprivacy_group">
                          <label>Visibilitat del lloc en la web: </label>
                          <input name="editpoint_published" type="radio" value=1 <?php if ($point->published==1) echo "checked"; ?>> Public.
                          <input name="editpoint_published" type="radio" value=2 <?php if ($point->published==2) echo "checked"; ?>> Ocult.
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Nom:</label>
                        <input type="text" name="editpoint_name" class="form-control" value="{{$point->name}}">
                      </div>
                      <div class="form-group">
                       <label>Descripció:</label>
                       @if ($point->description=="")
                          <textarea name="editpoint_description" class="form-control editprofile_description" placeholder="Encara sense descripció"></textarea>
                       @else
                          <textarea name="editpoint_description" class="form-control editprofile_description">{{$point->description}}</textarea>
                       @endif
                      </div>
                      <div class="form-group">
                        <label>Latitud:</label>
                        <input type="number" step="any" name="editpoint_lat" class="form-control" value="{{$point->latitude}}">
                      </div>
                      <div class="form-group">
                        <label>Longitud:</label>
                        <input type="number" step="any" name="editpoint_lon" class="form-control" value="{{$point->longitude}}">
                      </div>
                      <div class="form-group">
                        <label>Tipus de lloc:</label>
                        <select name="editpoint_type_point" class="form-control">
                          <option value="NULL" <?php if ($point->type_point=="NULL") echo "selected"; ?>>Escull un</option>
                          <option value="vet" <?php if ($point->type_point=="vet") echo "selected"; ?>>Veterinari</option>
                          <option value="pipican" <?php if ($point->type_point=="pipican") echo "selected"; ?>>Pipican</option>
                          <option value="hotel_can" <?php if ($point->type_point=="hotel_can") echo "selected"; ?>>Hotel pet-friendly</option>
                          <option value="protectora" <?php if ($point->type_point=="protectora") echo "selected"; ?>>Protectora</option>
                          <option value="botiga" <?php if ($point->type_point=="botiga") echo "selected"; ?>>Botiga</option>
                          <option value="park" <?php if ($point->type_point=="park") echo "selected"; ?>>Parc</option>
                          <option value="rest" <?php if ($point->type_point=="rest") echo "selected"; ?>>Restaurant pet-friendly</option>
                        </select>
                      </div>


                      @if(parse_url(url()->previous(), PHP_URL_PATH)==("/editpoint/".$point->id))
                        <a href="{{ url('/profile/'.Auth::id()) }}"><button type="button" class="btn btn-primary editprofile_back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Tornar enrere</button></a>
                      @else
                        <a href="{{url()->previous()}}"><button type="button" class="btn btn-primary editprofile_back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Tornar enrere</button></a>
                      @endif
                      <button type="submit" name="submit" class="btn btn-primary editprofile_submit"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Guardar canvis</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
