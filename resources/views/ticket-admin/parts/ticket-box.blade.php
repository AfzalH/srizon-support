<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Category</th>
            <th>Product</th>
            <th>User</th>
            <th>Email</th>
        </tr>
        @foreach($tickets as $ticket)
            <tr class='clickable-row' data-href='{{route('ticket.show',$ticket->slug)}}'>
                <td><a href="{{route('ticket.show',$ticket->slug)}}">{{$ticket->id}}</a></td>
                <td>
                    <span class="label label-{{$ticket->ticketstatus->class}}">{{$ticket->ticketstatus->name}}</span>
                </td>
                <td>{{$ticket->ticketcategory->name}}</td>
                <td>{{$ticket->product->name}}</td>
                <td><span class="order-img"><img src="{{Gravatar::get($ticket->user->email)}}" alt="Avatar"></span> <strong>{{$ticket->user->name}}</strong></td>
                <td><em>{{$ticket->user->email}}</em></td>
            </tr>
        @endforeach
    </table>
</div>
@if($pagination !== false)
    <div class="box-footer">
        {!! $tickets->render() !!}
    </div>
@endif