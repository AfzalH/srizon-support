@extends('layouts.admin')
@section('content')
    <div class="row">

    </div>

    {!! Form::model($order,['route'=>['super.order.update',$order->id],'class'=>'white-popup-block mfp-hide','method'=>'PUT','id'=>'edit-order-form']) !!}

        <h4>Edit Order Details</h4>

        <div class="form-group">
            {!! Form::text('p_id',null,['class'=>"form-control floatlabel",'placeholder'=>'Purchase/Order ID']) !!}
        </div>
        <div class="form-group">
            {!! Form::select('product_id',$products,old('product_id'),['class'=>'form-control','placeholder'=>'Select Product']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('email',null,['class'=>"form-control floatlabel",'placeholder'=>'Email']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('first_name',null,['class'=>"form-control floatlabel",'placeholder'=>'First name']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('last_name',null,['class'=>"form-control floatlabel",'placeholder'=>'Last name']) !!}
        </div>
        <div class="form-group">
            {!! Form::select('status',['Processed'=>'Processed','Refunded'=>'Refunded','Chargeback'=>'Chargeback'],old('status'),['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::select('payment_method',['PayPal'=>'PayPal','Visa'=>'Visa','MasterCard'=>'MasterCard','Amex'=>'Amex','Discover'=>'Discover'],old('payment_method'),['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::select('country',$countries,null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('p_date',null,['class'=>'form-control']) !!}
        </div>
        <input type="submit" class="btn btn-primary" value="Update Order">

    {!! Form::close() !!}
@endsection

@section('header')

    <h1 class="title"><i class="fa fa-btn fa-shopping-cart"></i>Order #: {{$order->p_id}}
        <small><a class="popup-with-form" href="#edit-order-form"><i class="fa fa-btn fa-pencil"></i>Edit
                Order</a>
            <a
                    href="{{route('super.order.destroy',$order->id)}}" data-token="{{csrf_token()}}"
                    data-method="DELETE" data-confirm="Are You Sure?"><i class="fa fa-btn fa-trash"></i>Delete
            </a>
        </small>
    </h1>

@endsection