<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";
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
      <link rel="stylesheet" type="text/css" href="style/zuulforms.css" />
      <link rel="stylesheet" type="text/css" href="style/main.css" />
      <title>Check Out!</title>
      <div id="header" name="header" title="Header">
        <a id="home" href="index.html"><img id="balancesbanner" 
	   src="images/checkoutbanner.png" height=90 width=1300
           alt="Balances Banner"></a>
      </div>
      <hr>
    </head>
    <body>
      <div class="purchaseforms basicbox" name="purchaseforms" title="Purchase Forms">
        <p>
        Purchase Zuul Snacks!

        <form name="userinfo" action="purchase.php" method="post">
        Who are you?<br>
          <select name="username" method="post" >
           <?php
              echo '<option></option>';
              while($row = mysql_fetch_array($userresult))
                {
                  echo "<OPTION value=".$row['username'].">" . $row['username'];
                }
           ?>
          </select><br><br>
        What are you buying?<br>
          <select  name="itempurchase[]" size="10" method="post" MULTIPLE>
           <?php
              while($row = mysql_fetch_array($itemresult))
                {
                  $itemdisplay = $row['itemname'] . " ($" . $row['itemprice'] . ")";
                  echo "<OPTION value=".$row['itemname'].">" . $itemdisplay;
                }
           ?>
          </select>
          </p>

          <input id="submit" type="submit" name="submit" value="Purchase">
        </form>
      </div><br>
      <div class="homelink" name="homelink" title="homelink">
        <a class="homebutton" href="index.html">Home</a>
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

