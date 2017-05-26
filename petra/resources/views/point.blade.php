@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

            <div class="point panel-body">
                  @if(session('confirmation')=='error')
                    <p class="point_confirmation_false">Alguna cosa no ha sortit bè. Contacta amb un administrador.</p>
                  @elseif(session('confirmation')=='reviewcreated')
                    <p class="point_confirmation_true">Opinió creada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotcreated')
                    <p class="point_confirmation_false">Si no escrius cap missatge o valores, no pots fer una opinió!</p>
                  @elseif(session('confirmation')=='reviewedited')
                    <p class="point_confirmation_true">Opinió editada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotedited')
                    <p class="point_confirmation_false">No pots editar aquesta opinió!</p>
                  @elseif(session('confirmation')=='reviewdeleted')
                    <p class="point_confirmation_true">Opinió eliminada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotdeleted')
                    <p class="point_confirmation_false">No pots eliminar aquesta opinió!</p>
                  @endif

                  <div class="point_first_part media">
                    <div class="point_avatar media-left embed-responsive-item">
                      <img src="/images/avatars/points/{{$point->avatar}}" class="point_avatarimg" alt="avatarimg"/>
                    </div>
                    <div class="point_name_description media-body">
                      <h1 class="point_name media-heading">{{ $point->name }}

                      <?php $faved=false; ?>
                        @foreach($favsdone as $favdone)
                          @if ($point->id==$favdone->id_point)
                            <?php $faved=true; ?> @break
                          @endif
                        @endforeach

                       @if($faved)
                          <i id="map_faved_{{$point->id}}" class="fa fa-heart map_faved" onclick="faved({{$point->id}})" aria-hidden="true"></i>
                       @else
                          <i id="map_fav_{{$point->id}}" class="fa fa-heart map_fav" onclick="fav({{$point->id}})" aria-hidden="true"></i>
                       @endif
                       </h1>
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
                      <div class="point_scoreall">
                        <p class="point_score">{{$point->score}}</p>
                        <div class="valoration">
                          <label class="full" id="p1"></label>
                          <label class="full" id="p2"></label>
                          <label class="full" id="p3"></label>
                          <label class="full" id="p4"></label>
                          <label class="full" id="p5"></label>
                        </div>
                      </div>
                      <div class="point_description">
                      @if ($point->description=="")
                        <i>Encara sense descripció</i>
                      @else
                        <i>{{$point->description}}</i>
                      @endif
                      </div>
                    </div>
                    @if(count($services)!=0)
                    <hr class="messages_hr">
                    <h3 class="home_updates_title"><i class="fa fa-handshake-o" aria-hidden="true"></i>&nbsp;&nbsp;Serveis que oferim&nbsp;&nbsp;<i class="fa fa-handshake-o" aria-hidden="true"></i></h3>
                    <hr class="messages_hr">
                    <div class="home_updates_title point_info">
                      @foreach($services as $service)
                        <i class="fa {{$service->icon}}" title="{{ $service->name}}"></i>&nbsp;
                      @endforeach
                    </div>
                    @endif
                  </div>

                    @if($reviewPermission < 1 and !Auth::guest())
                    <hr>
                    <h3>Vols opinar sobre aquest lloc?</h3>
                    <hr>

                      <form action="/point/{{$point->id}}" method="POST" class="point_form" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group">
                         <label>Digues als teus amics que et sembla aquest lloc!</label>
                         <textarea name="point_review" rows="3" class="form-control point_review" placeholder="Escriu la teva opinio i valora!"></textarea>
                        </div>
                        <div class="form-group point_review_makeoptions">
                          <label for="point_file-upload" class="point_review_custom-file-upload">
                              <i class="glyphicon glyphicon-camera"></i> Vols adjuntar una foto? Clica'm a sobre!
                          </label>
                          <input id="point_file-upload" name="point_review_photo" type="file" class="file point_review_photo">
                          <input type="hidden" name="point_review_id" value="{{$point->id}}">

                          <fieldset class="rating" name="point_valoration">
                            <input type="radio" id="paw5" name="rating" value="5" /><label for="paw5" title="Excelent!"></label>
                            <input type="radio" id="paw4" name="rating" value="4" /><label for="paw4" title="Molt bè!"></label>
                            <input type="radio" id="paw3" name="rating" value="3" /><label for="paw3" title="Bè"></label>
                            <input type="radio" id="paw2" name="rating" value="2" /><label for="paw2" title="Dolent"></label>
                            <input type="radio" id="paw1" name="rating" value="1" /><label for="paw1" title="Molt dolent"></label>
                          </fieldset>

                          <button type="submit" name="submit" class="btn btn-primary point_submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;Publicar</button>
                        </div>
                    </form>
                    @endif

                    @if(count($reviews)!=0)
                      <hr class="messages_hr">
                      <h3 class="home_updates_title"><i class="fa fa-envelope-open" aria-hidden="true"></i>&nbsp;&nbsp;Opinions&nbsp;&nbsp;<i class="fa fa-envelope-open" aria-hidden="true"></i></h3>
                      <hr class="messages_hr">
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
                              <div class="review_content">
                                  {{ $review->content }}
                                  @if ($review->created_at!=$review->updated_at)
                                      <i class="point_message_edited">Editat</i>
                                  @endif
                              </div>
                              @if($review->content=="")
                              <div class="valoration valoration_review_withoutcomment">
                              @else
                              <div class="valoration valoration_review">
                              @endif
                                <label class = "full" id="p1_r{{$review->id}}"></label>
                                <label class = "full" id="p2_r{{$review->id}}"></label>
                                <label class = "full" id="p3_r{{$review->id}}"></label>
                                <label class = "full" id="p4_r{{$review->id}}"></label>
                                <label class = "full" id="p5_r{{$review->id}}"></label>
                              </div>
                              @if ($review->photo!=NULL)
                                  <img src="/images/reviews/{{$review->id_user}}/{{$review->photo}}" class="point_lastreview_photo" alt="lastreview_photo"/>
                                  <div class="point_modal">
                                      <span class="point_close">&times;</span>
                                      <img class="point_modal-content">
                                  </div>
                              @endif
                            </div>


                              <script type="text/javascript">
                                  var personal_score = {{ $review->score }};

                                  var per_star = ["p1_r{{$review->id}}","p2_r{{$review->id}}","p3_r{{$review->id}}","p4_r{{$review->id}}","p5_r{{$review->id}}"];

                                  pawStar = Math.round(personal_score);
                                  for (var i = pawStar -1 ; i >= 0; i--) {
                                    document.getElementById(per_star[i]).style.color = '#ff6868';
                                  }
                              </script>
                                <?php $clicked=False ?>
                                @foreach($likesdone as $likedone)
                                  @if ($review->id==$likedone->id_review)
                                    <?php $clicked=True ?> @break
                                  @endif
                                @endforeach
                                @if($clicked)
                                  <a class="point_review_likes_clicked" data-reviewid="{{$review->id}}" data-reviewlikes="{{$review->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="point_review_likes_num">{{$review->likes}}</label></a>
                                @else
                                  <a class="point_review_likes" data-reviewid="{{$review->id}}" data-reviewlikes="{{$review->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="point_review_likes_num">{{$review->likes}}</label></a>
                                @endif
                              <label class="home_idpost_reviewtext">- Opinió sobre <a class="point_iduser_review home_idpost_review" href="{{ url('/point/'.$review->id_point) }}">{{$review->namepoint}}</a></label> -
                              @if(Auth::guest())
                              @elseif ($review->id_user==Auth::id() or Auth::user()->type_user=="admin")
                                <div class="modal fade" id="confirm_delete_review_{{$review->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hiddtrue>×</button>
                                                <h4 class="modal-title" id="myModalLabel">Eliminar publicació</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Estàs a punt d'esborrar la teva opinió, aquesta acció és irreversible</p>
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
                                <a class="point_review_options" href="{{ url('/editreview/'.$review->id_point.'/'.$review->id) }}"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                              @endif
                        <!-- fin modal -->
                        </div>
                      @endforeach
                    @endif
            </div>
        </div>
    </div>
