<?php

  require "/home/whopper/zuulweb/files/lib/connectdb.php";

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
    <script src="js/crafting.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
    <script type="text/javascript"><!--
      $(document).ready(function() {
        // sets the draggable
        $('#drag .drg').draggable({
          zIndex: 2500,
          cursor: 'move',          // sets the cursor apperance
          revert: 'invalid'
        });

        // sets droppable
        $('#drop').droppable({
          zIndex: 1000,
          drop: function(event, ui) {
          }
        });
      });
  --></script>
    <title>Zuul Rewards</title>
    <div id="header" name="header" title="Header">
      <a id="home" href="index.html"><img id="requestsbanner" 
         src="images/rewardsbanner.png" height=90 width=1300
         alt="Requests Banner"></a>
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
              echo '<option></option>';
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
    <div class="craftbutton basicbox">
        <input class="startcraft" type="button" onclick="modalpop('overlay');" name="startcraft" value="Craft Items! (Beta)">
    </div>
    <!-- Align Center -->
    <div class="backpack_title basicbox" name="backpack_title">
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

              echo '<div id="drag" class="itemicon basicbox" name="itemicon">';
              echo '<img id="itemiconimg" class="drg" width=100 height=100 src="'.$row["imagepointer"].'" alt="Item!">';

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
    <div class="craftboxmain">
      <div id="overlay">
        <div id="craftmenu">
          <a href="#close" onclick="modalpop('overlay')" title="Close" class="close">X</a>
          Drag three items of the same Item Level below for a chance to craft a higher tier item!<br><br>
          <div class="craftitemscontainer">
            <div id="drop" class="basiccraftitem">

            </div>
            <div id="drop" class="basiccraftitem">

            </div>
            <div id="drop" class="basiccraftitem">

            </div>
            <br><br>
              <input class="initcraft startcraft" disabled type="button" onclick="initcraft()" name="initcraft" value="Drag in Three Items">

          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="homelink" name="homelink" title="homelink">
      <a class="homebutton" href="index.html">Home</a>
    </div>
  </body>
</html>

