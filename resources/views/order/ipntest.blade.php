@extends('layouts.admin')
@section('content')
    <form action="{{route('payproipn')}}" method="post">
        <div class="form-group col-md-6">{{Form::text('ORDER_ID',$order['id'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('HASH',$order['hash'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('CUSTOMER_FIRST_NAME',$order['first_name'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('CUSTOMER_LAST_NAME',$order['last_name'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('CUSTOMER_EMAIL',$order['email'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('ORDER_STATUS',$order['status'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('ORDER_PLACED_TIME_UTC',$order['datetime'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('ORDER_ITEM_NAME',$order['product_name'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('CUSTOMER_COUNTRY_NAME',$order['country'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('CUSTOMER_COUNTRY_CODE',$order['country_code'],['class'=>'form-control'])}}</div>
        <div class="form-group col-md-6">{{Form::text('PAYMENT_METHOD_NAME',$order['payment_method'],['class'=>'form-control'])}}</div>
        <div class="col-md-12">
            {{Form::submit('Send IPN',['class'=>'btn btn-primary'])}}
        </div>
    </form>
@endsection
@section('header')

    <h1 class="title"><i class="fa fa-btn fa-chain"></i> IPN Test Submit
    </h1>

@endsection