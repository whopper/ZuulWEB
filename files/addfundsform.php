<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";
  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error  = FALSE;
  $query  = "SELECT * FROM users ORDER BY username";
  $result = mysql_query($query);

  if (!$result) {
    exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
  } else {
    mysql_close();
  }
?>

<?php if( (mysql_num_rows($result) >= 1)): ?>

<!DOCTYPE html>
<html>
  <head>
      <link rel="stylesheet" type="text/css" href="style/zuulforms.css" />
      <link rel="stylesheet" type="text/css" href="style/main.css" />
      <title>Add ZuulCash</title>
      <div id="header" name="header" title="Header">
        <a id="home" href="index.html"><img id="balancesbanner" 
	    src="images/addfundsbanner.png" height=90 width=1300
            alt="Balances Banner"></a>
      </div>
      <hr>
  </head>
  <body>
    <div class="purchaseforms basicbox" name="purchaseforms" title="Add Funds Forms">
      <p>
      Add ZuulCash!
      <form name="userinfo" action="addfunds.php" method="post">
      Who are you?<br>
        <select name="username" size="10" method="post" >
        <?php
          while($row = mysql_fetch_array($result))
            {
              echo "<OPTION value=".$row['username'].">" . $row['username'];
            }
        ?>
        </select><br><br>

        Amount to Add<br> $<input type="float" name="addbalance"></p>
        <input id="submit" type="submit" name="submit" value="Add ZuulCash">
      </form>
      </p>
    </div>
    <br>
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

