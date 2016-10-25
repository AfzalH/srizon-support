<div class="ticket-post-form clearfix">
    {!! Form::open(['method'=>'post','route'=>'ticket-post.store','id'=>'ticket-form-private']) !!}
    <div class="form-group">
        {!! Form::textarea('postbody',null,['placeholder'=>'Add new <em>private</em> post to this ticket','class'=>'txt-editor form-control','id'=>'area-private','rows'=>'2']) !!}
    </div>
    <div class="form-group">
        {!! Form::hidden('ticket_id',$ticket->id) !!}
        {!! Form::hidden('secrecy','secret') !!}
        @can('support')
        <a href="{{route('reply.from.template',[$ticket->id,'secret'])}}"
           class="badge label-default ajax-popup-link"><i
                    class="fa fa-reply"></i> Reply From Template</a>
        @endcan
        <input type="submit" class="btn btn-flat btn-default pull-right" value="Add Private Post">
    </div>
    {!! Form::close() !!}
</div>