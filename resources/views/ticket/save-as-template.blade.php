<div class="white-popup-block clearfix">
    {!! Form::model($post,['method'=>'post','route'=>['super.reply-template.store',$post->id],'id'=>'ticket-form-update']) !!}
    <div class="form-group">
        {!! Form::text('title',null,['class'=>'form-control', 'placeholder'=>'Title']) !!}
    </div>
    <div class="form-group">
        {!! Form::textarea('body',null,['class'=>'txt-editor form-control','id'=>'area-post-update','rows'=>'2']) !!}
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-default btn-flat pull-right" value="Save Template">
    </div>
    {!! Form::close() !!}
</div>