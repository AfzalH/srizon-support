@if(!$flags['is_valid_customer'])
    <p>Our Records couldn't find any purchase of <strong>{{$ticket->product->name}}</strong> with the email address:
        <em>{{$ticket->user->email}}</em></p>
    <p>If you've purchased it with another email address, then open another ticket with that email or mention it in
        private section</p>
@elseif(!$flags['ticket_email_verified'])
    @if(\Request::cookie('emailattemptv' . $ticket->id) != '')
        {!! Form::open(['method'=>'PUT','route'=>['ticket.verify.email',$ticket->id]]) !!}
        {!! Form::hidden('ticket_id',$ticket->id) !!}
        <div class="input-group">
            <input type="text" name="code" class="form-control" placeholder="Enter code key here">
                                <span class="input-group-btn">
                                <input type="submit" class="btn btn-info" value="Verify code!">
                                </span>
        </div>
        <br>
        {!! Form::close() !!}
    @endif

    {!! Form::open(['method'=>'PUT','route'=>['ticket.email.verification',$ticket->id]]) !!}
    <p class="email-verification-label">
        @if(\Request::cookie('emailattemptv' . $ticket->id) == 'gmail' or \Request::cookie('emailattemptv' . $ticket->id) == 'mailgun')
            Haven't received an email yet?<br>
            1. Wait a couple of minutes. <br>
            2. Check the inbox as well as spam folder. <br>
            3. Click the button below again. We'll try sending an email from a different server
        @endif
        @if(\Request::cookie('emailattemptv' . $ticket->id) == 'all')
            Haven't received an email yet?<br>
            1. Wait a couple of minutes. <br>
            2. Check the inbox as well as spam folder. <br>
            3. Send an email to <code>{{env('ADMIN_EMAIL')}}</code> directly
        @endif
        @if(\Request::cookie('emailattemptv' . $ticket->id) == '')
            You need to verify your email address in order to see the download links
        @endif
    </p>

    <div class="form-group">
        <input type="submit" class="form-control btn btn-info" value="Email me the verification code">
    </div>
    {!! Form::close() !!}
@else

    <p>Download Links for {{$ticket->product->name}}</p>
    @foreach($ticket->product->downloadlinks as $link)
        <a href="{{route('ticket.download.file',[$ticket->id,$link->id])}}"
           class="btn btn-default btn-block form-control"><span class="fa fa-download"></span>
            Download {{$ticket->product->name}} Version: {{$link->version}}</a>
        <div class="text-center">{!! $link->notes !!}</div>
    @endforeach
@endif