<div class="people-list" id="people-list">
    <div class="search" style="text-align: center">
        <a href="{{url('/messages')}}" style="font-size:16px; text-decoration:none; color: white;"><i class="fa fa-paw" style="color:white;"></i> {{auth()->user()->name}}</a>
    </div>
    <ul class="list">
        @foreach($threads as $inbox)
            @if(!is_null($inbox->thread))
        <li class="clearfix">
            <a href="{{route('message.read', ['id'=>$inbox->withUser->id])}}">
            <img src="/images/avatars/{{$inbox->withUser->avatar}}" alt="avatar" class="chat_avatarimg" />
            <div class="about">
                <div class="name">{{$inbox->withUser->name}}</div>
                <div class="status">
                    @if(auth()->user()->id == $inbox->thread->sender->id)
                        <span class="fa fa-reply"></span>
                    @endif
                    <span>{{substr($inbox->thread->message, 0, 15)}}</span>
                </div>
            </div>
            </a>
        </li>
            @endif
        @endforeach
    </ul>
</div>
