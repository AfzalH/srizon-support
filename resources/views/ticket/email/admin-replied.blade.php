<html>
<head></head>
<body>
<p><strong>Hello {{$ticket->user->name}},</strong></p>

<p>Thanks for using our support system!<br>
    Our support staff replied to your Ticket: <em>{{$ticket->title}}</em> (#{{$ticket->id}})
</p>
<p>Do not reply to this message. Go to the support system and find your ticket.</p>

<p>----------------------
    <br>Regards,
    <br>Team Srizon
    <br>srizon[dot]com
</p>
</body>
</html>