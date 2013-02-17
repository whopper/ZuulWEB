<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
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

    <title>Add ZuulCash</title>
    <h1><center>Add ZuulCash!<center></h1>
    <div id="addinstructions" name="addinstructions" title="Instructions">
      <p align="center"><a href="index.html">Home</a></p>
      Add funds to purchase Zuul Snacks!
      <ul>
      <li> Select your username and enter the amount of money you would
           like to add. For example, you may enter 5.00 to add $5.
      <li> Place the cash in the Zuul drawer within bajr's cube.
      </ul>
      <hr width="500" size="6">
      <br>
    </div>
  </head>
  <body bgcolor="black" text="white".
        link="green" vlink="purple" alink="purple">
    <div id="addforms" name="addforms" title="Add Funds Forms">
      <p align="left">
      <b>Who are you?</b>
      <br><br>

      <form name="userinfo" action="addfunds.php" method="post">
        <select name="username" size="10" method="post" >
        <?php
          while($row = mysql_fetch_array($result))
            {
              echo "<OPTION value=".$row['username'].">" . $row['username'];
            }
        ?>
        </select></p>

        <p align="center"> 
        Amount to Add: $<input type="float" name="addbalance"></p><br>
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

