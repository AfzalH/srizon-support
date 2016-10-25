@foreach($tickets as $ticket)
    <li class="item clickable-row" data-href='{{route('ticket.show',$ticket->slug)}}'>
        <div class="ticket-img">
            <img src="{{\Gravatar::get($ticket->user->email)}}"
                 alt="{{$ticket->user->name}}">
        </div>
        <div class="ticket-info">
            <span class="ticket-user">{{$ticket->user->name}}</span>
            <span class="label label-{{$ticket->ticketstatus->class}} pull-right">{{$ticket->ticketstatus->name}}</span>
            <small class="ticket-time">Updated {{$ticket->updated_at->diffForHumans()}}</small>
            <a href="{{route('ticket.show',$ticket->slug)}}"><span class="ticket-title"><strong>{{$ticket->product->name}}</strong> : {{$ticket->title}}</span></a>
        </div>
    </li>
@endforeach