<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  $dbconnection = new connectdb();
  $dbconnection->initiate();
  $error = FALSE;

  function weightedrand($min, $max, $gamma) {
      $offset= $max-$min+1;
      return floor($min+pow(lcg_value(), $gamma)*$offset);
  }
  $rarity = weightedrand(1,8,2);

  $itemselect= "SELECT * FROM backpack WHERE rarity='$rarity' ORDER BY rand() limit 1;";
  $itemselectdo = mysql_query($itemselect);
  $row = mysql_fetch_array($itemselectdo);

  if ( $row['rarity'] === '1' ) {
    $itemcolor = 'white';
  } elseif ( $row['rarity'] === '2' ) {
    $itemcolor = 'green';
  } elseif ( $row['rarity'] === '3' ) {
    $itemcolor = 'blue';
  } elseif ( $row['rarity'] === '4' ) {
    $itemcolor = 'purple';
  } elseif ( $row['rarity'] === '5' ) {
    $itemcolor = 'yellow';
  } elseif ( $row['rarity'] === '6' ) {
    $itemcolor = 'orange';
  } elseif ( $row['rarity'] === '7' ) {
    $itemcolor = 'darkorange';
  } elseif ( $row['rarity'] === '8' ) {
    $itemcolor = 'aqua';
  }

  if (!$itemselectdo) {
    exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
  } else {
    mysql_close();
  }
?>

<html>
  <head>
      <link rel="stylesheet" type="text/css" href="style/main.css" />
      <link rel="stylesheet" type="text/css" href="style/additem.css" />
    <title></title>
  </head>
  <body>
    <div id="itemacquired" class="itemacquired basicbox">
      <h2>You found a new item!</h2>
      <div id='itemtitle' class='itemtitle basicbox'>
        <h2><font color="<?php echo $itemcolor ?>"><?php echo $row['itemname']; ?></font></h2>
      </div>
      <div id="itembox" class="itembox basicbox">
        <div id="itemimage" class="itemimage basicbox">
          <?php echo '<img id="item" src="'.$row["imagepointer"].'" alt="New Item!">'; ?>
        </div>
        <div id="iteminfo" class="iteminfo basicbox">
          <p>
          <?php echo $row['description']; ?>
          <font color="<?php echo $itemcolor ?>"><?php echo "<br><br>Item Level: " .$row["rarity"]; ?>
          </p>
        </div>
      </div>
    </div>
  </body>
</html>
