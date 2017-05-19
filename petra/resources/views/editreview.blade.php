@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Editar opinió</h3></div>

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
                    <div>
                    <label>Puntuació:</label><br>
                    <fieldset class="edit_rating" name="valoration">
                          <input type="radio" id="paw5" name="rating" value="5" /><label for="paw5" title="Extelent!"></label>
                          <input type="radio" id="paw4" name="rating" value="4" /><label for="paw4" title="Molt Bé!"></label>
                          <input type="radio" id="paw3" name="rating" value="3" /><label for="paw3" title="Meh"></label>
                          <input type="radio" id="paw2" name="rating" value="2" /><label for="paw2" title="Dolent"></label>
                          <input type="radio" id="paw1" name="rating" value="1" /><label for="paw1" title="Molt dolent"></label> 
                    </fieldset><br><br>
                      
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