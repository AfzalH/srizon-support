@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info ticket-box">
                @include('ticket-admin.parts.ticket-box')
            </div>
        </div>
    </div>

@endsection
@section('header')
    @if(isset($dashboard) && $dashboard)
        <h1 class="title">
            Tickets with <em>New</em> and <em>Open</em> status:
        </h1>
    @else
        <h1 class="title">
            Tickets
            <div class="input-group" style="width: 150px; display: inline-block; vertical-align: bottom">
                <input type="text" class="form-control input-sm ajax-filter"
                       data-ajax_target="{{route('ticket.search')}}"
                       data-output_target=".ticket-box" name="term" id="ticket-term" placeholder="search tickets">
            </div>
        </h1>
    @endif
@endsection
