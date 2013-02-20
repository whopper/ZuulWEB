<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";

  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error           = FALSE;
  $getinvquery = "SELECT * FROM users ORDER BY username";
  $getinvdo    = mysql_query($getinvquery);

  if (!$getinvdo) {
    exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/main.css" />
    <link rel="stylesheet" type="text/css" href="style/rewards.css" />
    <link rel="stylesheet" type="text/css" href="style/additem.css" />
    <title>Zuul Requests</title>
    <div id="header" name="header" title="Header">
      <img id="requestsbanner" src="images/rewardsbanner.png" height=90 width=1300
           alt="Requests Banner">
    </div>
    <hr>
  </head>
  <body>
    <!-- Align to left -->
    <div class="selectuser basicbox" name="selectuser" title="Select User">
        <form name="userinfo" action="" method="post">
          Open the backpack of...<br>
          <select name="username" method="post" >
           <?php
              while($row = mysql_fetch_array($getinvdo))
                {
                  echo "<OPTION value=".$row['username'].">" . $row['username'];
                }
           ?>
          </select><br><br>
        <input id="submit" type="submit" name="submit" value="Open">
      </form>
    </div>
    <!-- Align Center -->
    <div class="backpack basicbox" name="backpack" title="Backpack">

    </div>
    <br>
    <div class="homelink" name="homelink" title="homelink">
      <a class="homebutton" href="index.html">Home</a>
    </div>



  </body>
</html>

