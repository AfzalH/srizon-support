<div class="ticket-post-form clearfix">
    {!! Form::open(['method'=>'post','route'=>'ticket-post.store','id'=>'ticket-form']) !!}
    <div class="form-group">
        {!! Form::textarea('postbody',null,['placeholder'=>'Add new post to this ticket','class'=>'txt-editor form-control','id'=>'area-public','rows'=>'2']) !!}
    </div>
    <div class="form-group">
        {!! Form::hidden('ticket_id',$ticket->id) !!}
        {!! Form::hidden('secrecy','public') !!}
        @can('support')
            <a href="{{route('reply.from.template',[$ticket->id,'public'])}}"
               class="badge label-default ajax-popup-link"><i
                        class="fa fa-reply"></i> Reply From Template</a>
        @endcan
        <input type="submit" class="btn btn-default btn-flat pull-right" value="Add Post">
    </div>
    {!! Form::close() !!}
</div>