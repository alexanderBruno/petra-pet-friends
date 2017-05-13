@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">

                  <div class="point_first_part media">
                    <div class="point_avatar media-left embed-responsive-item">
                      <img src="/images/avatars/{{$point->avatar}}" class="point_avatarimg" alt="avatarimg"/>
                    </div>
                    <div class="point_name_description media-body">
                      <h1 class="point_name media-heading">{{ $point->name }}</h1>
                      @if ($point->description=="")
                        <i>Encara sense descripció</i>
                      @else
                        <i>{{$point->description}}</i>
                      @endif

                    </div>
                    <div>
                    	<p>Serveis: {{ $point->services_list }}</p>
                      
                    	<p>Puntuació:</p>
                      
                        <script type="text/javascript">
                          var score = '{{ $score }}';
                        </script>
                      
                      <div class="valoration">
                        <label class = "full" id="p1"></label> 
                        <label class = "full" id="p2"></label> 
                        <label class = "full" id="p3"></label> 
                        <label class = "full" id="p4"></label> 
                        <label class = "full" id="p5"></label> 
                      </div>
                    </div>
                  </div>
                  @if(isset($reviewPermission))
                    @if($reviewPermission == false)
                    <hr>
                    <h3>Vols opinar sobre aquest lloc?</h3>
                    <hr>

                    
                      <form action="/point/{{$point->id}}" method="POST" class="point_form" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group">
                          @if (isset($confirmation))
                            <p class="point_confirmation_true">Opinió feta.</p>
                          @endif
                         <label>Digues als teus amics que et sembla aquest lloc!</label>
                         <textarea name="point_review" rows="3" class="form-control point_review" placeholder="Escriu la teva opinio i valora!"></textarea>
                        </div>
                        <label for="point_file-upload" class="point_review_custom-file-upload">
                            <i class="glyphicon glyphicon-camera"></i> Vols adjuntar una foto? Clica'm a sobre!
                        </label>
                        <input id="point_file-upload" name="point_review_photo" type="file" class="file point_review_photo">
                        <input type="hidden" name="point_review_id" value="{{$point->id}}">
                      
                        <fieldset class="rating" name="point_valoration">
                          <input type="radio" id="paw5" name="rating" value="5" /><label for="paw5" title="Extelent!"></label>
                          <input type="radio" id="paw4" name="rating" value="4" /><label for="paw4" title="Molt Bé!"></label>
                          <input type="radio" id="paw3" name="rating" value="3" /><label for="paw3" title="Meh"></label>
                          <input type="radio" id="paw2" name="rating" value="2" /><label for="paw2" title="Dolent"></label>
                          <input type="radio" id="paw1" name="rating" value="1" /><label for="paw1" title="Molt dolent"></label> 
                        </fieldset>
                     
                      <button type="submit" name="submit" class="btn btn-primary point_submit">Publicar</button>
                    </form>
                    @endif
                  @endif
                  <hr>
                  <h3>Comentaris:</h3>
                  <hr>
                  @foreach($reviews as $review)

                    <div class="panel panel-info media point_review">
                      <div class="point_avatar_review media-left">
                        <img src="images/avatars/{{$review->avatar}}" class="point_avatarimg_review" alt="avatarimg_review"/>
                      </div>
                      <div class="point_name_content_review media-body">
                        <h3 class="point_name_review media-heading">{{$review->name}}</h3>
                        {{ $review->content }}
                      </div>
                      <div>
                      @if(isset($loged))
                        @if ($loged == $review->id_user)
                          <p>edita</p>
                          <p>elimina</p>
                        @endif
                      @endif
                      </div>
                    </div>
                  @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
