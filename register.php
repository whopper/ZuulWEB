<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";
  require "/home/whopper/zuulweb/files/lib/datasanitizer.php";

  if (isset($_POST['submit'])) {

    // Form submitted - handle input
    $username = $_POST['q1_username'];

    // Error checking and Security
    $error = FALSE;
    if ( isset($username) && $username != "") {
      $sanitizer = new datasanitizer();
      $username  = ($sanitizer->sanitize($username));
    } else {
      $error = TRUE;
    }

    if ( $error === FALSE ) {
      $dbconnection = new connectdb();
      $dbconnection->initiate();

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

     <a href="eggs.html"><img src="images/square.jpg"
           alt="BY THE POWER OF DERP"
           width="300" height="300" style="float: left;" border="0" /></a></p>

    </body>
  </html>

<?php else: ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Error! :(</title>
      <p align="center">Data processing failed! Either you didn't fill out 
                        the required field or you are already registered!<br>
      <a href="../index.html">Home</a></p>
    </head>
    <body bgcolor="black" text="white".
        link="green" vlink="purple" alink="purple">
    </body>
  </html>
<?php endif; ?>

