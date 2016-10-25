@extends('layouts.public')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 togglecol">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="header">New</li>
                        {{--<li><button class="btn btn-box-tool toggle-7 toggle-12 hidden-sm hidden-xs"><i class="fa fa-arrows-alt"></i></button></li>--}}
                        <li class="active"><a href="#query-form" data-toggle="tab" aria-expanded="true">Query</a>
                        </li>
                        <li class=""><a href="#download-form" data-toggle="tab" aria-expanded="false">Download</a></li>

                    </ul>
                    <div class="tab-content no-padding">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="query-form">
                            <div class="box-body">
                                @include('parts.ticket-form')
                            </div>
                        </div>
                        <div class="chart tab-pane" id="download-form">
                            <div class="box-body">
                                @include('parts.download-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="nav-tabs-custom box box-widget" id="recent-tickets">
                    <ul class="nav nav-tabs">
                        <li class="header"><i class="fa fa-clock-o"></i>Recent</li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Product <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu product-list-for-ticket ticket-filter">
                                <li role="presentation" class="active"><a role="menuitem" href="#" data-id="0">All
                                        Products</a></li>
                                <li role="presentation" class="divider"></li>
                                @foreach($products as $id => $product)
                                    <li role="presentation"><a role="menuitem" href="#"
                                                               data-id="{{$id}}">{{$product}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Status <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu status-list-for-ticket ticket-filter">
                                <li role="presentation" class="active"><a role="menuitem" href="#" data-id="0">All
                                        Status</a></li>
                                <li role="presentation" class="divider"></li>
                                @foreach($ticketstatuses as $id => $ticketstatus)
                                    <li role="presentation"><a role="menuitem" href="#"
                                                               data-id="{{$id}}">{{$ticketstatus}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <ul class="tickets-list ticket-list-in-box">
                            @include('parts.ticket-list',compact('tickets'))
                        </ul>
                    </div>

                    <div class="box-footer text-center">
                        <a href="{{route('ticket.list')}}">View All Tickets</a>
                    </div>

                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extrascripts')
    @if(env('TEST_MODE',false) != true)
        {!! $validator_script->selector('#ticket-form') !!}
        {!! $validator_script2->selector('#ticket-form-download') !!}
    @endif
@endsection