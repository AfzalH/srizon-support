@extends('layouts.admin')
@section('content')
    <form id="edit-ticketcategory-form" class="white-popup-block mfp-hide"
          action="{{route('super.ticketcategory.update',$category->id)}}"
          method="post">
        {{csrf_field()}}
        {{method_field("PUT")}}
        <h4>Edit Ticket Status</h4>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="" class="form-control" placeholder="Name"
                   value="{{$category->name}}">
        </div>

        <input type="submit" class="btn btn-primary" value="Update">
    </form>
@endsection
@section('header')

    <h1 class="title"><i class="fa fa-btn fa-key"></i>Category: {{$category->name}}
        <small><a class="popup-with-form" href="#edit-ticketcategory-form"><i class="fa fa-btn fa-pencil"></i>Edit
                Status</a>
            <a
                    href="{{route('super.ticketcategory.destroy',$category->id)}}" data-token="{{csrf_token()}}"
                    data-method="DELETE" data-confirm="Are You Sure?"><i class="fa fa-btn fa-trash"></i>Delete
            </a>
        </small>
    </h1>

@endsection