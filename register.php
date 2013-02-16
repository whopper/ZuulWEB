<?php

if (isset($_POST['submit'])) {
  // Form submitted - handle input

  $username      = $_POST['q1_username'];

  // Error checking and Security
  $error = FALSE;
  if ( isset($username)) {
    $username = trim($username);
    $username = strip_tags($username);
  } else {
    $error = TRUE;
  }

  if ( $error === FALSE ) {

    define ('DB_USER', 'webdev');
    define ('DB_PASSWORD', 'pass');
    define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'zuul');
    $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
    mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );

    // First, ensure the user doesn't already exist
    $checkuserquery = "SELECT * FROM users WHERE username='$username'";
    $checkuserdo    = mysql_query($checkuserquery);

    // Insert the new user into the DB
    if( mysql_num_rows($checkuserdo) === 0) {
      $adduserquery = "INSERT INTO users VALUES ('','$username','0.00')";
      $adduserdo    = mysql_query($adduserquery);

      if (!$adduserdo) {
        exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
      } else {
        mysql_close();
      }
    } else {
      $error = TRUE;
    }
  }
}
?>

<?php if($error === FALSE): ?>

<html>
  <BODY bgcolor="black" text="white".
      link="green" vlink="purple" alink="purple">

      <title>
        Thank you for your submission!
      </title>
      <head>
        <p align="center">Thanks!
          You are now registered.
          <UL>
          <LI> Next, select 'Add ZuulCash' from
          the home screen to manage your Zuul balance.
          <LI> Finally, you may use the 'Check Out!' option 
               to purchase Zuul snacks!
          </UL>
          </p>
        <p align="center"><a href="index.html">Home</a></p>


        <p align="center"><a href="eggs.html"><img src="images/square.jpg"
        alt="BY THE POWER OF DERP"
        width="300" height="300" style="float: left;" border="0" /></a></p>

        <p align="center"><IMG SRC="images/square.jpg" HEIGHT=80 WIDTH=350>

      </head>

    </html>

<?php else: ?>
<html>
  <BODY bgcolor="black" text="white".
      link="green" vlink="purple" alink="purple">
      <title>
        Error! :(
      </title>
      <head>
        <p align="center">Data processing failed! Either you didn't fill out the required field or you are already registered!</p>
        <p align="center"><a href="../index.html">Home</a></p>
      </head>

<?php endif; ?>

