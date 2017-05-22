@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="profile panel-body">
                  @if(session('confirmation')=='error')
                    <p class="profile_confirmation_false">Alguna cosa no ha sortit bè. Contacta amb un administrador.</p>
                  @elseif(session('confirmation')=='postedited')
                    <p class="profile_confirmation_true">Publicació editada correctament.</p>
                  @elseif(session('confirmation')=='postnotedited')
                    <p class="profile_confirmation_false">No pots editar aquesta publicació!</p>
                  @elseif(session('confirmation')=='postdeleted')
                    <p class="profile_confirmation_true">Publicació eliminada correctament.</p>
                  @elseif(session('confirmation')=='postnotdeleted')
                    <p class="profile_confirmation_false">No pots eliminar aquesta publicació!</p>
                  @elseif(session('confirmation')=='addsameuser')
                    <p class="profile_confirmation_false">No et pots enviar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='denyaddsameuser')
                    <p class="profile_confirmation_false">No et pots denegar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='acceptaddsameuser')
                    <p class="profile_confirmation_false">No et pots acceptar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='deletesameuser')
                    <p class="profile_confirmation_false">No et pots eliminar com a amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='removesameuser')
                    <p class="profile_confirmation_false">No et pots cancel·lar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='addalready')
                    <p class="profile_confirmation_false">Ja has enviat sol·licitud a aquest usuari, espera fins que respongui.</p>
                  @elseif(session('confirmation')=='denyaddalready')
                    <p class="profile_confirmation_false">No existeix aquesta sol·licitud. Ja la has denegat o l'altre usuari la ha cancel·lat.</p>
                  @elseif(session('confirmation')=='acceptaddalready')
                    <p class="profile_confirmation_false">No existeix aquesta sol·licitud. Ja la has acceptat o l'altre usuari la ha cancel·lat.</p>
                  @elseif(session('confirmation')=='deletealready')
                    <p class="profile_confirmation_false">Ja has eliminat l'amistat amb aquest usuari.</p>
                  @elseif(session('confirmation')=='removealready')
                    <p class="profile_confirmation_false">No existeix aquesta sol·licitud. Ja la has cancel·lat o l'altre usuari la ha acceptat.</p>
                  @elseif(session('confirmation')=='addedfriend')
                    <p class="profile_confirmation_true">Sol·licitud d'amistat enviada correctament. Esperant resposta de l'usuari.</p>
                  @elseif(session('confirmation')=='deniedadd')
                    <p class="profile_confirmation_true">Sol·licitud d'amistat denegada correctament.</p>
                  @elseif(session('confirmation')=='acceptedadd')
                    <p class="profile_confirmation_true">Sol·licitud d'amistat acceptada, tens un nou amic! :)</p>
                  @elseif(session('confirmation')=='deletedfriend')
                    <p class="profile_confirmation_true">Amistat eliminada correctament, has perdut un amic! :(</p>
                  @elseif(session('confirmation')=='removedadd')
                    <p class="profile_confirmation_true">Sol·licitud d'amistat cancel·lada correctament.</p>
                  @elseif(session('confirmation')=='reviewedited')
                    <p class="point_confirmation_true">Opinió editada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotedited')
                    <p class="point_confirmation_false">No pots editar aquesta opinió!</p>
                  @elseif(session('confirmation')=='reviewdeleted')
                    <p class="point_confirmation_true">Opinió eliminada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotdeleted')
                    <p class="point_confirmation_false">No pots eliminar aquesta opinió!</p>
                  @endif
                  <div class="profile_first_part media">
                    <div class="profile_avatar media-left embed-responsive-item">
                      <img src="/images/avatars/{{$user->avatar}}" class="profile_avatarimg" alt="avatarimg"/>
                    </div>
                    <div class="media-body profile_name_description">
                      <h1 class="profile_name media-heading">{{$user->name}}

                          @if (Auth::id()!=$user->id)
                            <a href="{{route('message.read', ['id'=>$user->id])}}" class="profile_chat" title="Xatejar amb {{$user->name}}">
                              <i class="fa fa-commenting profile_chat_button" aria-hidden="true"></i>
                            </a>
                            @if($friendship!=null)
                              @if ($friendship->status==0 and $friendship->sender_id==Auth::id())
                              <a href="/friends/removeadd/{{$user->id}}" class="profile_askfriend">
                                <i class="fa fa-question-circle" class="profile_askfriend_button" aria-hidden="true"></i>
                                <i class="fa fa-times-circle" class="profile_askfriend_button" aria-hidden="true" title="Cancel·lar sol·licitud d'amistat"></i>
                              </a>
                              @elseif ($friendship->status==0 and $friendship->recipient_id==Auth::id())
                              <a href="/friends/denyadd/{{$user->id}}" class="profile_askfriend_indv">
                                <i class="fa fa-times-circle" class="profile_askfriend_button" aria-hidden="true" title="Denegar sol·licitud d'amistat"></i>
                              </a>
                              <a href="/friends/acceptadd/{{$user->id}}" class="profile_askfriend_indv">
                                <i class="fa fa-check-circle" class="profile_askfriend_button" aria-hidden="true" title="Acceptar sol·licitud d'amistat"></i>
                              </a>
                              @elseif ($friendship->status==1)
                              <a href="/friends/delete/{{$user->id}}" class="profile_askfriend profile_askfriendpink">
                                <i class="fa fa-check-circle" class="profile_askfriend_button" aria-hidden="true"></i>
                                <i class="fa fa-minus-circle" class="profile_askfriend_button" aria-hidden="true" title="Eliminar de les meves amistats"></i>
                              </a>
                              @elseif ($friendship->status==2 and $friendship->recipient_id==Auth::id())
                              <a href="/friends/allowadd/{{$user->id}}" class="profile_addfriend">
                                <i class="fa fa-info-circle" class="profile_addfriend_button" aria-hidden="true" title="Permetre enviar sol·licitud d'amistat"></i>
                              </a>
                              @endif
                            @else
                              <a href="/friends/add/{{$user->id}}" class="profile_addfriend">
                                <i class="fa fa-plus-circle" class="profile_addfriend_button" aria-hidden="true" title="Enviar sol·licitud d'amistat a {{$user->name}}"></i>
                              </a>
                            @endif
                          @endif

                      </h1>

                      <div class="profile_description">
                      @if ($user->description=="")
                        <i>Encara sense descripció</i>
                      @else
                        <i>{{$user->description}}</i>
                      @endif
                      </div>
                    </div>
                  </div>

                  <ul class="nav nav-tabs profile_tabs">
                    <li class="active"><a data-toggle="tab" href="#p"><h4>Publicacions</h4></a></li>
                    <li><a data-toggle="tab" href="#o"><h4>Opinions</h4></a></li>
                  </ul>
                  <div class="profile tab-content">
                    <div id="p" class="profile tab-pane fade in active">
                      @foreach($posts as $post)
                        @foreach($usersR as $userR)
                          @if($userR->id==$post->id_user)
                            <?php $userR=$userR ?> @break
                          @endif
                        @endforeach
                        @if($post->id_user==Auth::id() or $post->posts_privacy==1 or ($post->posts_privacy==2 and $userE->isFriendWith($userR)))
                          <div class="panel panel-info media profile_post">
                            <div class="profile_avatar_post media-left">
                              <img src="/images/avatars/{{$post->avatar}}" class="profile_avatarimg_post" alt="avatarimg_post"/>
                            </div>

                            <div class="profile_name_content_post media-body">
                              <h4 class="profile_name_post media-heading">
                                <a class="profile_iduser_post" href="{{ url('/profile/'.$post->id_user) }}">{{$post->name}}</a>
                                <small><p class="profile_date_post"><?php echo strftime('%d/%m/%Y %H:%M', strtotime($post->created_at)); ?></p></small>
                              </h4>
                              <div>
                                {{ $post->content }}
                                @if ($post->created_at!=$post->updated_at)
                                  <i class="profile_message_edited">Editat</i>
                                @endif
                              </div>
                              @if ($post->photo!=NULL)
                                <img src="/images/posts/{{$post->id_user}}/{{$post->photo}}" class="profile_lastpost_photo" alt="lastpost_photo"/>
                                <div class="profile_modal">
                                  <span class="profile_close">&times;</span>
                                  <img class="profile_modal-content">
                                </div>
                              @endif
                            </div>
                            <?php $clicked=False ?>
                              @foreach($likesdone as $likedone)
                                @if ($post->id==$likedone->id_post)
                                  <?php $clicked=True ?> @break
                                @endif
                              @endforeach

                              @if($clicked)
                                <a class="profile_post_likes_clicked" data-postid="{{$post->id}}" data-postlikes="{{$post->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="profile_post_likes_num">{{$post->likes}}</label></a>
                              @else
                                <a class="profile_post_likes" data-postid="{{$post->id}}" data-postlikes="{{$post->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="profile_post_likes_num">{{$post->likes}}</label></a>
                              @endif
                            @if ($post->id_user==Auth::id())
                              <div class="modal fade" id="confirm_delete_post_{{$post->id}}" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="myModalLabel">Eliminar publicació</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Estàs a punt d'esborrar una publicació, aquesta acció és irreversible.</p>
                                            <p>Vols continuar?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                            <a href="/deletepost/{{$post->id}}"><button type="button" class="btn btn-danger profile_modal_delete_btn">Eliminar</button></a>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <a class="profile_post_options" data-toggle="modal" href="#confirm_delete_post_{{$post->id}}"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                              <a class="profile_post_options" href="{{ url('/editpost/'.$post->id) }}"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                            @endif
                          </div>
                        @endif
                      @endforeach
                    </div>
                    <div id="o" class="profile tab-pane fade">
                      @foreach($reviews as $review)

                        <div class="panel panel-info media point_review">
                            <div class="point_avatar_review media-left">
                                <img src="/images/avatars/{{$review->avatar}}" class="point_avatarimg_review" alt="avatarimg_review"/>
                            </div>

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
                              <div class="valoration valoration_review">
                                <label class = "full" id="p1_r{{$review->id}}"></label>
                                <label class = "full" id="p2_r{{$review->id}}"></label>
                                <label class = "full" id="p3_r{{$review->id}}"></label>
                                <label class = "full" id="p4_r{{$review->id}}"></label>
                                <label class = "full" id="p5_r{{$review->id}}"></label>
                              </div>
                              @if ($review->photo!=NULL)
                                  <img src="/images/reviews/{{$review->id_point}}/{{$review->photo}}" class="point_lastreview_photo" alt="lastreview_photo"/>
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
                                <?php $clickedreview=False ?>
                                @foreach($likesdonereview as $likedonereview)
                                  @if ($review->id==$likedonereview->id_review)
                                    <?php $clickedreview=True ?> @break
                                  @endif
                                @endforeach
                                @if($clickedreview)
                                  <a class="point_review_likes_clicked" data-reviewid="{{$review->id}}" data-reviewlikes="{{$review->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="point_review_likes_num">{{$review->likes}}</label></a>
                                @else
                                  <a class="point_review_likes" data-reviewid="{{$review->id}}" data-reviewlikes="{{$review->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="point_review_likes_num">{{$review->likes}}</label></a>
                                @endif

                              <label class="home_idpost_reviewtext">- Opinió sobre <a class="point_iduser_review home_idpost_review" href="{{ url('/point/'.$review->id_point) }}">{{$review->namepoint}}</a></label> -
                            @if ($review->id_user==Auth::id())
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
                                <a class="point_review_options home_review_options" data-toggle="modal" href="#confirm_delete_review_{{$review->id}}"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                                <a class="point_review_options home_review_options" href="{{ url('/editreview/'.$review->id_point.'/'.$review->id) }}"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                            @endif
                        </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
    ////////////////////////////Publicacions///////////////////////
      for (i = 0; i < document.getElementsByClassName('profile_lastpost_photo').length; i++) {
        var profile_modal = document.getElementsByClassName('profile_modal')[i];
        var profile_img = document.getElementsByClassName('profile_lastpost_photo')[i];
        var profile_modalImg = document.getElementsByClassName("profile_modal-content")[i];
        profile_img.onclick = function(){
            profile_modal.style.display = "block";
            profile_modalImg.src = this.src;
        }
        var profile_span = document.getElementsByClassName("profile_close")[i];
        profile_span.onclick = function() {
            profile_modal.style.display = "none";
        }
      };

      $(".profile_post_likes").on('click', function(){
          var $bnlk = $(this);
          var $lk = $(this).children('.profile_post_likes_num');
          var $post_id = $(this).data('postid');
          var $post_likes = $(this).data('postlikes');
          $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)+1 : $post_likes)
          if ($bnlk.hasClass('profile_post_likes')) {
            $bnlk.removeClass('profile_post_likes').addClass('profile_post_likes_clicked');
            $.ajax({
                  type: 'GET',
                  url: '/profile/likepost/'+$post_id,
                  success: function(data){
                      console.log('success', data);
                  },
                  error: function(data){
                      console.log('error', data);
                      alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                  }
                  });
          } else {
            $bnlk.removeClass('profile_post_likes_clicked').addClass('profile_post_likes');
            $.ajax({
                  type: 'GET',
                  url: '/profile/droplikepost/'+$post_id,
                  success: function(data){
                      console.log('success', data);
                  },
                  error: function(data){
                      console.log('error', data);
                      alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                  }
                  });
          }

      });

      $(".profile_post_likes_clicked").on('click', function(){
        var $bnlk = $(this);
        var $lk = $(this).children('.profile_post_likes_num');
        var $post_id = $(this).data('postid');
        var $post_likes = $(this).data('postlikes');
        $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)-1 : $post_likes)
        if ($bnlk.hasClass('profile_post_likes_clicked')) {
          $bnlk.removeClass('profile_post_likes_clicked').addClass('profile_post_likes');
          $.ajax({
                type: 'GET',
                url: '/profile/droplikepost/'+$post_id,
                success: function(data){
                    console.log('success', data);
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        } else {
          $bnlk.removeClass('profile_post_likes').addClass('profile_post_likes_clicked');
          $.ajax({
                type: 'GET',
                url: '/profile/likepost/'+$post_id,
                success: function(data){
                    console.log('success', data);
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
          }
      });
      ////////////////////////////Publicacions///////////////////////


      ////////////////////////////Opinions///////////////////////
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

      $(".point_review_likes").on('click', function(){
          var $bnlk = $(this);
          var $lk = $(this).children('.point_review_likes_num');
          var $review_id = $(this).data('reviewid');
          var $review_likes = $(this).data('reviewlikes');
          $lk.text(($lk.text() == $review_likes) ? parseInt($review_likes)+1 : $review_likes)
          if ($bnlk.hasClass('point_review_likes')) {
            $bnlk.removeClass('point_review_likes').addClass('point_review_likes_clicked');
            $.ajax({
                  type: 'GET',
                  url: '/point/likereview/'+$review_id,
                  success: function(data){
                      console.log('success', data);
                  },
                  error: function(data){
                      console.log('error', data);
                      alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                  }
                  });
          } else {
            $bnlk.removeClass('point_review_likes_clicked').addClass('point_review_likes');
            $.ajax({
                  type: 'GET',
                  url: '/point/droplikereview/'+$review_id,
                  success: function(data){
                      console.log('success', data);
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
        $lk.text(($lk.text() == $review_likes) ? parseInt($review_likes)-1 : $review_likes)
        if ($bnlk.hasClass('point_review_likes_clicked')) {
          $bnlk.removeClass('point_review_likes_clicked').addClass('point_review_likes');
          $.ajax({
                type: 'GET',
                url: '/point/droplikereview/'+$review_id,
                success: function(data){
                    console.log('success', data);
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        } else {
          $bnlk.removeClass('point_review_likes').addClass('point_review_likes_clicked');
          $.ajax({
                type: 'GET',
                url: '/point/likereview/'+$review_id,
                success: function(data){
                    console.log('success', data);
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        }
      });
      ////////////////////////////Opinions///////////////////////

    </script>

@endsection
