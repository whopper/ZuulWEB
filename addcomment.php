<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  require "/Library/WebServer/Documents/lib/datasanitizer.php";

  if (isset($_POST['submit'])) {

    // Form submitted - handle input
    $comment = $_POST['comments'];

    // Error checking and Security
    $error = FALSE;
    if ( isset($comment) && $comment != "") {
      $sanitizer = new datasanitizer();
      $username  = ($sanitizer->sanitize($comment));
    } else {
      $error = TRUE;
    }

    if ( $error === FALSE ) {
      $dbconnection = new connectdb();
      $dbconnection->initiate();
      $addcommentquery = "INSERT INTO comments VALUES ('','$comment','', now())";
      $addcommentdo    = mysql_query($addcommentquery);

        if (!$addcommentdo) {
          exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
        } else {
          mysql_close();
        }
      } else {
        $error = TRUE;
      }
    }
?>

<?php if($error === FALSE): ?>

<!DOCTYPE html>
  <html>
    <head>
      <link rel="stylesheet" type="text/css" href="style/main.css" />
      <title>Thank you for your submission!</title>

    </head>
    <body>
      <div class="endmessage basicbox">
          Success!
      </div>
      <br>
      <div class="homelink" name="homelink" title="homelink">
        <a class="homebutton" href="../index.html">Home</a>
      </div>

    </body>
  </html>

<?php else: ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Error! :(</title>
      <p align="center">Data processing failed!<br>
      <a href="../index.html">Home</a></p>
    </head>
    <body>
    </body>
  </html>
<?php endif; ?>

