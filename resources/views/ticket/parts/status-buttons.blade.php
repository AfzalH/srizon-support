<div class="status-container"
     data-csrf="{{csrf_token()}}"
     data-ajaxurl="{{route('ticket.status.update')}}"
     data-ticketid="{{$ticket->id}}">
    <strong>Status: </strong>
    @foreach($ticketstatus as $status)
        @if($status->id != env('TICKET_STATUS_NEW_ID'))
            <span data-statusid="{{$status->id}}"
                  class="statuschange badge label-{{$status->class}} {{($status->id == $ticket->ticketstatus->id)?'active':''}}">{{$status->name}}</span>
        @endif
    @endforeach
</div>