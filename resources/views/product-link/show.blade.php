@extends('layouts.admin')
@section('content')
    <div class="row">

    </div>

    <form id="edit-category-form" class="white-popup-block mfp-hide"
          action="{{route('super.productlink.update',$link->id)}}"
          method="post"
          enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field("PUT")}}
        <h4>Edit Download Link</h4>

        <div class="form-group">
            {!! Form::select('product',$products,$link->product->id,['class'=>'form-control','placeholder'=>'Select Product']) !!}
        </div>
        <div class="form-group">
            <input type="text" name="version" id="" class="form-control floatlabel"
                   placeholder="Version number" value="{{$link->version}}">
        </div>
        <div class="form-group">
            <label for="thefile">File for Download <small>(Current: {{$link->filename}})</small></label>
            {!! Form::file('thefile',['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
                        <textarea class="form-control txt-editor" name="notes" id="" cols="30" rows="2"
                                  placeholder="Notes">{{$link->notes}}</textarea>
        </div>
        <input type="submit" class="btn btn-primary" value="Update">
    </form>

@endsection

@section('header')

    <h1 class="title"><i class="fa fa-btn fa-key"></i>Product Link: {{$link->product->name.' '.$link->version}}
        <small><a class="popup-with-form" href="#edit-category-form"><i class="fa fa-btn fa-pencil"></i>Edit
                Link</a>
            <a
                    href="{{route('super.productlink.destroy',$link->id)}}" data-token="{{csrf_token()}}"
                    data-method="DELETE" data-confirm="Are You Sure?"><i class="fa fa-btn fa-trash"></i>Delete
            </a>
        </small>
    </h1>

@endsection