<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";

  if (isset($_POST['submit'])) {
    $username       = $_POST['username'];
    $purchaseitem   = $_POST['itempurchase'];
    $error = FALSE;

    if ( isset($username) && isset($purchaseitem) && $error == FALSE ) { 
        $process = TRUE;
      } else {
        $process = FALSE;
      }

    if ( $process == TRUE ) {

      $dbconnection = new connectdb();
      $dbconnection->initiate();

      $total = 0;
      foreach ($purchaseitem as $item) {
        $pricecheck = mysql_query("SELECT itemprice FROM inventory WHERE itemname = '$item'");
        $row        = mysql_fetch_array($pricecheck);
        $total      = $total + $row['itemprice'];
      }

      $balancequery = "UPDATE users SET userbalance = userbalance - '$total' WHERE username = '$username'";
      $newbalance = mysql_query($balancequery);

      // Increment num. purchased for item
      $purchasedcheckquery = "SELECT purchased FROM inventory WHERE itemname = '$item'";
      $purchasedcheck      = mysql_query($purchasedcheckquery);
      $pcheckrow           = mysql_fetch_array($purchasedcheck);

      $new_val       = $pcheckrow['purchased'] + 1;
      $updatequery   = "UPDATE inventory SET purchased='$new_val' WHERE itemname = '$item'";
      $updatequerydo = mysql_query($updatequery);
      if (!$newbalance) {
        exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
      }

      function weightedrand($min, $max, $gamma) {
          $offset= $max-$min+1;
          return floor($min+pow(lcg_value(), $gamma)*$offset);
      }

      $rarity = weightedrand(1,8,2);
      $itemselect= "SELECT * FROM items WHERE rarity='$rarity' ORDER BY rand() limit 1;";
      $itemselectdo = mysql_query($itemselect);
      $row = mysql_fetch_array($itemselectdo);

      if ( !$row['itemname'] ) { 
        $row['sid']          = '9';
        $row['itemname']     = 'Lesser Disc of Conjure Unix';
        $row['rarity']       = '1';
        $row['imagepointer'] = 'itemimages/LesserDiscLinux.png';
        $row['description']  = '25% chance of success';
      }

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
      } elseif ( $row['rarity'] === '9' ) {
        $itemcolor = 'aqua';
      }
    }
  }
?>

<?php if($process == TRUE): ?>
  <!DOCTYPE html>
  <html>
    <head>
      <link rel="stylesheet" type="text/css" href="style/main.css" />
      <link rel="stylesheet" type="text/css" href="style/additem.css" />
      <title>Thank you for your submission!</title>
    </head>
    <body>
      <div class="endmessage basicbox">
          Thanks!<br> Check your Backpack in Zuul Rewards
      </div>
      <br>
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
      <?php
        // Add new item to user inventory
        $item_id      = $row['sid'];
        $additemquery = "INSERT INTO userinventory VALUES('','$username','$item_id')";
        $additemdo    = mysql_query($additemquery);
      ?>
      <br>
      <div class="homelink" name="homelink" title="homelink">
        <a class="homebutton" href="index.html">Home</a>
      </div>
      <br>
    </body>
  </html>

<?php else: ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Error! :(</title>
      <p align="center">Data processing failed! Either you aren't a
                        registered user or you didn't fill out all of the data fields!
      <a href="index.html">Home</a></p>
    </head>

<?php endif; ?>
