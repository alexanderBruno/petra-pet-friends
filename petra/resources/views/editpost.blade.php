@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Editar publicació</h3></div>

                <div class="editpost panel-body">
                  <form action="/editpost/saved" method="POST" class="editpost_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                      <label>Contingut:</label>
                      <textarea name="editpost_content" class="form-control editpost_content">{{$post->content}}</textarea>
                    </div>
                    <div class="form-group">
                      <label>Imatge:</label><br/>
                      @if ($post->photo!=NULL)
                        <img src="/images/posts/{{$post->id_user}}/{{$post->photo}}" class="editpost_photoimg" alt="photoimg"/><br/><br/>
                        <label for="editpost_file-upload" class="editpost_custom-file-upload">
                            <i class="glyphicon glyphicon-refresh"></i> Canviar imatge...
                        </label>
                      @else
                        <label for="editpost_file-upload" class="editpost_custom-file-upload">
                            <i class="glyphicon glyphicon-refresh"></i> Afegir imatge...
                        </label>
                      @endif
                      <input id="editpost_file-upload" name="editpost_photo" type="file" class="file editpost_photo">
                    </div>
                    <input type="hidden" name="editpost_id" value="{{$post->id}}">
                    <input type="hidden" name="editpost_previousurl" value="{{url()->previous()}}">
                    <a href="{{url()->previous()}}"><button type="button" class="btn btn-primary editpost_back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Tornar enrere</button></a>
                    <button type="submit" name="submit" class="btn btn-primary editpost_submit">Guardar canvis</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
