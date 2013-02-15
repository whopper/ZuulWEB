<?php

if (isset($_POST['submit'])) {
  // Form submitted - handle input

  $username       = $_POST['username'];
  $addbalance     = $_POST['addbalance'];

  // Error checking and Security
  $error = FALSE;
  if ( isset($username)) {
    $username = trim($username);
    $username = strip_tags($username);
  } else {
    $error = TRUE;
  }
  if ( isset($addbalance)) {
    $addbalance = trim($addbalance);
    $addbalance = strip_tags($addbalance);
  } else {
    $error = TRUE;
  }

if ( isset($username) && isset($addbalance) && $error == FALSE ) {
    $process = TRUE;
  } else {
    $process = FALSE;
  }

  if ( $process == TRUE ) {

    define ('DB_USER', 'webdev');
    define ('DB_PASSWORD', 'pass');
    define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'zuul');
    $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
    mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );


    // Do math to figure out the user's new balance
      $origbalancequery = "SELECT userbalance FROM users WHERE username='$username'";
      $origbalance = mysql_query($origbalancequery);
      $additionquery = "UPDATE users SET userbalance = userbalance + '$addbalance' WHERE username = '$username'";

      $q = mysql_query($additionquery);

      if (!$q) {
        exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
      } else {
        mysql_close();
      }
  }
}
?>

<?php if($process == TRUE): ?>

<html>
  <BODY bgcolor="black" text="white".
      link="green" vlink="purple" alink="purple">

      <title>
        Thank you for your submission!
      </title>
      <head>
        <p align="center">Thanks! Your funds have been added!</p>
        <p align="center"><a href="zuulmain.html">Home</a></p>

      </head>

    </html>

<?php else: ?>
<html>
      <title>
        Error! :(
      </title>
      <head>
        <p align="center">Data processing failed! Either you aren't a registered user or you didn't fill out all of the data fields!</p>
        <p align="center"><a href="zuulmain.html">Home</a></p>
      </head>

<?php endif; ?>

