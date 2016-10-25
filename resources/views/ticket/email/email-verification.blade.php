<html>
<head></head>
<body>
<p><strong>Hello {{$ticket->user->name}},</strong></p>

<p>Thanks for using our support system!<br>
    Find the email verification code below for your ticket: <em>{{$ticket->title}}</em> (#{{$ticket->id}})
    <br>
    Email Verification Code:
<pre>{{$ticket->email_code}}</pre>
</p>
<p>Use this code to verify your email associated with the ticket</p>

<p>----------------------
    <br>Regards,
    <br>Team Srizon
    <br>srizon[dot]com
</p>
</body>
</html>