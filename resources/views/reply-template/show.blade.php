@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border"><i class="fa fa-green fa-users"></i>

                <h3 class="box-title">Products assigned to the reply template <em>{{$reply->title}}</em>
                </h3>
            </div>
            <div class="box-body">
                <ul class="user-list">
                    @foreach($thisproducts as $product)
                        <li>
                            <strong>{{$product->name}}</strong>
                            <a href="{{route('template.revoke.product',[$reply->id,$product->id])}}"
                               data-method="put"
                               data-token="{{csrf_token()}}">Remove from {{$reply->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="box box-danger">
            <div class="box-header with-border"><i class="fa fa-red fa-users"></i>

                <h3 class="box-title">Products NOT assigned to the reply template <em>{{$reply->title}}</em>

                </h3>
            </div>
            <div class="box-body">
                <ul class="user-list">
                    @foreach($products as $product)
                        <li>
                            <strong>{{$product->name}}</strong>
                            <a href="{{route('template.assign.product',[$reply->id,$product->id])}}"
                               data-method="put"
                               data-token="{{csrf_token()}}">Assign to {{$reply->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<form id="edit-reply-form" class="white-popup-block mfp-hide"
          action="{{route('super.reply-template.update',$reply->id)}}"
          method="post">
        {{csrf_field()}}
        {{method_field("PUT")}}
        <h4>Edit Reply Template</h4>

        <div class="form-group">
            <input type="text" name="title" id="" class="form-control" placeholder="Title"
                   value="{{$reply->title}}">
        </div>
        <div class="form-group">
            <textarea name="body" placeholder="Body"
                      class="form-control txt-editor">{{$reply->body}}</textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="Update">
    </form>
@endsection
@section('header')

    <h1 class="title"><i class="fa fa-btn fa-key"></i>Reply Template: {{$reply->title}}
        {{--@if($reply->id != 1)--}}
            <small><a class="popup-with-form" href="#edit-reply-form"><i class="fa fa-btn fa-pencil"></i>Edit
                    Reply Template</a>
                <a
                        href="{{route('super.reply-template.destroy',$reply->id)}}" data-token="{{csrf_token()}}"
                        data-method="DELETE" data-confirm="Are You Sure?"><i class="fa fa-btn fa-trash"></i>Delete
                </a>
            </small>
        {{--@else--}}
            {{--<small>This Default Reply Template can't be Modified!</small>--}}
        {{--@endif--}}
    </h1>

@endsection