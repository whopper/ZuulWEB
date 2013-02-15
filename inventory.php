<?php

  $error = FALSE;

    define ('DB_USER', 'webdev');
    define ('DB_PASSWORD', 'pass');
    define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'zuul');
    $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
    mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );

    $query = "SELECT * FROM inventory ORDER BY itemprice DESC";
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
        Zuul Inventory
      </title>
      <head>
        <p align="center">Zull Inventory and prices, as managed by bajr.</p>
        <p align="center"><a href="zuulmain.html">Home</a></p>
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
            echo "<td>" . $row['itemprice'] . "</td>";
            echo "</tr>";
          }
        echo "</table>";

     ?>

      </head>

    </html>
<?php else: ?>
<html>
      <title>
        Error! :(
      </title>
      <head>
        <p align="center">Something went wrong with the Zuul Database!
        Ask bajr for prices temporarily and yell at whopper to fix it!</p>
        <p align="center"><a href="zuulmain.html">Home</a></p>
      </head>
<?php endif; ?>
