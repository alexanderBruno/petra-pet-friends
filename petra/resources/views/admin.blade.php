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
                    <p class="profile_confirmation_true">Opinió editada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotedited')
                    <p class="profile_confirmation_false">No pots editar aquesta opinió!</p>
                  @elseif(session('confirmation')=='reviewdeleted')
                    <p class="profile_confirmation_true">Opinió eliminada correctament.</p>
                  @elseif(session('confirmation')=='reviewnotdeleted')
                    <p class="profile_confirmation_false">No pots eliminar aquesta opinió!</p>
                  @elseif(session('confirmation')=='pointnotedited')
                    <p class="profile_confirmation_false">No pots editar aquest lloc!</p>
                  @elseif(session('confirmation')=='pointdeleted')
                    <p class="profile_confirmation_true">Lloc eliminat correctament.</p>
                  @elseif(session('confirmation')=='pointnotdeleted')
                    <p class="profile_confirmation_false">No pots eliminar aquest lloc!</p>
                  @endif
                  <hr class="messages_hr">
                  <h3 class="home_updates_title"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;Panell d'administració&nbsp;&nbsp;<i class="fa fa-lock" aria-hidden="true"></i></h3>
                  <hr class="messages_hr">

                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#u"><h4>Usuaris</h4></a></li>
                    <li><a data-toggle="tab" href="#l"><h4>Llocs</h4></a></li>
                    <li><a data-toggle="tab" href="#p"><h4>Publicacions</h4></a></li>
                    <li><a data-toggle="tab" href="#o"><h4>Opinions</h4></a></li>

                  </ul>
                  <div class="profile tab-content">
                    <div id="u" class="profile tab-pane fade in active">
                      @if(count($users)==0)
                        <p class="profile_confirmation_info">No hi ha usuaris?</p>
                      @else
                        @foreach($users as $user)
                            <table class="friends table">
                                <tr>
                                    <td>
                                        <img src="/images/avatars/{{$user->avatar}}" class="friends_avatarimg" alt="avatarimg"/>
                                        @if($user->id==Auth::id())
                                          <a class="friends_username" href="{{ url('/profile/'.$user->id) }}">{{$user->name}} (jo)</a>
                                        @else
                                          <a class="friends_username" href="{{ url('/profile/'.$user->id) }}">{{$user->name}}</a>
                                        @endif
                                    </td>
                                    <td>
                                      <div class="modal fade" id="confirm_delete_user_{{$user->id}}" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Eliminar compte</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Estàs a punt d'esborrar el teu compte, aquesta acció és irreversible.</p>
                                                    <p>Vols continuar?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                                                    <a href="/editprofile/deleteuser/{{$user->id}}"><button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button></a>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      <a href="#confirm_delete_user_{{$user->id}}" data-toggle="modal" class="btn btn-danger pull-right friends_buttonmessage"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Eliminar compte</a>
                                      <a href="/editprofile/{{$user->id}}" class="btn btn-primary pull-right friends_buttonmessage"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Editar perfil</a>
                                    </td>
                                </tr>
                            </table>
                            <hr class="friends_hr">
                        @endforeach
                      @endif
                    </div>
                    <div id="l" class="profile tab-pane fade">
                      @if(count($points)==0)
                        <p class="profile_confirmation_info">Encara no hi ha cap lloc afegit, ves al mapa i afegeix un marcador!</p>
                      @else
                        @foreach($points as $point)
                            <table class="friends table">
                                <tr>
                                    <td>
                                        <img src="/images/avatars/points/{{$point->avatar}}" class="friends_avatarimg" alt="avatarimg"/>
                                        <a class="friends_username" href="{{ url('/point/'.$point->id) }}">{{$point->name}}</a>
                                    </td>
                                    <td>
                                      <div class="modal fade" id="confirm_delete_point_{{$point->id}}" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Eliminar lloc</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Estàs a punt d'esborrar aquest lloc, aquesta acció és irreversible.</p>
                                                    <p>Vols continuar?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                                                    <a href="/deletepoint/{{$point->id}}"><button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button></a>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      <a href="#confirm_delete_point_{{$point->id}}" data-toggle="modal" class="btn btn-danger pull-right friends_buttonmessage"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Eliminar lloc</a>
                                      <a href="/editpoint/{{$point->id}}" class="btn btn-primary pull-right friends_buttonmessage"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Editar lloc</a>
                                    </td>
                                </tr>
                            </table>
                            <hr class="friends_hr">
                        @endforeach
                      @endif
                    </div>
                    <div id="p" class="profile tab-pane fade">
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
                                <img src="/images/posts/{{$post->id_user}}/{{$post->photo}}" class="profile_lastpost_photo" alt="lastpost_photo"/>
                                <div class="profile_modal">
                                  <span class="profile_close">&times;</span>
                                  <img class="profile_modal-content">
                                </div>
                              @endif
                            </div>
                              <a class="profile_post_likes" data-postid="{{$post->id}}" data-postlikes="{{$post->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="profile_post_likes_num">{{$post->likes}}</label></a>
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
                          </div>
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
                              <a class="point_review_likes" data-reviewid="{{$review->id}}" data-reviewlikes="{{$review->likes}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <label class="point_review_likes_num">{{$review->likes}}</label></a>
                              <label class="home_idpost_reviewtext">- Opinió sobre <a class="point_iduser_review home_idpost_review" href="{{ url('/point/'.$review->id_point) }}">{{$review->namepoint}}</a></label> -
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
                        </div>
                      @endforeach
                    </div>
                    <div id="lp" class="profile tab-pane fade">
                      En contrucción
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
      ////////////////////////////Opinions///////////////////////

    </script>

@endsection
