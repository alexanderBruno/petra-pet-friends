@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">

                  <div class="profile_first_part media">
                    <div class="profile_avatar media-left embed-responsive-item">
                      <img src="images/avatars/{{$user->avatar}}" class="profile_avatarimg" alt="avatarimg"/>
                    </div>
                    <div class="profile_name_description media-body">
                      <h1 class="profile_name media-heading">{{$user->name}}</h1>
                      @if ($user->description=="")
                        <i>Encara sense descripció</i>
                      @else
                        <i>{{$user->description}}</i>
                      @endif
                    </div>
                  </div>

                  <hr>

                  @foreach($posts as $post)
                  <div class="panel panel-info media profile_post">
                    <div class="profile_avatar_post media-left">
                      <img src="images/avatars/{{$post->avatar}}" class="profile_avatarimg_post" alt="avatarimg_post"/>
                    </div>
                    <div class="profile_name_content_post media-body">
                      <h4 class="profile_name_post media-heading">{{$post->name}}</h4>
                      {{ $post->content }}
                      @if ($post->photo!=NULL)
                        <img src="images/posts/{{$post->photo}}" class="profile_post_photo" alt="post_photo"/>
                        <div class="profile_modal">
                          <span class="profile_close">&times;</span>
                          <img class="profile_modal-content">
                        </div>
                      @endif
                    </div>
                  </div>
                  @endforeach


                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
