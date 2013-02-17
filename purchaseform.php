<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error = FALSE;
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

  <!DOCTYPE html>
  <html>
    <head>
      <title>Check Out!</title>
      <div id="header" name="header" title="Header">
        <h1><center>Check Out!</center></h1>
        <p align="center"><a href="index.html">Home</a></p>

        Purchase Zuul Snacks!
        <ul>
        <li> Select your username and the item(s) you would like to purchase.
        <li> ZuulCash will be automatically deducted from your account.
        </ul>

        <hr width="500" size="6"><br>
      </div>
    </head>
    <body bgcolor="black" text="white".
          link="green" vlink="purple" alink="purple">
      <div id="purchaseforms" name="purchaseforms" title="Purchase Forms">
        <p align="left">
        <b>Who are you?</b><br>

        <form name="userinfo" action="purchase.php" method="post">
          <select name="username" size="10" method="post" >
           <?php
              while($row = mysql_fetch_array($userresult))
                {
                  echo "<OPTION value=".$row['username'].">" . $row['username'];
                }
           ?>
          </select></p>

        <b>What are you buying?</b> <br>
          <p align="left">
          <select name="itempurchase[]" size="10" method="post" MULTIPLE>
           <?php
              while($row = mysql_fetch_array($itemresult))
                {
                  $itemdisplay = $row['itemname'] . " ($" . $row['itemprice'] . ")";
                  echo "<OPTION value=".$row['itemname'].">" . $itemdisplay;
                }
           ?>
          </select></p>
          <br><br>

          <center><input type="submit" name="submit" value="submit"><center>
        </form>
      </div>
    </body>
  </html>

<?php else: ?>
  <!DOCTYPE html>
    <html>
      <head>
        <title>Error! :(</title>
        <p align="center">Something went wrong with the Zuul Database!
                          Yell at whopper to fix it!
        <a href="zuulmain.html">Home</a></p>
      </head>
<?php endif; ?>

