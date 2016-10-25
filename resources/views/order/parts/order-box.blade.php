<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Product</th>
            <th>User</th>
            <th>Email</th>
        </tr>
        @foreach($orders as $order)
            <tr class='clickable-row' data-href='{{route('super.order.show',$order->id)}}'>
                <td><a href="{{route('super.order.show',$order->id)}}">{{$order->p_id}}</a></td>
                <td>
                    @if($order->status != 'Processed')
                        <span class="label label-danger">{{$order->status}}</span>
                    @else
                        <span class="label label-success">{{$order->status}}</span>
                    @endif
                </td>
                <td>{{$order->product->name}}</td>
                <td><span class="order-img"><img src="{{Gravatar::get($order->email)}}" alt="Avatar"></span> <strong>{{$order->first_name.' '.$order->last_name}}</strong></td>
                <td><em>{{$order->email}}</em></td>
            </tr>
        @endforeach
    </table>
</div>
@if($pagination !== false)
    <div class="box-footer">
        {!! $orders->render() !!}
    </div>
@endif