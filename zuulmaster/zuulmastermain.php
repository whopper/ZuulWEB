<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error = FALSE;
  $itemquery  = "SELECT * FROM inventory ORDER BY itemprice DESC";
  $itemresult = mysql_query($itemquery);
  $userquery  = "SELECT * FROM users ORDER BY username";
  $userresult = mysql_query($userquery);

  if (!$itemresult) {
    exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
  }
?>

<?php if( (mysql_num_rows($itemresult) >= 1)): ?> 
  <!DOCTYPE html>
  <html>
    <head>
      <title>ZuulMaster Tools</title>
      <h1><center>ZuulMaster Tools<br>
                  <i>Options:</i></center></h1>
      <p align="center"><a href="../index.html">Home</a></p>
      <hr width="500" size="6">

    </head>
    <body bgcolor="black" text="white".
          link="green" vlink="purple" alink="purple">
      <div id="admintoolforms" name="admintoolforms" title="Admin Tool Forms">
        <!--Form for adding item to Zuul inventory -->
        <h3>Add a new item to the Zuul</h3><br>
        <form name="additem" action="zuulmaster.php" method="post">
          Item name: <input type="text" name="newitemname"><br>
          Item price: $<input type="text" name="newitemprice"><br>
          <br>
          <input type="submit" name="submitadditem" value="Add Item">
        </form>

        <hr width="500" size="6">
        <br><br>

        <!--Form for changing the price of a Zuul item -->
        <h3>Change the price of or remove an existing Zuul item</h3><br>
        <form name="adjustitem" action="zuulmaster.php" method="post">
          <select name="itemselect" size="10" method="post">
          <?php
            while($row = mysql_fetch_array($itemresult))
              {
                $itemdisplay = $row['itemname'] . " ($" . $row['itemprice'] . ")";
                echo "<OPTION value=".$row['itemname'].">" . $itemdisplay;
              }
          ?>
          </select></p>
          <br>New Price: $
          <input type="text" name="newprice"><br>
          <br>
          <input type="submit" name="submitchangeprice" value="Change Price">
          <input type="submit" name="submitremoveitem" value="Remove Item">
        </form>

        <hr width="500" size="6">
        <br><br>

       <!--Form for adjusting balance for a user or removing a user -->

        <h3>Adjust user balance or remove a user</h3><br>
        <form name="adjustuser" action="zuulmaster.php" method="post">
          <select name="userselect" size="10" method="post">
          <?php
            while($row = mysql_fetch_array($userresult))
              {
                echo "<OPTION value=".$row['username'].">" . $row['username'];
              }
          ?>
          </select></p>
          <br>New Balance: $
          <input type="text" name="newbalance"><br>
          <br>
          <input type="submit" name="submitchangebalance" value="Change Balance">
          <input type="submit" name="submitremoveuser" value="Remove User">
        </form>
      </div>
    </body>
  </html>
  <?php mysql_close() ?>

<?php else: ?>
<!DOCTYPE html>
  <html>
    <head>
      <title>Error! :(</title>
        <p align="center">Something went wrong with the Zuul Database!
                          Yell at whopper to fix it!
      <a href="zuulmain.html">Home</a></p>
    </head>
    <body bgcolor="black" text="white".
          link="green" vlink="purple" alink="purple">
    </body>
  </html>
<?php endif; ?>

