@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Editar comentari</h3></div>

                <div class="editreview panel-body">
                  <form action="/editreview/saved" method="POST" class="editreview_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                      <label>Contingut:</label>
                      <textarea name="editreview_content" class="form-control editreview_content">{{$review->content}}</textarea>
                    </div>
                    <div class="form-group">
                    
                      <label>Imatge:</label><br/>
                      @if ($review->photo!=NULL)
                        <img src="/images/reviews/{{$review->id_point}}/{{$review->photo}}" class="editreview_photoimg" alt="photoimg"/><br/><br/>
                        <label for="editreview_file-upload" class="editreview_custom-file-upload">
                            <i class="glyphicon glyphicon-refresh"></i> Canviar imatge...
                        </label>
                      @else
                        <label for="editreview_file-upload" class="editreview_custom-file-upload">
                            <i class="glyphicon glyphicon-refresh"></i> Afegir imatge...
                        </label>
                      @endif
                      
                      <input id="editreview_file-upload" name="editreview_photo" type="file" class="file editreview_photo">
                    </div>
                    <input type="hidden" name="editreview_id" value="{{$review->id}}">
                    <input type="hidden" name="editreview_previousurl" value="{{url()->previous()}}">
                    <a href="{{url()->previous()}}"><button type="button" class="btn btn-primary editreview_back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Tornar enrere</button></a>
                    <button type="submit" name="submit" class="btn btn-primary editreview_submit">Guardar canvis</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection