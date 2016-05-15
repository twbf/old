<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
    die ('Unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// create the postcard image table
$query = 'CREATE TABLE IF NOT EXISTS pc_image (
        image_id      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
        image_url     VARCHAR(255)     NOT NULL DEFAULT "",
        description   VARCHAR(255)     NOT NULL DEFAULT "",

        PRIMARY KEY (image_id)
    )
    ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// change this path depending on your server
$images_path = 'http://localhost/postcards/';

//insert new data into the postcard image table
$query = 'INSERT IGNORE INTO pc_image
        (image_id, image_url, description)
    VALUES 
        (1, "' . $images_path . 'punyearth.jpg", "Wish you were here"),
        (2, "' . $images_path . 'congrats.jpg", "Congratulations"),
        (3, "' . $images_path . 'visit.jpg", "We\'re coming to visit"),
        (4, "' . $images_path . 'sympathy.jpg", "Our Sympathies")';
mysql_query($query, $db) or die (mysql_error($db));

echo 'Success!';
?>