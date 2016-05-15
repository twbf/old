<?php
require 'class.SimpleMail.php';

$message = new SimpleMail();

if ($message->send('youremail@example.com', 'Testing Quick Email', 
    'This is a quick test of SimpleMail->send().')) {
    echo 'Quick mail sent successfully!';
} else {
    echo 'Sending the quick mail failed!';
}
?>