@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Contacta amb nosaltres</h3></div>

                <div class="contact panel-body">
                  @if(session('confirmation')=='error')
                    <p class="home_confirmation_false">Alguna cosa no ha sortit bè. Contacta amb un administrador.</p>
                  @elseif(session('confirmation')=='sended')
                    <p class="home_confirmation_true">Missatge rebut! En les pròximes 24 hores rebràs una resposta. Gràcies per contactar!</p>
                  @endif
                  <ul>
                      @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
                  <h5 class="contact_firstmessage">Tens algun problema? Algun suggeriment? Vols preguntar-nos alguna cosa?<br/>Sigui el que sigui, et convidem a que contactis amb nosaltres utilitzant el formulari d'aquí sota. Gràcies!</h5>
                  <form action="/contact" method="POST" class="contact_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                      <label>Nom:</label>
                      @if ($user==null)
                      <input type="text" name="contact_name" class="form-control" value="{{$user}}" required>
                      @else
                      <input type="text" name="contact_name" class="form-control" value="{{$user->name}}" required>
                      @endif
                    </div>
                    <div class="form-group">
                      <label>Email:</label>
                      @if ($user==null)
                      <input type="email" name="contact_email" class="form-control" value="{{$user}}" required>
                      @else
                      <input type="email" name="contact_email" class="form-control" value="{{$user->email}}" required>
                      @endif
                    </div>
                    <div class="form-group">
                      <label>Missatge:</label>
                      <textarea name="contact_message" rows="3" class="form-control contact_message" placeholder="Escriu el teu missatge..." required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="contact_file-upload" class="contact_custom-file-upload">
                          <i class="glyphicon glyphicon-camera"></i> Vols adjuntar una foto? Clica'm a sobre!
                      </label>
                      <input id="contact_file-upload" name="contact_photo" type="file" class="file contact_photo">
                    </div>
                    <a href="{{url()->previous()}}"><button type="button" class="btn btn-primary contact_back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;Tornar enrere</button></a>
                    <button type="submit" name="submit" class="btn btn-primary contact_submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;Enviar missatge</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
