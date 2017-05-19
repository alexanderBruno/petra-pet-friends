@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Amistats</h4></div>
                <div class="friends panel-body">
                  @if(session('confirmation')=='error')
                    <p class="friends_confirmation_false">Alguna cosa no ha sortit bè. Contacta amb un administrador.</p>
                  @elseif(session('confirmation')=='addsameuser')
                    <p class="friends_confirmation_false">No et pots enviar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='denyaddsameuser')
                    <p class="friends_confirmation_false">No et pots denegar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='acceptaddsameuser')
                    <p class="friends_confirmation_false">No et pots acceptar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='deletesameuser')
                    <p class="friends_confirmation_false">No et pots eliminar com a amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='removesameuser')
                    <p class="friends_confirmation_false">No et pots cancel·lar una sol·licitud d'amistat a tu mateix!</p>
                  @elseif(session('confirmation')=='addalready')
                    <p class="friends_confirmation_false">Ja has enviat sol·licitud a aquest usuari, espera fins que respongui.</p>
                  @elseif(session('confirmation')=='denyaddalready')
                    <p class="friends_confirmation_false">No existeix aquesta sol·licitud. Ja la has denegat o l'altre usuari la ha cancel·lat.</p>
                  @elseif(session('confirmation')=='acceptaddalready')
                    <p class="friends_confirmation_false">No existeix aquesta sol·licitud. Ja la has acceptat o l'altre usuari la ha cancel·lat.</p>
                  @elseif(session('confirmation')=='deletealready')
                    <p class="friends_confirmation_false">Ja has eliminat l'amistat amb aquest usuari.</p>
                  @elseif(session('confirmation')=='removealready')
                    <p class="friends_confirmation_false">No existeix aquesta sol·licitud. Ja la has cancel·lat o l'altre usuari la ha acceptat.</p>
                  @elseif(session('confirmation')=='addedfriend')
                    <p class="friends_confirmation_true">Sol·licitud d'amistat enviada correctament. Esperant resposta de l'usuari.</p>
                  @elseif(session('confirmation')=='deniedadd')
                    <p class="friends_confirmation_true">Sol·licitud d'amistat denegada correctament.</p>
                  @elseif(session('confirmation')=='acceptedadd')
                    <p class="friends_confirmation_true">Sol·licitud d'amistat acceptada, tens un nou amic! :)</p>
                  @elseif(session('confirmation')=='deletedfriend')
                    <p class="friends_confirmation_true">Amistat eliminada correctament, has perdut un amic! :(</p>
                  @elseif(session('confirmation')=='removedadd')
                    <p class="friends_confirmation_true">Sol·licitud d'amistat cancel·lada correctament.</p>
                  @endif

                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#lta">Les meves amistats</a></li>
                    <li><a data-toggle="pill" href="#sap">Sol·licituds pendents</a></li>
                    <li><a data-toggle="pill" href="#sae">Sol·licituds enviades</a></li>
                    <li><a data-toggle="pill" href="#teu">Tots els usuaris</a></li>
                  </ul>

                  <div class="friends tab-content">
                    <div id="lta" class="friends tab-pane fade in active">
                      @if(count($yourfriends)==0)
                        <p class="friends_confirmation_info">Encara no tens cap amistat, anima't a fer alguna!</p>
                      @else
                        @foreach($yourfriends as $yourfriend)
                          @if($yourfriend->id!=Auth::id() and $yourfriend->status==1)
                            <table class="friends table">
                                <tr>
                                    <td>
                                        <img src="/images/avatars/{{$yourfriend->avatar}}" class="friends_avatarimg" alt="avatarimg"/>
                                        <a class="friends_username" href="{{ url('/profile/'.$yourfriend->id) }}">{{$yourfriend->name}}</a>
                                    </td>
                                    <td>
                                        <a href="/friends/delete/{{$yourfriend->id}}" class="btn btn-danger pull-right friends_buttonmessage"><i class="fa fa-minus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Eliminar de les meves amistats</a>
                                    </td>
                                </tr>
                            </table>
                            <hr class="friends_hr">
                          @endif
                        @endforeach
                      @endif
                    </div>
                    <div id="sap" class="friends tab-pane fade">
                      @if(count($yourpendingrequests)==0)
                        <p class="friends_confirmation_info">Ara mateix no tens cap solicitud d'amistat!</p>
                      @else
                        @foreach($yourpendingrequests as $yourpendingrequest)
                            <table class="friends table">
                                <tr>
                                    <td>
                                        <img src="/images/avatars/{{$yourpendingrequest->avatar}}" class="friends_avatarimg" alt="avatarimg"/>
                                        <a class="friends_username" href="{{ url('/profile/'.$yourpendingrequest->id) }}">{{$yourpendingrequest->name}}</a>
                                    </td>
                                    <td>
                                        <a href="/friends/denyadd/{{$yourpendingrequest->id}}" class="btn btn-danger pull-right friends_buttonmessage"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;&nbsp;Denegar</a>
                                        <a href="/friends/acceptadd/{{$yourpendingrequest->id}}" class="btn btn-success pull-right friends_buttonmessage"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;&nbsp;Acceptar</a>
                                    </td>
                                </tr>
                            </table>
                            <hr class="friends_hr">
                        @endforeach
                      @endif
                    </div>
                    <div id="sae" class="friends tab-pane fade">
                      @if(count($yoursendrequests)==0)
                        <p class="friends_confirmation_info">Ara mateix no tens cap solicitud d'amistat enviada sense respondre!</p>
                      @else
                        @foreach($yoursendrequests as $yoursendrequest)
                            <table class="friends table">
                                <tr>
                                    <td>
                                        <img src="/images/avatars/{{$yoursendrequest->avatar}}" class="friends_avatarimg" alt="avatarimg"/>
                                        <a class="friends_username" href="{{ url('/profile/'.$yoursendrequest->id) }}">{{$yoursendrequest->name}}</a>
                                    </td>
                                    <td>
                                        <a href="/friends/removeadd/{{$yoursendrequest->id}}" class="btn btn-danger pull-right friends_buttonmessage"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;&nbsp;Cancel·lar solicitud</a>
                                    </td>
                                </tr>
                            </table>
                            <hr class="friends_hr">
                        @endforeach
                      @endif
                    </div>
                    <div id="teu" class="friends tab-pane fade">
                      @if(count($allusers)==0)
                        <p class="friends_confirmation_false"></p>
                      @else
                        @foreach($allusers as $user)
                            <table class="friends table">
                                <tr>
                                    <td>
                                        <img src="/images/avatars/{{$user->avatar}}" class="friends_avatarimg" alt="avatarimg"/>
                                        @if($user->id==Auth::id())
                                          <a class="friends_username" href="{{ url('/profile/'.$user->id) }}">{{$user->name}} (jo)</a>
                                          </td>
                                          <td>
                                          </td>
                                        @else
                                          <a class="friends_username" href="{{ url('/profile/'.$user->id) }}">{{$user->name}}</a>
                                          </td>
                                          <td>
                                          @if(count($youcansendrequest)!=0)
                                            <?php $cansendrequest="False" ?>
                                            @foreach($youcansendrequest as $ycsr)
                                              @if($ycsr->sender_id==$user->id and $ycsr->recipient_id==Auth::id() and $ycsr->status==2)
                                                <?php $cansendrequest="Allow" ?> @break
                                              @elseif(($ycsr->sender_id==Auth::id() and $ycsr->recipient_id==$user->id) or ($ycsr->sender_id==$user->id and $ycsr->recipient_id==Auth::id()))
                                                <?php $cansendrequest="False" ?> @break
                                              @else
                                                <?php $cansendrequest="True" ?>
                                              @endif
                                            @endforeach
                                          @else
                                            <?php $cansendrequest="True" ?>
                                          @endif
                                          @if($cansendrequest=="True")
                                            <a href="/friends/add/{{$user->id}}" class="btn btn-info pull-right friends_buttonmessage"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Enviar solicitud d'amistat</a>
                                          @elseif($cansendrequest=="Allow")
                                            <a href="/friends/allowadd/{{$user->id}}" class="btn btn-info pull-right friends_buttonmessage"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;Permetre enviar sol·licitud d'amistat</a>
                                          @endif
                                          </td>
                                        @endif
                                </tr>
                            </table>
                            <hr class="friends_hr">
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
