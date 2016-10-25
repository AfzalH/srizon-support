@extends('layouts.admin')
@section('content')
    <form id="edit-status-form" class="white-popup-block mfp-hide"
          action="{{route('super.ticketstatus.update',$status->id)}}"
          method="post">
        {{csrf_field()}}
        {{method_field("PUT")}}
        <h4>Edit Ticket Status</h4>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="" class="form-control" placeholder="Name"
                   value="{{$status->name}}">
        </div>

        <div class="form-group">
            <label for="class">Badge Type</label>
            {!! Form::select('class',['default'=>'Default','primary'=>'Primary','success'=>'Success','info'=>'Info','danger'=>'Danger','warning'=>'Warning'],$status->class,['class'=>'form-control']) !!}
        </div>

        <input type="submit" class="btn btn-primary" value="Update">
    </form>
@endsection
@section('header')

    <h1 class="title"><i class="fa fa-btn fa-key"></i>Ticket Status: {{$status->name}}
        <small><a class="popup-with-form" href="#edit-status-form"><i class="fa fa-btn fa-pencil"></i>Edit
                Status</a>
            @if(false)
                <a
                        href="{{route('super.ticketstatus.destroy',$status->id)}}" data-token="{{csrf_token()}}"
                        data-method="DELETE" data-confirm="Are You Sure?"><i class="fa fa-btn fa-trash"></i>Delete
                </a>
            @endif
        </small>
    </h1>

@endsection