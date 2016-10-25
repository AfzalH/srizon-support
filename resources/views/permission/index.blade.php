@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Existing Permissions</h3></div>
                <div class="box-body">
                    <ul class="permission-list">
                        @foreach($permissions as $permission)
                            <li>
                                <a href="{{route('super.permission.show',$permission->id)}}"><strong>{{$permission->name}}</strong></a>
                                -
                                <small><var>{{$permission->alias}}</var></small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border"><h3 class="box-title">Create New Permission</h3></div>
                <div class="box-body">
                    {!! Form::open(['route'=>'super.permission.store']) !!}
                    <div class="form-group">
                        <input type="text" name="name" id="" class="form-control" placeholder="Name"
                               value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="alias" id="" class="form-control" placeholder="Alias (unique)"
                               value="{{old('alias')}}">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Permission">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-key"></i>Manage Permissions</h1>
@endsection
