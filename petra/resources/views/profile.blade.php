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
                  @endif
                  <div class="profile_first_part media">
                    <div class="profile_avatar media-left embed-responsive-item">
                      <img src="/images/avatars/{{$user->avatar}}" class="profile_avatarimg" alt="avatarimg"/>
                    </div>
                    <div class="media-body profile_name_description">
                      <h1 class="profile_name media-heading">{{$user->name}}</h1>
                      <div class="profile_description">
                      @if ($user->description=="")
                        <i>Encara sense descripció</i>
                      @else
                        <i>{{$user->description}}</i>
                      @endif
                      </div>
                    </div>
                  </div>

                  <hr>
                  <h3>Publicacions</h3>
                  <hr>

                  @foreach($posts as $post)
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
                        <img src="/images/posts/{{$post->id_user}}_{{$post->name}}/{{$post->photo}}" class="profile_lastpost_photo" alt="lastpost_photo"/>
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
                  @endforeach


                  </div>
            </div>
        </div>
    </div>
</div>

    <script>
      for (i = 0; i < document.getElementsByClassName('profile_post_photo').length; i++) {
        var profile_modal = document.getElementsByClassName('profile_modal')[i];
        var profile_img = document.getElementsByClassName('profile_post_photo')[i];
        var profile_modalImg = document.getElementsByClassName("profile_modal-content")[i];
        profile_img.onclick = function(){
            profile_modal.style.display = "block";
            profile_modalImg.src = this.src;
        }
        var profile_span = document.getElementsByClassName("profile_close")[i];
        profile_span.onclick = function() {
            profile_modal.style.display = "none";
        }
      }

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
    </script>

@endsection
