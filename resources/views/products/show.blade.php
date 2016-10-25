@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><i class="fa fa-green fa-users"></i>

                    <h3 class="box-title">{{$product->name}} with Category
                    </h3>
                </div>
                <div class="box-body">
                    <ul class="user-list">
                        @foreach($thiscategory as $category)
                            <li>
                                <strong>{{$category->name}}</strong>
                                <a href="{{route('products.category.revoke',[$product->id,$category->id])}}"
                                   data-method="put"
                                   data-token="{{csrf_token()}}">Revoke from {{$product->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="box box-danger">
                <div class="box-header with-border"><i class="fa fa-red fa-users"></i>

                    <h3 class="box-title">{{$product->name}} without Category

                    </h3>
                </div>
                <div class="box-body">
                    <ul class="user-list">
                        @foreach($categories as $category)
                            <li>
                                <strong>{{$category->name}}</strong>
                                <a href="{{route('products.category.assign',[$product->id,$category->id])}}"
                                   data-method="put"
                                   data-token="{{csrf_token()}}">Assign to {{$product->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><i class="fa fa-green fa-plug"></i>

                    <h3 class="box-title">{{$product->name}} with Reply Template </h3>
                </div>
                <div class="box-body">
                    <ul class="user-list">
                        @foreach($thisreply as $reply)
                            <li>
                                <strong>{{$reply->title}}</strong>
                                <a href="{{route('product.replytemplate.revoke',[$product->id,$reply->id])}}"
                                   data-method="put"
                                   data-token="{{csrf_token()}}">Revoke from {{$product->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="box box-danger">
                <div class="box-header with-border"><i class="fa fa-red fa-plug"></i>

                    <h3 class="box-title">{{$product->name}} without Reply Template</h3>
                </div>
                <div class="box-body">
                    <ul class="user-list">
                        @foreach($replies as $reply)
                            <li>
                                <strong>{{$reply->title}}</strong>
                                <a href="{{route('product.replytemplate.assign',[$product->id,$reply->id])}}"
                                   data-method="put"
                                   data-token="{{csrf_token()}}">Assign to {{$product->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <form id="edit-product-form" class="white-popup-block mfp-hide"
          action="{{route('super.products.update',$product->id)}}"
          method="post">
        {{csrf_field()}}
        {{method_field("PUT")}}
        <h4>Edit Product</h4>

        <div class="form-group">
            <input type="text" name="name" id="" class="form-control" placeholder="Name"
                   value="{{$product->name}}">
        </div>
        <div class="form-group">
            <input type="text" name="paypro_name" placeholder="PayPro Name" value="{{$product->paypro_name}}"
                   class="form-control">
        </div>
        <div class="form-group">
            <input type="text" name="description_url" placeholder="Description URL"
                   value="{{$product->description_url}}" class="form-control">
        </div>
        <div class="form-group">
            <input type="text" name="docs_url" placeholder="Documentation URL" value="{{$product->docs_url}}"
                   class="form-control">
        </div>
        <div class="form-group">
            <input type="text" name="demo_url" placeholder="Demo URL" value="{{$product->demo_url}}"
                   class="form-control">
        </div>
        <div class="form-group">
            <input type="text" name="purchase_url" placeholder="Purchase URL"
                   value="{{$product->purchase_url}}" class="form-control">
        </div>
        <input type="submit" class="btn btn-primary" value="Update">
    </form>
@endsection



@section('header')
    <h1 class="title"><i class="fa fa-btn fa-key"></i>Product:
        <small><a class="popup-with-form" href="#edit-product-form"><i class="fa fa-btn fa-pencil"></i>Edit
                Product</a>
            <a
                    href="{{route('super.products.destroy',$product->id)}}" data-token="{{csrf_token()}}"
                    data-method="DELETE" data-confirm="Are You Sure?"><i class="fa fa-btn fa-trash"></i>Delete
            </a>
        </small>
    </h1>
@endsection