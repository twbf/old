<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
    die ('Unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
 <head>
  <title>Send Postcard</title>
  <script type="text/javascript">

window.onload = function() {
    // assign change_postcard_image to select field
    var s = document.getElementById('postcard_select');
    s.onchange = change_postcard_image;
}

function change_postcard_image() {
    var s = document.getElementById('postcard_select');
    var i = document.getElementById('postcard');
    var x = s.options.selectedIndex;

    // update image's src and alt attributes
    i.src = s.options[x].value;
    i.alt = s.options[x].text;
}
  </script>
 </head>
 <body>
  <h1>Send Postcard</h1>
  <form method="post" action="sendconfirm.php">
   <table>
    <tr>
     <td>Sender's Name:</td>
     <td><input type="text" name="from_name" size="40" /></td>
    </tr></tr>
     <td>Sender's E-mail:</td>
     <td><input type="text" name="from_email" size="40" /></td>
    </tr><tr>
     <td>Recipient's Name:</td>
     <td><input type="text" name="to_name" size="40" /></td>
    </tr></tr>
     <td>Recipient's E-mail:</td>
     <td><input type="text" name="to_email" size="40" /></td>
    </tr><tr>
     <td>Choose a Postcard:</td> 
     <td><select id="postcard_select" name="postcard">
<?php
$query = 'SELECT image_url, description FROM pc_image ORDER BY description';
$result = mysql_query($query, $db) or die(mysql_error());

$row = mysql_fetch_assoc($result);
extract($row);

mysql_data_seek($result, 0);
while ($row = mysql_fetch_assoc($result)) {
    echo '<option value="' . $row['image_url'] . '">' . $row['description'] . 
        '</option>';
}
mysql_free_result($result);
?>
      </select>
     </td>
    </tr><tr>
     <td colspan="2">
      <img id="postcard" src="<?php echo $image_url; ?>" 
       alt="<?php echo $description; ?>" />
     </td>
    </tr><tr>
     <td>Subject:</td>
     <td><input type="text" name="subject" size="80" /></td>
    </tr><tr>
     <td colspan="2">
      <textarea cols="76" rows="12" 
       name="message">Enter your message here</textarea>
     </td>
    </tr><tr>
     <td colspan="2">
      <input type="submit" value="Send" /> 
      <input type="reset" value="Reset the form" />
     </td>
    </tr>
   </table>
  </form>
 </body>
</html>