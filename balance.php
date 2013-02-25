<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";
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
    <link rel="stylesheet" type="text/css" href="style/zuultable.css" />
    <link rel="stylesheet" type="text/css" href="style/main.css" />
    <title>Zuul Balance</title>
    <div id="header" name="header" title="Header">
      <img id="balancesbanner" src="images/balancesbanner.png" height=90 width=1300
           alt="Balances Banner">
    </div>
    <hr>
  </head>
  <body>
    <br>
    <div class="zuultable basicbox" name="zuultable" title="Balance Table">
      <p>
      <ul>
      <li> A positive balance indicates that you have ZuulCash to spend.
      <li> A negative balance means that you <i>owe</i> the Zuul money!
      </ul>
      <table class="gradienttable">
      <tr>
      <th>Item</th>
      <th>Balance</th>
      </tr>
      </p>
      <?php
        while($row = mysql_fetch_array($result))
          {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . "$" . $row['userbalance'] . "</td>";
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
<html>
  <head>
    <title>Error! :(</title>
    Something went wrong with the Zuul Database!
    Yell at whopper to fix it!
  </head>
  <body>
    <div class="homelink" name="homelink" title="homelink">
      <a class="homebutton" href="index.html">Home</a>
    </div>
  </body>
<?php endif; ?>
