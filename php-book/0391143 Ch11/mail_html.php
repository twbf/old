<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setSendText(false);
$message->setToAddress('youremail@example.com');
$message->setSubject('Testing HTML Email');
$message->setHTMLBody('<html><p>This is a test using <b>HTML 
    email</b>!</p></html>');

if ($message->send()) {
    echo 'HTML email sent successfully!';
} else {
    echo 'Sending of HTML email failed!';
}
?>