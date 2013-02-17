<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error = FALSE;
  $query = "SELECT * FROM inventory ORDER BY itemprice DESC";
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
      <title>Zuul Inventory</title>
      <div id="header" name="header" title="Header">
        <p align="center">Zuul Inventory and prices, as managed by bajr.<br>
        <a href="index.html">Home</a></p>
      </div>
    </head>
    <body bgcolor="black" text="white".
          link="green" vlink="purple" alink="purple">
      <div id="inventorytable" name="inventorytable" title="Inventory Table">
        <?php
          echo "<center><table border='1'>
                <tr>
                <th>Item</th>
                <th>Price</th>
                </tr></center>";

          while($row = mysql_fetch_array($result))
            {
              echo "<tr>";
              echo "<td>" . $row['itemname'] . "</td>";
              echo "<td>$" . $row['itemprice'] . "</td>";
              echo "</tr>";
            }
          echo "</table>";
       ?>
      </div>
    </body>
  </html>
<?php else: ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Error! :(</title>
      <p align="center">Something went wrong with the Zuul Database!
              Ask bajr for prices temporarily and yell at whopper to fix it!
      <p align="center"><a href="index.html">Home</a></p>
    </head>
<?php endif; ?>
