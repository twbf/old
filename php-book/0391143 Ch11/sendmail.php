<?php
$to_address = $_POST['to_address'];
$from_address = $_POST['from_address'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$boundary = '==MP_Bound_xyccr948x==';

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: multipart/alternative; boundary="' . $boundary . '"';
$headers[] = 'From: ' . $from_address;

$msg_body = 'This is a Multipart Message in MIME format.' . "\n";
$msg_body .= '--' . $boundary . "\n";
$msg_body .= 'Content-type: text/html; charset="iso-8859-1"' . "\n";
$msg_body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$msg_body .= $message . "\n";
$msg_body .= '--' . $boundary . "\n";
$msg_body .= 'Content-type: text/plain; charset="iso-8859-1"' . "\n";
$msg_body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$msg_body .= strip_tags($message) . "\n";
$msg_body .= '--' . $boundary . '--' . "\n";
?>
<html>
 <head>
  <title>Mail Sent!</title>
 </head>
 <body>
<?php
$success = mail($to_address, $subject, $msg_body, join("\r\n", $headers));
if ($success) {
    echo '<h1>Congratulations!</h1>';
    echo '<p>The following message has been sent: <br/><br/>';
    echo '<b>To:</b> ' . $to_address . '<br/>';
    echo '<b>From:</b> ' . $from_address . '<br/>';
    echo '<b>Subject:</b> ' . $subject . '<br/>';
    echo '<b>Message:</b></p>';
    echo nl2br($message);
} else {
    echo '<p><strong>There was an error sending your message.</strong></p>';
}
?>
 </body>
</html>