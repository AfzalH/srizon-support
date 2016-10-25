<div class="white-popup-block clearfix">
    {!! Form::model($post,['method'=>'put','route'=>['ticket.post.update',$post->id],'id'=>'ticket-form-update']) !!}
    <div class="form-group">
        {!! Form::textarea('body',null,['class'=>'txt-editor form-control','id'=>'area-post-update','rows'=>'2']) !!}
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-default btn-flat pull-right" value="Update Post">
    </div>
    {!! Form::close() !!}
</div>