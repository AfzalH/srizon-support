<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>User Email</th>
        </tr>
        @foreach($users as $user)
            <tr class='clickable-row' data-href='{{route('super.user.show',$user->id)}}'>
                <td><a href="{{route('super.user.show',$user->id)}}">{{$user->id}}</a></td>
                <td><strong>{{$user->name}}</strong></td>
                <td><em>{{$user->email}}</em></td>
            </tr>
        @endforeach
    </table>
</div>

@if($pagination !== false)
    <div class="box-footer">
        {!! $users->render() !!}
    </div>
@endif

