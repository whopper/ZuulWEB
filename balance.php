<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error = FALSE;
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
  <head>
    <title>Zuul Balance</title>
    <p align="center">Zuul Balance<br>
    <a href="index.html">Home</a></p>

  </head>
  <body bgcolor="black" text="white".
        link="green" vlink="purple" alink="purple">
    <div id="balancetable" name="balancetable" title="Balance Table">
      <ul>
      <li> A positive balance indicates that you have ZuulCash to spend.
      <li> A negative balance means that you <i>owe</i> the Zuul money!
      </ul>
      <br>

      <?php
        echo "<center><table border='1'>
              <tr>
              <th>Item</th>
              <th>Price</th>
              </tr></center>";

        while($row = mysql_fetch_array($result))
          {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . "$" . $row['userbalance'] . "</td>";
            echo "</tr>";
          }
        echo "</table>";
      ?>
    </div>
  </body>
</html>

<?php else: ?>
<html>
  <head>
    <title>Error! :(</title>
    <p align="center">Something went wrong with the Zuul Database!
                      Yell at whopper to fix it!
    <a href="zuulmain.html">Home</a></p>
  </head>
<?php endif; ?>
