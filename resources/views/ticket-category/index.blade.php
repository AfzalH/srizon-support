@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Existing Ticket Statuses</h3></div>
                <div class="box-body">
                    <ul class="role-list sortable-list"  data-sorturl="{{route('ticket-category.sort')}}" data-csrf="{{csrf_token()}}">
                        @foreach($categories as $category)
                            <li data-id="{{$category->id}}">
                                <span class="handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                  </span>
                                <a href="{{route('super.ticketcategory.show',$category->id)}}"><strong>{{$category->name}}</strong></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title">Create New Ticket Status</h3></div>
                <div class="box-body">
                    {!! Form::open(['route'=>'super.ticketcategory.store']) !!}
                    <div class="form-group">
                        <input type="text" name="name" id="" class="form-control" placeholder="Name *"
                               value="{{old('name')}}">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Ticket Category">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-suitcase"></i>Manage Ticket Category</h1>
@endsection
