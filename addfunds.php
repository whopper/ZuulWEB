<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  require "/Library/WebServer/Documents/lib/datasanitizer.php";

  if (isset($_POST['submit'])) {
  // Form submitted - handle input

    $username   = $_POST['username'];
    $addbalance = str_replace('$', '', $_POST['addbalance']);

    // Error checking and Security
    $error = FALSE;
    if ( isset($username)) {
      $sanitizer = new datasanitizer();
      $username  = ($sanitizer->sanitize($username));
    } else {
      $error = TRUE;
    }
    if ( isset($addbalance)) {
      $addbalance  = ($sanitizer->sanitize($addbalance));
    } else {
      $error = TRUE;
    }

    if ( isset($username) && isset($addbalance) && $error == FALSE ) {
      $process = TRUE;
    } else {
      $process = FALSE;
    }

    if ( $process == TRUE ) {

      $dbconnection = new connectdb();
      $dbconnection->initiate();

      // Do math to figure out the user's new balance
      $origbalancequery = "SELECT userbalance FROM users WHERE username='$username'";
      $origbalancedo = mysql_query($origbalancequery);
      $additionquery = "UPDATE users SET userbalance = userbalance + '$addbalance' WHERE username = '$username'";

    $additionquerydo = mysql_query($additionquery);

      if (!$additionquerydo) {
        exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
      } else {
        mysql_close();
      }
    }
  }
?>

<?php if($process == TRUE): ?>

  <!DOCTYPE html>
  <html>
    <head>
      <link rel="stylesheet" type="text/css" href="style/main.css" />
      <title>Thank you for your submission!</title>
    </head>
    <body>
      <div id=endmessage>
        <p>
          Success!
        </p>
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
      <p align="center">Data processing failed! Either you aren't a registered user or you didn't fill out all of the data fields!<br>
      <a href="index.html">Home</a></p>
  </head>
  <body bgcolor="black" text="white".
        link="green" vlink="purple" alink="purple">
  </body>

<?php endif; ?>

