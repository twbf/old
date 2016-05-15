<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

$message->setToAddress('youremail@example.com');
$message->setFromAddress('myemail@example.com');
$message->setCCAddress('friend@example.com');
$message->setBCCAddress('secret@example.com');
$message->setSubject('Testing Multipart Email');
$message->setTextBody('This is the plain text portion of the email!');
$message->setHTMLBody('<html><p>This is the <b>HTML portion</b> of the 
    email!</p></html>');

if ($message->send()) {
    echo 'Multi-part mail sent successfully!';
} else {
    echo 'Sending the multi-part mail failed!';
}
?>