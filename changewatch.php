<?php
exec('git status', $diff);

if ((array_search('Changes not staged for commit:', $diff)
        or array_search('Untracked files:', $diff))
) {
    $email_headers = 'From: support@srizon.com' . "\r\n" .
        'Reply-To: support@srizon.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail('afzal.csedu@gmail.com', 'Notification: Change detected at srizon support', implode("\n",$diff), $email_headers);
    exec('git stash -u',$a);
}
