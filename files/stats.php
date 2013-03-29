<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";
  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error = FALSE;
  $query = "SELECT itemname, purchased FROM inventory ORDER BY purchased DESC";
  $result = mysql_query($query);

  if (!$result) {
    exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/main.css" />
    <link rel="stylesheet" type="text/css" href="style/stats.css" />
    <link rel="stylesheet" type="text/css" href="style/zuultable.css" />

    <title>Zuul Stats</title>
    <div id="header" name="header" title="Header">
      <a id="home" href="index.html"><img id="aboutbanner" 
	 src="images/statsbanner.png" height=90 width=1300
         alt="About Banner"></a>
    </div>
    <hr>
  </head>
  <body>
    <div class="allmenu basicbox" name="allmenu">
      <div class="popularitem">

      </div>
      <div class="totalspent basicbox" name="totalspent">
          Total spent at the Zuul
          <hr>
          <?php
            $allitemq    = "SELECT itemprice,purchased from inventory;";
            $allitemdo   = mysql_query($allitemq);
            echo '<div class="statitemtext" name="statitemtext">';
            echo '<br>';
            $total = 0;
            while( $allitemrow  = mysql_fetch_array($allitemdo))
              {
                $total = $total + $allitemrow['itemprice'] * $allitemrow['purchased'];
              }
            if (strpos($total, '.') === false) { 
              $total = "$total".'.00';
            }
	    $reverse = strrev( $total );
	    if ( $reverse[1] === "." ) {
              $total = "$total".'0';
	    }
            echo "$" .$total;
            echo '</div>';
          ?>
      </div>
      <div class="popular basicbox" name="popular">
          Most popular item
          <hr>
          <?php
            $popularquery = "SELECT * from inventory ORDER BY purchased DESC LIMIT 1;";
            $populardo    = mysql_query($popularquery);
            $poprow       = mysql_fetch_array($populardo);
            echo '<div class="statitemtext" name="statitemtext">';
            echo '<br>';
            echo $poprow['itemname'];
            echo '</div>';
          ?>
      </div>
      <div class="statstable basicbox" name="statstable">
        Stats
          <p> 
          </ul>
          <table class="gradienttable">
          <tr>
          <th>Item</th>
          <th>Times Purchased</th>
          </tr>
          </p>
          <?php
            while($row = mysql_fetch_array($result))
              {
                echo "<tr>";
                echo "<td>" . $row['itemname'] . "</td>";
                echo "<td>" . $row['purchased'] . "</td>";
                echo "</tr>";
              }
            echo "</table>";
            echo "<br>";
          ?>
    </div>

    <div class="homelink" name="homelink" title="homelink">
      <a class="homebutton" href="index.html">Home</a>
    </div>
  </body>
</html>
