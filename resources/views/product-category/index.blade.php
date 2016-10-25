@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Existing Categories</h3></div>
                <div class="box-body">
                    <ul class="role-list sortable-list" data-sorturl="{{route('product-category.sort')}}" data-csrf="{{csrf_token()}}">
                        @foreach($categories as $category)
                            <li data-id="{{$category->id}}">
                                <span class="handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                  </span>
                                <a href="{{route('super.product-category.show',$category->id)}}"><i class="{{$category->icon}}"></i> <strong>{{$category->name}}</strong></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title">Create New Category</h3></div>
                <div class="box-body">
                    {!! Form::open(['route'=>'super.product-category.store']) !!}
                    <div class="form-group">
                        <input type="text" name="name" id="" class="form-control floatlabel" placeholder="Name"
                               value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="icon" id="" class="form-control floatlabel" placeholder="Icon (class names)"
                               value="{{old('icon')}}">
                    </div>
                    <div class="form-group">
                        <textarea name="description" placeholder="Description (optional)" class="form-control"></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Category">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-sitemap"></i>Manage Categories</h1>
@endsection