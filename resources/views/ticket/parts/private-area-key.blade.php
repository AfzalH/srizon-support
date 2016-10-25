@if(!($flags['is_creator'] or \Gate::allows('support')))
    <h4>Verify ownership of this ticket by providing the secret key for this ticket to view this
        area and add post/data to this ticket</h4>
    {!! Form::open(['method'=>'POST','route'=>'ticketsecret']) !!}
    {!! Form::hidden('ticket_id',$ticket->id) !!}
    <div class="input-group verify-secret">
        <div class="input-group-btn">
            <button type="button" class="btn btn-success"><i class="fa fa-key"></i>
            </button>
        </div>
        <input type="text" name="secret" class="form-control" placeholder="Enter secret key here">
                                <span class="input-group-btn">
                                <input type="submit" class="btn btn-info" value="Verify Secret!">
                                </span>
    </div>
    {!! Form::close() !!}

    {!! Form::open(['method'=>'PUT','route'=>['ticket.emailsecret',$ticket->id]]) !!}
    {!! Form::hidden('ticket_id',$ticket->id) !!}
    <p class="secret-recovery-label">
        @if(\Request::cookie('emailattempt' . $ticket->id) == 'gmail' or \Request::cookie('emailattempt' . $ticket->id) == 'mailgun')
            Haven't received an email yet?<br>
            1. Wait a couple of minutes. <br>
            2. Check the inbox as well as spam folder. <br>
            3. Click the button below again. We'll try sending an email from a different server
        @endif
        @if(\Request::cookie('emailattempt' . $ticket->id) == 'all')
            Haven't received an email yet?<br>
            1. Wait a couple of minutes. <br>
            2. Check the inbox as well as spam folder. <br>
            3. Send an email to <code>{{env('ADMIN_EMAIL')}}</code> directly
        @endif
        @if(\Request::cookie('emailattempt' . $ticket->id) == '')
            <span id="forgot-key-button">Forgot the key?</span>
        @endif
    </p>

    <div id="emailattempt" class="input-group @if(\Request::cookie('emailattempt' . $ticket->id) == '') hidden @endif">
        <input id="inputemail" type="email" name="email" class="form-control"
               placeholder="Email address that you used to open this ticket" value="{{old('email')}}">
        <span class="input-group-btn">
            <input type="submit" class="btn btn-info" value="Email the key">
        </span>
    </div>
    {!! Form::close() !!}
@else
    @if(\Gate::allows('support') or $ticket->ticketstatus_id!=env('TICKET_STATUS_CLOSED'))
        @include('ticket.parts.post-form-private')
    @endif
    <div class="direct-chat-messages ticket-messages">
        @include('ticket.parts.ticket-messages-private')
    </div>
@endif