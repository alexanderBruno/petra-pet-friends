<li class="clearfix" id="message-{{$message->id}}">
    <div class="message-data align-right">
        <span class="message-data-time" >fa {{$message->humans_time}}</span> &nbsp; &nbsp;
        <span class="message-data-name" >{{$message->sender->name}}</span>
        <a href="#" class="talkDeleteMessage" data-message-id="{{$message->id}}" title="Delete Message"><i class="fa fa-close"></i></a>
    </div>
    <div class="message other-message float-right">
        {{$message->message}}
    </div>
</li>
