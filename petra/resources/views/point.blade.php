@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">

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
                    	<p>Serveis: {{ $point->services_list }}</p>
                    	<p>Puntuació: {{ $point->score }}</p>
                    </div>
                  </div>

                  <hr>
                  <h2 class="point_name media-heading">Comentaris:</h2>
                   @foreach($comments as $comment)
                  <div class="panel panel-info media point_comment">
                    <div class="point_avatar_comment media-left">
                      <img src="images/avatars/{{$comment->avatar}}" class="point_avatarimg_comment" alt="avatarimg_comment"/>
                    </div>
                    <div class="point_name_content_comment media-body">
                      <h3 class="point_name_comment media-heading">{{$comment->name}}</h3>
                      {{ $comment->content }}
                    </div>
                  </div>
                  @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
