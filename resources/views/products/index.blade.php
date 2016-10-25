@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Existing Products</h3></div>
                <div class="box-body">
                    <ul class="role-list sortable-list" data-sorturl="{{route('product.sort')}}"
                        data-csrf="{{csrf_token()}}">
                        @foreach($products as $product)
                            <li data-id="{{$product->id}}">
                         <span class="handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                          </span>
                                <a href="{{route('super.products.show',$product->id)}}"><i
                                            class="{{$product->icon}}"></i> <strong>{{$product->name}}</strong></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title">Create New Product</h3></div>
                <div class="box-body">
                    {!! Form::open(['route'=>'super.products.store']) !!}
                    <div class="form-group">
                        <input type="text" name="name" id="" class="form-control" placeholder="Name"
                               value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="paypro_name" placeholder="PayPro Name" value="{{old('paypro_name')}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="description_url" placeholder="Description url"
                               value="{{old('description_url')}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="docs_url" placeholder="Doc link" value="{{old('docs_url')}}"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="demo_url" placeholder="Demo url" value="{{old('demo_url')}}"
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <input type="text" name="purchase_url" placeholder="Download url with version"
                               value="{{old('purchase_url')}}" class="form-control">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Product">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-sitemap"></i>Manage Products</h1>
@endsection