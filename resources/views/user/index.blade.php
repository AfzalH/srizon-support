@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box box-info user-box">
                @include('user.parts.user-box')
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title">Create New User</h3></div>
                <div class="box-body">
                    {!! Form::open(['route'=>'super.user.store']) !!}
                    <div class="form-group">
                        <input type="text" name="name" id="" class="form-control" placeholder="Name"
                               value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="new-email" id="" class="form-control" placeholder="Email"
                               value="{{old('new-email')}}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="new-pass" id="" class="form-control" placeholder="Password"
                               value="{{old('new-pass')}}">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add User">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-users"></i>Manage Users
        <div class="input-group" style="width: 150px; display: inline-block; vertical-align: bottom">
            <input type="text" class="form-control input-sm ajax-filter"
                   data-ajax_target="{{route('user.search')}}"
                   data-output_target=".user-box" name="term" id="user-term" placeholder="search users">
        </div>
    </h1>
@endsection
