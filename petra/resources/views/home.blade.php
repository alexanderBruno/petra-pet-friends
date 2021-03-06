@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="home panel-body">
                  @if(session('confirmation')=='error')
                    <p class="home_confirmation_false">Alguna cosa no ha sortit bè. Contacta amb un administrador.</p>
                  @elseif(session('confirmation')=='postposted')
                    <p class="home_confirmation_true">Publicació creada correctament.</p>
                  @elseif(session('confirmation')=='postnotposted')
                    <p class="home_confirmation_false">No has escrit cap missatge!</p>
                  @elseif(session('confirmation')=='postedited')
                    <p class="home_confirmation_true">Publicació editada correctament.</p>
                  @elseif(session('confirmation')=='postnotedited')
                    <p class="home_confirmation_false">No pots editar aquesta publicació!</p>
                  @elseif(session('confirmation')=='postdeleted')
                    <p class="home_confirmation_true">Publicació eliminada correctament.</p>
                  @elseif(session('confirmation')=='postnotdeleted')
                    <p class="home_confirmation_false">No pots eliminar aquesta publicació!</p>
                  @elseif(session('confirmation')=='usernotdeleted')
                    <p class="home_confirmation_false">No pots eliminar el compte d'un altre usuari!!</p>
                  @elseif(session('confirmation')=='reviewedited')
                    <p class="point_confirmation_true">Opinió editada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotedited')
                    <p class="point_confirmation_false">No pots editar aquesta opinió!</p>
                  @elseif(session('confirmation')=='reviewdeleted')
                    <p class="point_confirmation_true">Opinió eliminada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotdeleted')
                    <p class="point_confirmation_false">No pots eliminar aquesta opinió!</p>
                  @elseif(session('confirmation')=='pointnotpublic')
                    <p class="point_confirmation_false">Aquest lloc està ocult!</p>
                  @endif

                  <form action="/home" method="POST" class="home_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="form-group">
                     <label>Digues als teus amics què estàs fent!</label>
                     <textarea name="home_post" rows="3" class="form-control home_post" placeholder="Fes una publicació!"></textarea>
                    </div>
                    <label for="home_file-upload" class="home_custom-file-upload">
                        <i class="glyphicon glyphicon-camera"></i> Vols adjuntar una foto? Clica'm a sobre!
                    </label>
                    <input id="home_file-upload" name="home_post_photo" type="file" class="file home_post_photo">
                    <button type="submit" name="submit" class="btn btn-primary home_submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;Publicar</button>
                  </form><br/>

                  <hr class="messages_hr">
                  <h3 class="home_updates_title"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;Últimes novetats&nbsp;&nbsp;<i class="fa fa-newspaper-o" aria-hidden="true"></i></h3>
                  <hr class="messages_hr">

                      @foreach($updates as $update)
                        @if(isset($update->score))
                          <div class="panel panel-info media point_review">
                              <div class="point_avatar_review media-left">
                                  <img src="/images/avatars/{{$update->avatar}}" class="point_avatarimg_review" alt="avatarimg_review"/>
                              </div>

                              <div class="point_name_content_review media-body">
                                <h4 class="point_name_review media-heading">
                                  <a class="point_iduser_review" href="{{ url('/profile/'.$update->id_user) }}">{{$update->name}}</a>
                                  <small><p class="point_date_review"><?php echo strftime('%d/%m/%Y %H:%M', strtotime($update->created_at)); ?></p></small>
                                </h4>
                                <div class="review_content">
                                    {{ $update->content }}
                                    @if ($update->created_at!=$update->updated_at)
                                        <i class="point_message_edited">Editat</i>
                                    @endif
                                </div>
                                @if($update->content=="")
                                <div class="valoration valoration_review_withoutcomment">
                                @else
                                <div class="valoration valoration_review">
                                @endif
                                  <label class = "full" id="p1_r{{$update->id}}"></label>
                                  <label class = "full" id="p2_r{{$update->id}}"></label>
                                  <label class = "full" id="p3_r{{$update->id}}"></label>
                                  <label class = "full" id="p4_r{{$update->id}}"></label>
                                  <label class = "full" id="p5_r{{$update->id}}"></label>
                                </div>
                                @if ($update->photo!=NULL)
                                    <img src="/images/reviews/{{$update->id_user}}/{{$update->photo}}" class="point_lastreview_photo" alt="lastreview_photo"/>
                                    <div class="point_modal">
                                        <span class="point_close">&times;</span>
                                        <img class="point_modal-content">
                                    </div>
                                @endif
                              </div>


                                <script type="text/javascript">
                                    var personal_score = {{ $update->score }};

                                    var per_star = ["p1_r{{$update->id}}","p2_r{{$update->id}}","p3_r{{$update->id}}","p4_r{{$update->id}}","p5_r{{$update->id}}"];

                                    pawStar = Math.round(personal_score);
                                    for (var i = pawStar -1 ; i >= 0; i--) {
                                      document.getElementById(per_star[i]).style.color = '#ff6868';
                                    }
                                </script>
                                  <?php $clickedreview=False ?>
                                  @foreach($likesdonereview as $likedonereview)
                                    @if ($update->id==$likedonereview->id_review)
                                      <?php $clickedreview=True ?> @break
                                    @endif
                                  @endforeach
                                  @if($clickedreview)
                                    <a class="point_review_likes_clicked" data-reviewid="{{$update->id}}" data-reviewlikes="{{$update->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="point_review_likes_num">{{$update->likes}}</label></a>
                                  @else
                                    <a class="point_review_likes" data-reviewid="{{$update->id}}" data-reviewlikes="{{$update->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="point_review_likes_num">{{$update->likes}}</label></a>
                                  @endif

                                <label class="home_idpost_reviewtext">- Opinió sobre <a class="point_iduser_review home_idpost_review" href="{{ url('/point/'.$update->id_point) }}">{{$update->namepoint}}</a></label> -
                              @if ($update->id_user==Auth::id() or Auth::user()->type_user=="admin")
                                  <div class="modal fade" id="confirm_delete_review_{{$update->id}}" role="dialog">
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
                                                  <a href="/deletereview/{{$update->id}}"><button type="button" class="btn btn-danger point_modal_delete_btn">Eliminar</button></a>
                                              </div>
                                          </div>
                                     </div>
                                  </div>
                                  <a class="point_review_options home_review_options" data-toggle="modal" href="#confirm_delete_review_{{$update->id}}"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                                  <a class="point_review_options home_review_options" href="{{ url('/editreview/'.$update->id_point.'/'.$update->id) }}"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                              @endif
                          </div>
                        @else
                          @foreach($usersR as $userR)
                            @if($userR->id==$update->id_user)
                              <?php $userR=$userR ?> @break
                            @endif
                          @endforeach
                          @if($update->id_user==Auth::id() or $update->posts_privacy==1 or ($update->posts_privacy==2 and $userE->isFriendWith($userR))  or Auth::user()->type_user=="admin")
                            <div class="panel panel-info media home_post">
                              <div class="home_avatar_post media-left">
                                <img src="images/avatars/{{$update->avatar}}" class="home_avatarimg_post" alt="avatarimg_post"/>
                              </div>

                              <div class="home_name_content_post media-body">
                                <h4 class="home_name_post media-heading">
                                  <a class="home_iduser_post" href="{{ url('/profile/'.$update->id_user) }}">{{$update->name}}</a>
                                  <small><p class="home_date_post"><?php echo strftime('%d/%m/%Y %H:%M', strtotime($update->created_at)); ?></p></small>
                                </h4>
                                <div>
                                  {{ $update->content }}
                                  @if ($update->created_at!=$update->updated_at)
                                    <i class="home_message_edited">Editat</i>
                                  @endif
                                </div>
                                @if ($update->photo!=NULL)
                                  <img src="images/posts/{{$update->id_user}}/{{$update->photo}}" class="home_lastpost_photo" alt="lastpost_photo"/>
                                  <div class="home_modal">
                                    <span class="home_close">&times;</span>
                                    <img class="home_modal-content">
                                  </div>
                                @endif
                              </div>
                              <?php $clicked=False ?>
                                @foreach($likesdone as $likedone)
                                  @if ($update->id==$likedone->id_post)
                                    <?php $clicked=True ?> @break
                                  @endif
                                @endforeach

                                @if($clicked)
                                  <a class="home_post_likes_clicked" data-postid="{{$update->id}}" data-postlikes="{{$update->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="home_post_likes_num">{{$update->likes}}</label></a>
                                @else
                                  <a class="home_post_likes" data-postid="{{$update->id}}" data-postlikes="{{$update->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="home_post_likes_num">{{$update->likes}}</label></a>
                                @endif
                              @if ($update->id_user==Auth::id() or Auth::user()->type_user=="admin")
                                <div class="modal fade" id="confirm_delete_post_{{$update->id}}" role="dialog">
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
                                              <a href="/deletepost/{{$update->id}}"><button type="button" class="btn btn-danger home_modal_delete_btn">Eliminar</button></a>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                                <a class="home_post_options" data-toggle="modal" href="#confirm_delete_post_{{$update->id}}"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                                <a class="home_post_options" href="{{ url('/editpost/'.$update->id) }}"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                              @endif
                            </div>
                          @endif
                        @endif
                      @endforeach


            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
    ////////////////////////////Publicacions///////////////////////

      for (j = 0; j < document.getElementsByClassName('home_lastpost_photo').length; j++) {
        var home_modal = document.getElementsByClassName('home_modal')[j];
        var home_img = document.getElementsByClassName('home_lastpost_photo')[j];
        var home_modalImg = document.getElementsByClassName("home_modal-content")[j];
        home_img.onclick = function(){
            home_modal.style.display = "block";
            home_modalImg.src = this.src;
        }
        var home_span = document.getElementsByClassName("home_close")[j];
        home_span.onclick = function() {
            home_modal.style.display = "none";
        }
      }

      $(".home_post_likes").on('click', function(){
          var $bnlk = $(this);
          var $lk = $(this).children('.home_post_likes_num');
          var $post_id = $(this).data('postid');
          var $post_likes = $(this).data('postlikes');
          if ($bnlk.hasClass('home_post_likes')) {
            $.ajax({
                  type: 'GET',
                  url: '/home/likepost/'+$post_id,
                  success: function(data){
                      console.log('success', data);
                      $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)+1 : $post_likes)
                      $bnlk.removeClass('home_post_likes').addClass('home_post_likes_clicked');
                  },
                  error: function(data){
                      console.log('error', data);
                      alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                  }
                  });
          } else {
            $.ajax({
                  type: 'GET',
                  url: '/home/droplikepost/'+$post_id,
                  success: function(data){
                      console.log('success', data);
                      $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)+1 : $post_likes)
                      $bnlk.removeClass('home_post_likes_clicked').addClass('home_post_likes');
                  },
                  error: function(data){
                      console.log('error', data);
                      alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                  }
                  });
          }

      });

      $(".home_post_likes_clicked").on('click', function(){
        var $bnlk = $(this);
        var $lk = $(this).children('.home_post_likes_num');
        var $post_id = $(this).data('postid');
        var $post_likes = $(this).data('postlikes');
        if ($bnlk.hasClass('home_post_likes_clicked')) {
          $.ajax({
                type: 'GET',
                url: '/home/droplikepost/'+$post_id,
                success: function(data){
                    console.log('success', data);
                    $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)-1 : $post_likes)
                    $bnlk.removeClass('home_post_likes_clicked').addClass('home_post_likes');
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        } else {
          $.ajax({
                type: 'GET',
                url: '/home/likepost/'+$post_id,
                success: function(data){
                    console.log('success', data);
                    $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)-1 : $post_likes)
                    $bnlk.removeClass('home_post_likes').addClass('home_post_likes_clicked');
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
      ////////////////////////////Opinions///////////////////////

    </script>

@endsection
