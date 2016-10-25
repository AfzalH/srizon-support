<html>
<head></head>
<body>
<p><strong>Hello {{$ticket->user->name}},</strong></p>

<p>Thanks for using our support system!<br>
    Find the secret key below for your ticket: <em>{{$ticket->title}}</em> (#{{$ticket->id}})
    <br>
    Secret:
<pre>{{$ticket->email_code}}</pre>
</p>
<p>Use this secret key to verify your ownership of the ticket</p>

<p>----------------------
    <br>Regards,
    <br>Team Srizon
    <br>srizon[dot]com
</p>
</body>
</html>