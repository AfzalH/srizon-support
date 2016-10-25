<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tr>
            <th width="25%">User</th>
            <th width="25%">Product / Category</th>
            <th width="40%">Ticket Title</th>
            <th width="10%"><span class="pull-right">Status</span></th>
        </tr>
        @foreach($tickets as $ticket)
            <tr class='clickable-row vcenter' data-href='{{route('ticket.show',$ticket->slug)}}'>
                <td><span class="result-img"><img src="{{Gravatar::get($ticket->user->email)}}" alt="Avatar"></span>
                    <strong>{{$ticket->user->name}}</strong>
                </td>
                <td>{{$ticket->product->name}} / {{$ticket->ticketcategory->name}}</td>
                <td>
                    <a href="{{route('ticket.show',$ticket->slug)}}">{{$ticket->title}}</a>
                    <br><em><small>Updated: {{$ticket->updated_at->diffForHumans()}}</small></em>
                </td>
                <td>
                    <span class="label pull-right label-{{$ticket->ticketstatus->class}}">{{$ticket->ticketstatus->name}}</span>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@if($pagination !== false)
    <div class="box-footer">
        @if(isset($q) and trim($q))
            {!! $tickets->appends(['q'=>$q])->render() !!}
        @else
            {!! $tickets->render() !!}
        @endif
    </div>
@endif