<?php

  $error = FALSE;

    define ('DB_USER', 'webdev');
    define ('DB_PASSWORD', 'pass');
    define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'zuul');
    $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
    mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );

    $itemquery  = "SELECT * FROM inventory ORDER BY itemprice DESC";
    $itemresult = mysql_query($itemquery);
    $userquery  = "SELECT * FROM users ORDER BY username";
    $userresult = mysql_query($userquery);

    if (!$itemresult || !$userresult) {
      exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
    } else {
      mysql_close();
    }
?>

<?php if( (mysql_num_rows($itemresult) >= 1 && mysql_num_rows($userresult) >= 1)): ?>

<html>
  <BODY bgcolor="black" text="white".
      link="green" vlink="purple" alink="purple">
  <title>
    Check Out!
  </title>
  <head>
    <h1><center>Check Out!<center></h1>
    <p align="center"><a href="index.html">Home</a></p>

    Purchase Zuul Snacks!
    <UL>
    <LI> Select your username and the item(s) you would like to purchase.
    <LI> ZuulCash will be automatically deducted from your account.
    </UL>

    <hr width="500" size="6">
    <br>

  </head>
  <body>

    <p align="left">
    <B>Who are you?</B><br>

    <form name="userinfo" action="purchase.php" method="post">
      <SELECT name="username" size="10" method="post" >
       <?php
          while($row = mysql_fetch_array($userresult))
            {
              echo "<OPTION value=".$row['username'].">" . $row['username'];
            }
       ?>
      </SELECT></p>

    <B>What are you buying?</B> <br>
      <p align="left">
      <SELECT name="itempurchase[]" size="10" method="post" MULTIPLE>
       <?php
          while($row = mysql_fetch_array($itemresult))
            {
              $itemdisplay = $row['itemname'] . " ($" . $row['itemprice'] . ")";
              echo "<OPTION value=".$row['itemname'].">" . $itemdisplay;
            }
       ?>
      </SELECT></p>
      <br><br>
      <center><input type="submit" name="submit" value="submit"><center>
    </form>
  </body>
</html>

<?php else: ?>
<html>
      <title>
        Error! :(
      </title>
      <head>
        <p align="center">Something went wrong with the Zuul Database!
        Yell at whopper to fix it!</p>
        <p align="center"><a href="zuulmain.html">Home</a></p>
      </head>
<?php endif; ?>

