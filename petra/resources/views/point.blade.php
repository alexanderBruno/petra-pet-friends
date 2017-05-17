@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

            <div class="point panel-body">
                  @if(session('confirmation')=='error')
                    <p class="point_confirmation_false">Alguna cosa no ha sortit bè. Contacta amb un administrador.</p>
                  @elseif(session('confirmation')=='postposted')
                    <p class="point_confirmation_true">Comentari creat correctament.</p>
                  @elseif(session('confirmation')=='postedited')
                    <p class="point_confirmation_true">Comentari editat correctament.</p>
                  @elseif(session('confirmation')=='postnotedited')
                    <p class="point_confirmation_false">No pots editar aquest comentari!</p>
                  @elseif(session('confirmation')=='postdeleted')
                    <p class="point_confirmation_true">Comentari eliminat correctament.</p>
                  @elseif(session('confirmation')=='postnotdeleted')
                    <p class="point_confirmation_false">No pots eliminar aquest comentari!</p>
                  @endif

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
                    	<p>Serveis:</p>
                      @foreach($services as $service)
                        <i class="fa {{ $service->icon}}" title="{{ $service->name}}"></i>
                      @endforeach
                      
                    	<p>Puntuació:</p>
                      
                        <script type="text/javascript">
                            var score = {{ $score }};
                            var stars = ['#p1','#p2','#p3','#p4','#p5'];
                            $(document).ready(function(){
                                pawStar = Math.round(score);
                                for (var i = pawStar -1 ; i >= 0; i--) {
                                    $(stars[i]).css('color', '#ff6868');
                                }
                            });
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
                            <img src="/images/avatars/{{$review->avatar}}" class="point_avatarimg_review" alt="avatarimg_review"/>
                        </div>
                      
                <!-- nombre del usuario, contenido de la review, fecha de creacion o actualizacion y foto de la opinion -->
                        <div class="point_name_content_review media-body">
                            <h4 class="point_name_review media-heading">
                              <a class="point_iduser_review" href="{{ url('/profile/'.$review->id_user) }}">{{$review->name}}</a>
                              <small><p class="point_date_review"><?php echo strftime('%d/%m/%Y %H:%M', strtotime($review->created_at)); ?></p></small>
                            </h4>
                            <div>
                                {{ $review->content }}
                                @if ($review->created_at!=$review->updated_at)
                                    <i class="point_message_edited">Editat</i>
                                @endif
                            </div>
                            @if ($review->photo!=NULL)
                                <img src="/images/reviews/{{$review->id_point}}/{{$review->photo}}" class="point_lastreview_photo" alt="lastreview_photo"/>
                                <div class="review_modal">
                                    <span class="point_close">&times;</span>
                                    <img class="point_modal-content">
                                </div>
                            @endif
                        </div>

                      <div>
                    <!-- modal eliminar review --> 
                        @if ($review->id_user==Auth::id())
                            <div class="modal fade" id="confirm_delete_review_{{$review->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hiddtrue">×</button>
                                            <h4 class="modal-title" id="myModalLabel">Eliminar publicació</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Estàs a punt d'esborrar una publicació, aquesta acció és irreversi</p>
                                            <p>Vols continuar?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            <a href="/deletereview/{{$review->id}}"><button type="button" class="btn btn-danger point_modal_delete_btn">Eliminar</button></a>
                                        </div>
                                    </div>
                               </div>
                            </div>

                            <a class="point_review_options" data-toggle="modal" href="#confirm_delete_review_{{$review->id}}"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                            <a class="point_review_options" href="{{ url('/editreview/'.$review->id) }}"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                      @endif
                    <!-- fin modal -->   
                      </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js">
</script>
@endsection