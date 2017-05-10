@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="home panel-body">
                  @if(isset($_POST['submit']))
                    <p class="home_confirmation">Publicació feta.</p>
                  @endif
                  <form action="#" method="POST" class="home_form" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="form-group">
                     <label>Diga'l's-hi als teus amics què estàs fent!</label>
                     <textarea name="home_post" rows="3" class="form-control home_post" placeholder="Fes una publicació!"></textarea>
                    </div>
                    <label for="home_file-upload" class="home_custom-file-upload">
                        <i class="glyphicon glyphicon-camera"></i> Vols adjuntar una foto? Clica'm a sobre!
                    </label>
                    <input id="home_file-upload" name="home_post_photo" type="file" class="file home_post_photo">
                    <button type="submit" name="submit" class="btn btn-primary home_submit">Publicar</button>
                  </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
