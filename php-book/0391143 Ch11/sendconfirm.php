<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
    die ('Unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$to_name = $_POST['to_name'];
$to_email = $_POST['to_email'];
$from_name = $_POST['from_name'];
$from_email = $_POST['from_email'];
$postcard = $_POST['postcard'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$query = 'SELECT description FROM pc_image WHERE image_url = "' . $postcard . '"';
$result = mysql_query($query, $db) or die(mysql_error());

$description = '';
if (mysql_num_rows($result))
{
    $row = mysql_fetch_assoc($result);
    $description = $row['description'];
}
mysql_free_result($result);

$token = md5(time());

$query = 'INSERT INTO pc_confirmation 
        (email_id, token, to_name, to_email, from_name, from_email, subject, 
         postcard, message)
    VALUES
       (NULL, "' . $token . '",  "' . $to_name . '",  "' . $to_email . '",
        "' . $from_name . '",  "' . $from_email . '",   "' . $subject . '",
        "' . $postcard . '",  "' . $message . '")';
mysql_query($query, $db) or die(mysql_error());

$email_id = mysql_insert_id($db);

$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset="iso-8859-1"';
$headers[] = 'Content-Transfer-Encoding: 7bit';
$headers[] = 'From: no-reply@localhost';

$confirm_subject = 'Please confirm your postcard [' . $subject .']';

$confirm_message = '<html>';
$confirm_message .= '<p>Hello, ' . $from_name . '. Please click on the link ' .
    'below to confirm that you would like to send this postcard.</p>';
$confirm_message .= '<p><a href="http://localhost/confirm.php?id=' .
  $email_id . '&token=' . $token .'">Click here to confirm</a></p>';
$confirm_message .= '<hr />';
$confirm_message .= '<img src="' . $postcard . '" alt="' . $description . 
    ' "/><br/>';
$confirm_message .= $message . '</html>';
?>
<html>
 <head>
  <title>Mail Sent!</title>
 </head>
 <body>
<?php
$success = mail($from_email, $confirm_subject, $confirm_message,
    join("\r\n", $headers));

if ($success) {
    echo '<h1>Pending Confirmation!</h1>';
    echo '<p>A confirmation e-mail has been sent to ' . $from_email . '. ' . 
         'Open your e-mail and click on the link to confirm that you  ' .
         'would like to send this postcard to ' . $to_name . '.</p>';
} else {
    echo '<p><strong>There was an error sending the confirmation.</strong></p>';
}
?>
 </body>
</html>