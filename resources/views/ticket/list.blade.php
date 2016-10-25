@extends('layouts.public')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default ticket-box">
                    <div class="box-header with-border">
                        @if(isset($q) and trim($q))
                            <h3 class="box-title">Ticket Search Results for <em>{{$q}}</em> (Total: <strong>{{$tickets->total()}}</strong>)</h3>
                        @else
                            <h3 class="box-title">All Tickets</h3>
                        @endif
                    </div>
                    @include('ticket.parts.ticket-box')
                </div>
            </div>
        </div>
    </div>
@endsection
