<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";

  if (isset($_POST['submit'])) {
    // Form submitted - handle input

    $username       = $_POST['username'];
    $purchaseitem   = $_POST['itempurchase'];

    // Error checking and Security
    $error = FALSE;

    if ( isset($username) && isset($purchaseitem) && $error == FALSE ) { 
        $process = TRUE;
      } else {
        $process = FALSE;
      }

    if ( $process == TRUE ) {

      $dbconnection = new connectdb();
      $dbconnection->initiate();

      // First, determine how much was spent
      $total = 0;

      foreach ($purchaseitem as $item) {
        $pricecheck = mysql_query("SELECT itemprice FROM inventory WHERE itemname = '$item'");
        $row        = mysql_fetch_array($pricecheck);
        $total      = $total + $row['itemprice'];
      }

      // Do math to figure out the user's new balance
      $balancequery = "UPDATE users SET userbalance = userbalance - '$total' WHERE username = '$username'";
      $newbalance = mysql_query($balancequery);

      if (!$newbalance) {
        exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
      }

    // If user has more than $10 in debt, yell at them
      $debtquery    = "SELECT userbalance FROM users WHERE username = '$username'";
      $debtquerydo  = mysql_query($debtquery);
      $debtrow      = mysql_fetch_array($debtquerydo);
      if ( $debtrow['userbalance'] < -10) {
        echo $username . ",<br><br>";
        echo "You owe the Zuul more than $10.00! Please be considerate of those who work hard to make the Zuul a reality and pay up immediately!";
      }
      mysql_close();
    }
  }
?>

<?php if($process == TRUE): ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Thank you for your submission!</title>
      <p align="center">Thanks for your purchase!<br>
      <a href="index.html">Home</a></p>
    </head>
    <body bgcolor="black" text="white".
          link="green" vlink="purple" alink="purple">
    </body>
  </html>

<?php else: ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Error! :(</title>
      <p align="center">Data processing failed! Either you aren't a
                        registered user or you didn't fill out all of the data fields!
      <a href="index.html">Home</a></p>
    </head>

<?php endif; ?>
