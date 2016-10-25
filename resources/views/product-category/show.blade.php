@extends('layouts.admin')
@section('content')
    <div class="row">

    </div>

    <form id="edit-category-form" class="white-popup-block mfp-hide"
          action="{{route('super.product-category.update',$category->id)}}"
          method="post">
        {{csrf_field()}}
        {{method_field("PUT")}}
        <h4>Edit Category</h4>

        <div class="form-group">
            <input type="text" name="name" id="" class="form-control" placeholder="Name"
                   value="{{$category->name}}">
        </div>
        <div class="form-group">
            <input type="text" name="icon" id="" class="form-control" placeholder="Icon (class names)"
                   value="{{$category->icon}}">
        </div>
        <div class="form-group">
            <textarea name="description" placeholder="Description (optional)"
                      class="form-control">{{$category->description}}</textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="Update">
    </form>

@endsection

@section('header')

    <h1 class="title"><i class="fa fa-btn fa-key"></i>Product Category: {{$category->name}}
        @if($category->id != 1)
            <small><a class="popup-with-form" href="#edit-category-form"><i class="fa fa-btn fa-pencil"></i>Edit
                    Category</a>
                <a
                        href="{{route('super.product-category.destroy',$category->id)}}" data-token="{{csrf_token()}}"
                        data-method="DELETE" data-confirm="Are You Sure?"><i class="fa fa-btn fa-trash"></i>Delete
                </a>
            </small>
        @else
            <small>Modification disabled for default category 'Others'</small>
        @endif
    </h1>

@endsection