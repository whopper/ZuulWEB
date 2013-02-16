<?php

  $error = FALSE;

    define ('DB_USER', 'webdev');
    define ('DB_PASSWORD', 'pass');
    define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'zuul');
    $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
    mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );

    $query = "SELECT * FROM users ORDER BY username";
    $result = mysql_query($query);

    if (!$result) {
      exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
    } else {
      mysql_close();
    }
?>

<?php if( (mysql_num_rows($result) >= 1)): ?>

<html>
  <BODY bgcolor="black" text="white".
      link="green" vlink="purple" alink="purple">
  <title>
    Add ZuulCash
  </title>
  <head>

    <h1><center>Add ZuulCash!<center></h1>
    <p align="center"><a href="index.html">Home</a></p>

    Add funds to purchase Zuul Snacks!
    <UL>
    <LI> Select your username and enter the amount of money you would
         like to add. For example, you may enter 5.00 to add $5.
    <LI> Place the cash in the Zuul drawer within pfaffle's cube.
    </UL>

    <hr width="500" size="6">
    <br>

  </head>
  <body>

    <p align="left">
    <B>Who are you?</B> <br><br>

    <form name="userinfo" action="addfunds.php" method="post">
      <SELECT name="username" size="10" method="post" >
       <?php
          while($row = mysql_fetch_array($result))
            {
              echo "<OPTION value=".$row['username'].">" . $row['username'];
            }
       ?>
      </SELECT></p>

      <p align="center"> 
      Amount to Add: $<input type="float" name="addbalance"><br></p>

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

