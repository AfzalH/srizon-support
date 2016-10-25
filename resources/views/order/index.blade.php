@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info order-box">
                @include('order.parts.order-box')
            </div>
        </div>
    </div>

    {!! Form::open(['route'=>'super.order.store','id'=>'new-order-form','class'=>'white-popup-block mfp-hide']) !!}
    <h4>Create New Order</h4>

    <div class="form-group">
        <input type="text" name="p_id" id="" class="form-control floatlabel"
               placeholder="Purchase/Order ID"
               value="{{old('p_id')}}">
    </div>
    <div class="form-group">
        {!! Form::select('product_id',$products,old('product_id'),['class'=>'form-control','placeholder'=>'Select Product']) !!}
    </div>
    <div class="form-group">
        <input type="email" name="email" id="" class="form-control floatlabel" placeholder="Email"
               value="{{old('email')}}">
    </div>
    <div class="form-group">
        <input type="text" name="first_name" id="" class="form-control floatlabel"
               placeholder="First name"
               value="{{old('first_name')}}">
    </div>
    <div class="form-group">
        <input type="text" name="last_name" id="" class="form-control floatlabel"
               placeholder="Last name"
               value="{{old('last_name')}}">
    </div>
    <div class="form-group">
        {!! Form::select('status',['Processed'=>'Processed','Refunded'=>'Refunded','Chargeback'=>'Chargeback'],old('status'),['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('payment_method',['PayPal'=>'PayPal','Visa'=>'Visa','MasterCard'=>'MasterCard','Amex'=>'Amex','Discover'=>'Discover'],old('payment_method'),['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('country',$countries,old('country'),['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::date('p_date',old('p_date'),['class'=>'form-control']) !!}
    </div>
    <input type="submit" class="btn btn-primary" value="Add Order">
    {!! Form::close() !!}

@endsection
@section('header')
    <h1 class="title">
        <a class="popup-with-form btn btn-sm btn-success" href="#new-order-form"><i class="fa fa-plus"></i>New</a>
        Orders
        <div class="input-group" style="width: 150px; display: inline-block; vertical-align: bottom">
            <input type="text" class="form-control input-sm ajax-filter"
                   data-ajax_target="{{route('order.search')}}"
                   data-output_target=".order-box" name="term" id="order-term" placeholder="search orders">
        </div>
    </h1>
@endsection
