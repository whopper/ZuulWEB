<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";

  $dbconnection  = new connectdb();
  $dbconnection->initiate();
  $error         = FALSE;
  $userlistquery = "SELECT * FROM users ORDER BY username";
  $userlistdo    = mysql_query($userlistquery);
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/main.css" />
    <link rel="stylesheet" type="text/css" href="style/rewards.css" />
    <link rel="stylesheet" type="text/css" href="style/additem.css" />
    <title>Zuul Rewards</title>
    <div id="header" name="header" title="Header">
      <img id="requestsbanner" src="images/rewardsbanner.png" height=90 width=1300
           alt="Requests Banner">
    </div>
    <hr>
  </head>
  <body>
    <!-- Align to left -->
    <div class="selectuser basicbox" name="selectuser" title="Select User">
        <form name="userinfo" action="rewards.php" method="get">
          Open the backpack of...<br>
          <select name="username" method="post" >
           <?php
              while($userlistrow = mysql_fetch_array($userlistdo))
                {
                  echo "<OPTION value=".$userlistrow['username'].">" . $userlistrow['username'];
                }
           ?>
          </select><br><br>
        <input type="hidden" name="openbackpack" value="open">
        <input id="submit" type="submit" name="submit" value="Open">
      </form>
    </div>
    <!-- Align Center -->
    <div class="backpack_title basicbox" name="backpack_title" title="Backpack Title">
      <?php 
        $username = $_GET['username'];
        if ( $username != '' ) {
          echo '<h2> '.$username.'\'s Backpack</h2>';
        } else {
          echo '<h2>Choose a Backpack!</h2>';
        }
      ?>
    </div>

    <div class="backpack basicbox" name="backpack">
      <?php
        $username = $_GET['username'];
        if (!empty($_GET['openbackpack'])) {
          $getinvquery = "SELECT ui.username, ui.item_id, it.itemname,
                          it.rarity, it.description, it.imagepointer
                          FROM userinventory ui LEFT JOIN items it
                          ON it.sid = ui.item_id WHERE ui.username='$username';";

          $getinvdo  = mysql_query($getinvquery);
          while($row = mysql_fetch_array($getinvdo))
            {
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

              echo '<div class="itemicon basicbox" name="itemicon">';
              echo '<img id="itemiconimg" width=100 height=100 src="'.$row["imagepointer"].'" alt="Item!">';

                echo '<div class="modal">';

                  echo '<div class="itemcard basicbox" name="itemcard">';
                    echo '<div id="itemtitle" class="itemtitle basicbox">';
                      echo '<h2><font color='.$itemcolor.'>'.$row['itemname'].'</font></h2>';
                    echo '</div>';
                    echo '<br><br><br><br>';
                    echo '<div class="itembox basicbox" name="itembox">';
                      echo '<div id="itemimage" class="itemimage basicbox">';
                      echo '<img id="item" src="'.$row["imagepointer"].'" alt="Item Image!">';
                      echo '</div>';
                      echo '<div id="iteminfo" class="iteminfo basicbox">';
                        echo '<p>';
                        echo $row['description'];
                        echo '<h4><font color='.$itemcolor.'><br><br>Item Level: '.$row['rarity'].'</font></h4>';
                        echo '</p>';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
            }
        }
      ?>
    </div>
    <br>
    <div class="homelink" name="homelink" title="homelink">
      <a class="homebutton" href="index.html">Home</a>
    </div>
  </body>
</html>