</div>

@if(!Auth::guest())
  <script>{{'var logged = true;'}}</script>
@endif
<script type="text/javascript">
//modal de imagen
      for (j = 0; j < document.getElementsByClassName('point_lastreview_photo').length; j++) {
        var point_modal = document.getElementsByClassName('point_modal')[j];
        var point_img = document.getElementsByClassName('point_lastreview_photo')[j];
        var point_modalImg = document.getElementsByClassName("point_modal-content")[j];
        point_img.onclick = function(){
            point_modal.style.display = "block";
            point_modalImg.src = this.src;
        }
        var point_span = document.getElementsByClassName("point_close")[j];
        point_span.onclick = function() {
            point_modal.style.display = "none";
        }
      }

//sistema de likes
      if (logged==true) {

          $(".point_review_likes").on('click', function(){
              var $bnlk = $(this);
              var $lk = $(this).children('.point_review_likes_num');
              var $review_id = $(this).data('reviewid');
              var $review_likes = $(this).data('reviewlikes');
              if ($bnlk.hasClass('point_review_likes')) {
                $.ajax({
                      type: 'GET',
                      url: '/point/likereview/'+$review_id,
                      success: function(data){
                          console.log('success', data);
                          $lk.text(($lk.text() == $review_likes) ? parseInt($review_likes)+1 : $review_likes)
                          $bnlk.removeClass('point_review_likes').addClass('point_review_likes_clicked');
                      },
                      error: function(data){
                          console.log('error', data);
                          alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                      }
                      });
              } else {
                $.ajax({
                      type: 'GET',
                      url: '/point/droplikereview/'+$review_id,
                      success: function(data){
                          console.log('success', data);
                          $lk.text(($lk.text() == $review_likes) ? parseInt($review_likes)+1 : $review_likes)
                          $bnlk.removeClass('point_review_likes_clicked').addClass('point_review_likes');
                      },
                      error: function(data){
                          console.log('error', data);
                          alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                      }
                      });
              }

          });

          $(".point_review_likes_clicked").on('click', function(){
            var $bnlk = $(this);
            var $lk = $(this).children('.point_review_likes_num');
            var $review_id = $(this).data('reviewid');
            var $review_likes = $(this).data('reviewlikes');
            var $review_likes = $(this).data('reviewlikes');
            if ($bnlk.hasClass('point_review_likes_clicked')) {
              $.ajax({
                    type: 'GET',
                    url: '/point/droplikereview/'+$review_id,
                    success: function(data){
                        console.log('success', data);
                        $lk.text(($lk.text() == $review_likes) ? parseInt($review_likes)-1 : $review_likes)
                        $bnlk.removeClass('point_review_likes_clicked').addClass('point_review_likes');
                    },
                    error: function(data){
                        console.log('error', data);
                        alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                    }
                    });
            } else {
              $.ajax({
                    type: 'GET',
                    url: '/point/likereview/'+$review_id,
                    success: function(data){
                        console.log('success', data);
                        $lk.text(($lk.text() == $review_likes) ? parseInt($review_likes)-1 : $review_likes)
                        $bnlk.removeClass('point_review_likes').addClass('point_review_likes_clicked');
                    },
                    error: function(data){
                        console.log('error', data);
                        alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                    }
                    });
            }
          });
      }


      function fav(id) {
        var heart = $("#map_fav_"+{{$point->id}});
        if (heart.hasClass('map_fav')) {
          $.ajax({
                type: 'GET',
                url: '/map/favpoint/'+{{$point->id}},
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_fav').addClass('map_faved');
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        } else {
          $.ajax({
                type: 'GET',
                url: '/map/dropfavpoint/'+{{$point->id}},
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_faved').addClass('map_fav');
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        }

      };


      function faved(id) {
        var heart = $("#map_faved_"+{{$point->id}});
        if (heart.hasClass('map_fav')) {
          $.ajax({
                type: 'GET',
                url: '/map/favpoint/'+id,
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_fav').addClass('map_faved');
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        } else {
          $.ajax({
                type: 'GET',
                url: '/map/dropfavpoint/'+id,
                success: function(data){
                    console.log('success', data);
                    heart.removeClass('map_faved').addClass('map_fav');
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        }

      };
</script>

@endsection
