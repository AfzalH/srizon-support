{!! Form::open(['method'=>'post','route'=>'ticket.store.download','id'=>'ticket-form-download']) !!}
<div class="form-group">
    {!! Form::select('product',$downloadable_products ,null,['class'=>'form-control','placeholder'=>'Which Downloadable Product? *']) !!}
</div>
<div class="form-group">
    {!! Form::email('email',null,['class'=>'form-control floatlabel', 'placeholder'=>'Email address used while purchasing *']) !!}
</div>
<input type="submit" class="btn btn-flat btn-primary" value="Request Download">
{!! Form::close() !!}