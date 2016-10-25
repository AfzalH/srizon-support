@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border"><h3 class="box-title">Existing Ticket Statuses</h3></div>
                <div class="box-body">
                    <ul class="role-list sortable-list"  data-sorturl="{{route('ticket-status.sort')}}" data-csrf="{{csrf_token()}}">
                        @foreach($statuses as $status)
                            <li data-id="{{$status->id}}">
                                <span class="handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                  </span>
                                <a href="{{route('super.ticketstatus.show',$status->id)}}"><strong>{{$status->name}}</strong></a>
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
                    {!! Form::open(['route'=>'super.ticketstatus.store']) !!}
                    <div class="form-group">
                        <input type="text" name="name" id="" class="form-control" placeholder="Name *"
                               value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        {!! Form::select('class',['default'=>'Default','primary'=>'Primary','success'=>'Success','info'=>'Info','danger'=>'Danger','warning'=>'Warning'],null,['class'=>'form-control','placeholder'=>'Badge Type *']) !!}
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Ticket Status">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-suitcase"></i>Manage Ticket Status</h1>
@endsection
