{!! Form::open(['method'=>'post','route'=>'ticket.store','id'=>'ticket-form']) !!}
<div class="form-group">
    {!! Form::text('username',null,['class'=>'form-control floatlabel', 'placeholder'=>'Your name *']) !!}
</div>
<div class="form-group">
    {!! Form::email('email',null,['class'=>'form-control floatlabel', 'placeholder'=>'Your email address * (won\'t be published)']) !!}
</div>
<div class="form-group">
    {!! Form::select('ticket_category',$ticket_categories,null,['class'=>'form-control','placeholder'=>'Select a category *']) !!}
</div>
<div class="form-group">
    {!! Form::select('product',$products,null,['class'=>'form-control','placeholder'=>'Which Product? *']) !!}
</div>
<div class="form-group">
    {!! Form::text('title',null,['class'=>'form-control floatlabel', 'placeholder'=>'Title/Subject *']) !!}
</div>
<div class="form-group">
    {!! Form::textarea('initial_post',null,['placeholder'=>'Please enter your query/issue here.<br>This section will be <strong>publicly viewable</strong> so don\'t put any private data/link here.<br>You\'ll get a private area for that after submitting this form.','class'=>'txt-editor form-control','rows'=>'4']) !!}
</div>
<div class="form-group">
    {!! Recaptcha::render() !!}
</div>
<input type="submit" class="btn btn-flat btn-primary" value="Create Ticket">
{!! Form::close() !!}