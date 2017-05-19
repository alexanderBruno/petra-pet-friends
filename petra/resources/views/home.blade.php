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
                  </form>

                  <hr>
                  <h3>Últimes publicacions</h3>
                  <hr>
                  @foreach($lastposts as $post)
                    @foreach($usersR as $userR)
                      @if($userR->id==$post->id_user)
                        <?php $userR=$userR ?> @break
                      @endif
                    @endforeach
                    @if($post->id_user==Auth::id() or $post->posts_privacy==1 or ($post->posts_privacy==2 and $userE->isFriendWith($userR)))
                      <div class="panel panel-info media home_post">
                        <div class="home_avatar_post media-left">
                          <img src="images/avatars/{{$post->avatar}}" class="home_avatarimg_post" alt="avatarimg_post"/>
                        </div>

                        <div class="home_name_content_post media-body">
                          <h4 class="home_name_post media-heading">
                            <a class="home_iduser_post" href="{{ url('/profile/'.$post->id_user) }}">{{$post->name}}</a>
                            <small><p class="home_date_post"><?php echo strftime('%d/%m/%Y %H:%M', strtotime($post->created_at)); ?></p></small>
                          </h4>
                          <div>
                            {{ $post->content }}
                            @if ($post->created_at!=$post->updated_at)
                              <i class="home_message_edited">Editat</i>
                            @endif
                          </div>
                          @if ($post->photo!=NULL)
                            <img src="images/posts/{{$post->id_user}}/{{$post->photo}}" class="home_lastpost_photo" alt="lastpost_photo"/>
                            <div class="home_modal">
                              <span class="home_close">&times;</span>
                              <img class="home_modal-content">
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
                            <a class="home_post_likes_clicked" data-postid="{{$post->id}}" data-postlikes="{{$post->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="home_post_likes_num">{{$post->likes}}</label></a>
                          @else
                            <a class="home_post_likes" data-postid="{{$post->id}}" data-postlikes="{{$post->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="home_post_likes_num">{{$post->likes}}</label></a>
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
                                        <a href="/deletepost/{{$post->id}}"><button type="button" class="btn btn-danger home_modal_delete_btn">Eliminar</button></a>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <a class="home_post_options" data-toggle="modal" href="#confirm_delete_post_{{$post->id}}"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
                          <a class="home_post_options" href="{{ url('/editpost/'.$post->id) }}"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                        @endif
                      </div>
                    @endif
                  @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
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
          $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)+1 : $post_likes)
          if ($bnlk.hasClass('home_post_likes')) {
            $bnlk.removeClass('home_post_likes').addClass('home_post_likes_clicked');
            $.ajax({
                  type: 'GET',
                  url: '/home/likepost/'+$post_id,
                  success: function(data){
                      console.log('success', data);
                  },
                  error: function(data){
                      console.log('error', data);
                      alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                  }
                  });
          } else {
            $bnlk.removeClass('home_post_likes_clicked').addClass('home_post_likes');
            $.ajax({
                  type: 'GET',
                  url: '/home/droplikepost/'+$post_id,
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

      $(".home_post_likes_clicked").on('click', function(){
        var $bnlk = $(this);
        var $lk = $(this).children('.home_post_likes_num');
        var $post_id = $(this).data('postid');
        var $post_likes = $(this).data('postlikes');
        $lk.text(($lk.text() == $post_likes) ? parseInt($post_likes)-1 : $post_likes)
        if ($bnlk.hasClass('home_post_likes_clicked')) {
          $bnlk.removeClass('home_post_likes_clicked').addClass('home_post_likes');
          $.ajax({
                type: 'GET',
                url: '/home/droplikepost/'+$post_id,
                success: function(data){
                    console.log('success', data);
                },
                error: function(data){
                    console.log('error', data);
                    alert("Ups! Alguna cosa ha fallat, prova-ho més endavant.");
                }
                });
        } else {
          $bnlk.removeClass('home_post_likes').addClass('home_post_likes_clicked');
          $.ajax({
                type: 'GET',
                url: '/home/likepost/'+$post_id,
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
