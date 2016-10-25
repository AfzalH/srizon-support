<div class="white-popup-block clearfix">
    @foreach($templates as $template)
        <div class="clearfix margin-bottom">
            <h4>{{$template->title}}</h4>
            {!! Form::open(['method'=>'post','route'=>['ticket-post.store'],'id'=>'ticket-form-update'.$template->id]) !!}
            {!! Form::hidden('ticket_id',$ticket->id) !!}
            {!! Form::hidden('secrecy',$secrecy) !!}
            <div class="form-group">
                {!! Form::textarea('postbody',$template->body,['class'=>'txt-editor form-control','id'=>'area-post-update'.$template->id,'rows'=>'2']) !!}
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default btn-flat pull-right" value="Post This Reply">
            </div>
            {!! Form::close() !!}
        </div>
    @endforeach
</div>
