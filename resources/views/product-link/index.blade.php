@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Product Download Links</h3></div>
                <div class="box-body">
                    <ul class="role-list sortable-list" data-sorturl="{{route('product-link.sort')}}"
                        data-csrf="{{csrf_token()}}">
                        @foreach($links as $link)
                            <li data-id="{{$link->id}}">
                <span class="handle">
                <i class="fa fa-ellipsis-v"></i>
                <i class="fa fa-ellipsis-v"></i>
                </span>
                                <a href="{{route('super.productlink.show',$link->id)}}"><i
                                            class=""></i> <strong>{{$link->product->name.' '.$link->version}}</strong></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title">Add new link</h3></div>
                <div class="box-body">
                    {!! Form::open(['route'=>'super.productlink.store','files'=>true]) !!}
                    <div class="form-group">
                        {!! Form::select('product',$products,old('product'),['class'=>'form-control','placeholder'=>'Select Product']) !!}
                    </div>
                    <div class="form-group">
                        <input type="text" name="version" id="" class="form-control floatlabel"
                               placeholder="Version number" value="{{old('version')}}">
                    </div>
                    <div class="form-group">
                        <label for="thefile">File for Download</label>
                        {!! Form::file('thefile',['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <textarea class="form-control txt-editor" name="notes" id="" cols="30" rows="2"
                                  placeholder="Notes">{{old('notes')}}</textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Download Link">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-sitemap"></i>Manage Download Links</h1>
@endsection