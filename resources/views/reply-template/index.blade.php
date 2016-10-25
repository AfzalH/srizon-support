@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title">Templates to reply</h3></div>
            <div class="box-body">
                <ul class="role-list">
                 @foreach($reply as $reply)
                    <li>
                        <a href="{{route('super.reply-template.show',$reply->id)}}"><strong>{{$reply->title}}</strong></a>
                    </li>
                 @endforeach
                </ul>
            </div>
        </div>
    </div>
<div class="col-md-7">
    <div class="box box-success">
        <div class="box-header with-border"><h3 class="box-title">Create New Reply-Template</h3></div>
        <div class="box-body pad">
            {!! Form::open(['route'=>'super.reply-template.store']) !!}
            <div class="form-group">
                <input type="text" name="title" id="" class="form-control" placeholder="Title"
                       value="{{old('title')}}">
                       <div class="pull-right box-tools"></div>
            </div>
            <div class="form-group">
                <textarea name="body" placeholder="Place your text here" class="form-control txt-editor">{{old('body')}}</textarea>
                {{--<textarea name="body" class="form-control textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>--}}
            </div>
            <input type="submit" class="btn btn-primary" value="Add Reply Template">
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
@endsection
@section('header')
    <h1 class="title"><i class="fa fa-sitemap"></i>Manage Reply Templates</h1>
@endsection