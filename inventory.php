<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";
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
      <link rel="stylesheet" type="text/css" href="style/zuultable.css" />
      <link rel="stylesheet" type="text/css" href="style/main.css" />
      <title>Zuul Inventory</title>
      <div id="header" name="header" title="Header">
      <img id="balancesbanner" src="images/pricesbanner.png" height=90 width=1300
           alt="Balances Banner">

      </div>
      <br>
    </head>
    <body>
      <div class="zuultable basicbox" name="Zuultable" title="Inventory Table">
      <p>
      Zuul inventory and prices, as managed by bajr.
      <table class="gradienttable">
      <tr>
      <th>Item</th>
      <th>Price</th>
      </tr>
      </p>
      <?php
          while($row = mysql_fetch_array($result))
            {
              echo "<tr>";
              echo "<td>" . $row['itemname'] . "</td>";
              echo "<td>$" . $row['itemprice'] . "</td>";
              echo "</tr>";
            }
          echo "</table>";
          echo "<br>";
       ?>
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
              Ask bajr for prices temporarily and yell at whopper to fix it!
      <p align="center"><a href="index.html">Home</a></p>
    </head>
<?php endif; ?>
