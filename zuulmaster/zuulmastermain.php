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
      <link rel="stylesheet" type="text/css" href="../style/zuulmaster.css" />
      <link rel="stylesheet" type="text/css" href="../style/main.css" />
      <title>ZuulMaster Tools</title>
      <div id="header" name="header" title="Header">
        <img id="zuulmasterbanner" src="../images/zuulmastertoolsbanner.png" height=90 width=1300
             alt="Zuul Master Banner">
      </div>
      <hr>
    </head>
    <body>
      <div class="additemtool basicbox" name="admintoolforms" title="Admin Tool Forms">
        <!--Form for adding item to Zuul inventory -->
        <p>
        Add a new item to the Zuul
        <form name="additem" action="zuulmaster.php" method="post">
          Item name<br> <input type="text" name="newitemname"><br><br>
          Item price<br> $<input type="text" name="newitemprice"><br>
          <br>
          <input id="submit" type="submit" name="submitadditem" value="Add Item">
        </form>
        </p>
      </div>

      <div class="adjustitemtool basicbox" name="adjustitemtool" title="Change Price Tool">
        <!--Form for changing the price of a Zuul item -->
        <p>
        Edit an existing Zuul item
        <form name="adjustitem" action="zuulmaster.php" method="post">
          <select name="itemselect" size="10" method="post">
          <?php
            while($row = mysql_fetch_array($itemresult))
              {
                $itemdisplay = $row['itemname'] . " ($" . $row['itemprice'] . ")";
                echo "<OPTION value=".$row['itemname'].">" . $itemdisplay;
              }
          ?>
          </select>
          <br><br>New Price<br> $
          <input type="text" name="newprice"><br><br>
          <input id="submit" type="submit" name="submitchangeprice" value="Change Price">
          <input id="submit" type="submit" name="submitremoveitem" value="Remove Item">
        </form>
        </p>
      </div>

      <div class="adjustusertool basicbox" name="adjustusertool" title="Adjust User Tool">
       <!--Form for adjusting balance for a user or removing a user -->
        <p>
        Adjust user balance or remove a user</h3>
        <form name="adjustuser" action="zuulmaster.php" method="post">
          <select name="userselect" size="10" method="post">
          <?php
            while($row = mysql_fetch_array($userresult))
              {
                echo "<OPTION value=".$row['username'].">" . $row['username'];
              }
          ?>
          </select>
          <br><br>New Balance<br> $
          <input type="text" name="newbalance"><br><br>
            <input id="submit" type="submit" name="submitchangebalance" value="Change Balance">
          <div id="usersubmit2">
            <input id="submit" type="submit" name="submitremoveuser" value="Remove User">
          </div>
        </form>
        </p>
      </div>
      <div class="homelinkzm" name="homelinkzm" title="homelink">
        <a class="homebuttonzm" href="../index.html">Home</a>
      </div>
      </p>
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

