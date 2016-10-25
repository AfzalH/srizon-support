@foreach($ticket->ticketposts as $post)
    @if($post->secrecy != 'secret')
        <div class="direct-chat-msg{{($ticket->user_id == $post->user_id)? '':' right'}}">
            <div class="direct-chat-info clearfix">
            <span class="direct-chat-name {{($ticket->user_id == $post->user_id)? 'pull-left':'pull-right'}}">
                {{$post->user->name}} {!! ($ticket->user_id == $post->user_id)? '':' <small>(Support)</small>' !!}</span>
            <span class="direct-chat-timestamp {{($ticket->user_id == $post->user_id)? 'pull-right':'pull-left'}}">
                {{$post->created_at->diffForHumans()}}
                @if($post->updated_at->diffInSeconds($post->created_at) > 2)
                    - <em>
                        @if(Gate::allows('support'))
                            <a class="ajax-popup-link" href="{{route('ticket.post.history',$post->id)}}">Edited:</a>
                        @else
                            Edited:
                        @endif
                        {{$post->updated_at->diffForHumans()}}</em>
                @endif
            </span>
            </div>
            <img class="direct-chat-img" src="{{Gravatar::get($post->user->email)}}" alt="{{$post->user->name}} avatar">

            <div class="direct-chat-text @if(($flags['is_creator'] and ($ticket->user_id == $post->user_id) and $ticket->ticketstatus_id!=env('TICKET_STATUS_CLOSED')) or Gate::allows('support')) toppadding @endif">
                @if($flags['is_creator'] or Gate::allows('support'))
                    <div class="clearfix">
                        {!! $post->body !!}
                    </div>
                @else
                    <div class="clearfix">
                        {!! remove_href_from_a($post->body) !!}
                    </div>
                @endif
                @if(($flags['is_creator'] and ($ticket->user_id == $post->user_id) and $ticket->ticketstatus_id!=env('TICKET_STATUS_CLOSED')) or Gate::allows('support'))
                    <div class="post-edit-button">
                        @if(Gate::allows('support') and $ticket->user_id != $post->user_id)
                            <a href="{{route('ticket.post.as.template',$post->id)}}"
                               class="badge label-primary ajax-popup-link"><i
                                        class="fa fa-star"></i> Save as Template</a>
                        @endif
                        <a href="{{route('post.switch.secrecy',$post->id)}}"
                           class="badge label-success"
                           data-method="PUT"
                           data-token="{{csrf_token()}}"><i class="fa fa-lock"></i> Make
                            Private</a>
                        <a href="{{route('ticket.post.edit',$post->id)}}" class="badge label-info ajax-popup-link"><i
                                    class="fa fa-pencil"></i> Edit Post</a>

                    </div>
                @endif
            </div>

        </div>
    @endif
@endforeach



