<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
    die ('Unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$id = (isset($_GET['id'])) ? $_GET['id'] : 0;
$token = (isset($_GET['token'])) ? $_GET['token'] : '';

$query = 'SELECT email_id, token, to_name, to_email, from_name, from_email,
    subject, postcard, message FROM pc_confirmation WHERE
        token = "' . $token . '"';
$result = mysql_query($query, $db) or die(mysql_error());

if (mysql_num_rows($result) == 0) {
    echo '<p>Oops! Nothing to confirm.</p>';
        mysql_free_result($result);
    exit;
} else {
    $row = mysql_fetch_assoc($result);
        extract($row);
    mysql_free_result($result);
}

$boundary = '==MP_Bound_xyccr948x==';

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: multipart/alternative; boundary="' . $boundary . '"';
$headers[] = 'From: ' . $from_email;

$postcard_message = '<html>';
$postcard_message .= '<p>Greetings, ' . $to_name . '! ';
$postcard_message .= $from_name . ' has sent you a postcard today.</p>';
$postcard_message .= '<p>Enjoy!</p>';
$postcard_message .= '<hr />';
$postcard_message .= '<img src="' . $postcard . '" alt="' . $description . 
    ' "/><br/>';
$postcard_message .= $message;
$postcard_message .= '<hr/><p>You can also visit ' . 
    '<a href="http://localhost/viewpostcard.php?id=' . $email_id . '&token=' . 
    $token .'">http://localhost/viewpostcard.php?id=' . $email_id . 
    '&token=' . $token .'</a> to view this postcard online.</p></html>';

$mail_message = 'This is a Multipart Message in MIME format' . "\n";
$mail_message .= '--' . $boundary . "\n";
$mail_message .= 'Content-type: text/html; charset="iso-8859-1"' . "\n";
$mail_message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$mail_message .= $postcard_message . "\n";
$mail_message .= '--' . $boundary . "\n";
$mail_message .= 'Content-Type: text/plain; charset="iso-8859-1"' . "\n";
$mail_message .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
$mail_message .= strip_tags($postcard_message) . "\n";
$mail_message .= '--' . $boundary . '--' . "\n";
?>
<html>
 <head>
  <title>Postcard Sent!</title>
 </head>
 <body>
<?php
$success = mail($to_email, $subject, $mail_message, join("\r\n", $headers));
if ($success) {
    echo '<h1>Congratulations!</h1>';
    echo '<p>The following postcard has been sent to ' . $to_name .
            ': <br/></p>';
    echo $postcard_message;
} else {
    echo '<p><strong>There was an error sending your message.</strong></p>';
}
?>
 </body>
</html>