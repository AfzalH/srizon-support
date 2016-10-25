@extends('layouts.public')
@section('header')
    <div class="container">
        <h3>{{$ticket->title}}
            @if(Gate::denies('support'))
                <span class="badge label-{{$ticket->ticketstatus->class}}">{{$ticket->ticketstatus->name}}</span>
            @else
                <a class="btn btn-sm btn-default btn-flat popup-with-form" href="#ticket-form"><i
                            class="fa fa-pencil"></i> Edit Ticket Info</a>

                {!! Form::model($ticket,['method'=>'put','route'=>['ticket.update',$ticket->id],'id'=>'ticket-form','class'=>'white-popup-block mfp-hide']) !!}
                <div class="form-group">
                    {!! Form::text('username',$ticket->user->name,['class'=>'form-control floatlabel', 'placeholder'=>'Name *']) !!}
                </div>
                <div class="form-group">
                    {!! Form::email('email',$ticket->user->email,['class'=>'form-control floatlabel', 'placeholder'=>'Email address * (won\'t be published)']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('title',null,['class'=>'form-control floatlabel', 'placeholder'=>'Title/Subject *']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('ticketcategory_id',$ticket_categories,null,['class'=>'form-control','placeholder'=>'Category *']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('product_id',$products,null,['class'=>'form-control','placeholder'=>'Product *']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('ticketstatus_id',$ticketstatuses,null,['class'=>'form-control','placeholder'=>'Status *']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('secret',null,['class'=>'form-control floatlabel', 'placeholder'=>'Secret *']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('email_code',null,['class'=>'form-control floatlabel', 'placeholder'=>'Email Code *']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('email_verified',array(0=>'No',1=>'Yes'),null,['class'=>'form-control','placeholder'=>'Email Verified? *']) !!}
                </div>
                <input type="submit" class="btn btn-flat btn-primary" value="Update Ticket Info">
                {!! Form::close() !!}
            @endif<br>
            <small>Product: <strong>{{$ticket->product->name}}</strong> - Category:
                <strong>{{$ticket->ticketcategory->name}}</strong> - Ticket #{{$ticket->id}}
            </small>
        </h3>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7 togglecol" id="public-column">
                @if($flags['is_creator'])
                    @if(session('justcreated') == 'yes')
                        @include('ticket.parts.first-message')
                    @endif
                @endif
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><span class="fa fa-files-o"></span> Ticket Posts (publicly viewable)</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool toggle-7 toggle-12 hidden-sm hidden-xs"><i
                                        class="fa fa-arrows-alt"></i></button>
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(($flags['is_creator'] and $ticket->ticketstatus_id!=env('TICKET_STATUS_CLOSED')) or \Gate::allows('support'))
                            @include('ticket.parts.post-form')
                            <div class="direct-chat-messages ticket-messages">
                                @include('ticket.parts.ticket-messages')
                            </div>
                        @else
                            @if($ticket->ticketstatus_id != env('TICKET_STATUS_NEW_MODERATED_ID'))
                                <div class="direct-chat-messages ticket-messages">
                                    @include('ticket.parts.ticket-messages')
                                </div>
                            @else
                                <h3>This ticket is under moderation. For the time being, the public posts are visible
                                    only to the creator and the support staff. Posts will be made public after a support
                                    staff reviews it.</h3>
                                <h4>Ticket may go into moderation for on of the following reason</h4>
                                <ul>
                                    <li>User who created the ticket was not found in customer database</li>
                                    {{--<li>User Posted some links in the public posts</li>--}}
                                    <li>Support staff marked it as moderated temporarily</li>
                                </ul>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5 togglecol" id="private-column">
                @if(Gate::allows('support'))
                    <div class="box box-info">
                        <div class="box-body">
                            @include('ticket.parts.status-buttons')
                        </div>
                    </div>
                @endif
                @if(($flags['is_creator'] or \Gate::allows('support')) and $ticket->product->downloadlinks->count()>0 and $ticket->ticketcategory_id == env('DOWNLOAD_CAT_ID',7))
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><span class="fa fa-download"></span> Download Section</h3>

                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            @include('ticket.parts.download')
                        </div>
                    </div>
                @endif
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><span class="fa fa-red fa-lock"></span> Private Posts Section</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool toggle-5 toggle-12 hidden-sm hidden-xs"><i
                                        class="fa fa-arrows-alt"></i></button>
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('ticket.parts.private-area-key')
                    </div>
                </div>

                @if(($flags['is_creator'] or \Gate::allows('support')) and $ticket->product->downloadlinks->count()>0 and $ticket->ticketcategory_id != env('DOWNLOAD_CAT_ID',7))
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><span class="fa fa-download"></span> Download Section</h3>

                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            @include('ticket.parts.download')
                        </div>
                    </div>
                @endif

                @if(($flags['is_creator'] or \Gate::allows('support')) and session('justcreated') != 'yes')
                    <div class="box box-warning collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><span class="fa fa-key"></span> Secret Key</h3>

                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-warning" disabled="disabled"><i
                                                class="fa fa-key"></i> Secret
                                        Key
                                    </button>
                                </div>
                                <input size="15" type="text" class="form-control" value="{{$ticket->secret}}">
                            </div>
                            <br>

                            <p><i class="fa fa-warning"></i> <strong>Copy and Save the Key.</strong> You may need it
                                to identify yourself as the Ticket Owner</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection