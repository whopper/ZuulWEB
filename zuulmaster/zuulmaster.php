<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  require "/Library/WebServer/Documents/lib/datasanitizer.php";

  $dbconnection = new connectdb();
  $dbconnection->initiate();

  if ( isset($_POST['submitadditem'] )) {
    $error = FALSE;
    $newitemname  = $_POST['newitemname'];
    $newitemprice = $_POST['newitemprice'];

    if ( isset($newitemname) && isset($newitemprice)) {
      $sanitizer    = new datasanitizer();
      $newitemname  = ($sanitizer->sanitize($newitemname));
      $newitemprice = ($sanitizer->sanitize($newitemprice));

      // Make sure the item doesn't already exist
      $checkitemquery = "SELECT * FROM inventory WHERE itemname='$newitemname'";
      $checkitemdo    = mysql_query($checkitemquery);
      if( mysql_num_rows($checkitemdo) === 0) {
        $additemquery = "INSERT INTO inventory VALUES ('','$newitemname','$newitemprice', 0)";
        $additemdo    = mysql_query($additemquery);
        if (!$additemdo) {
          exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
        } else {
          mysql_close();
        }
      } else
        $error = TRUE;
      }

  } elseif (isset($_POST['submitchangeprice'] )) {
    $error = FALSE;
    $newprice   = $_POST['newprice'];
    $itemselect = $_POST['itemselect'];
    if ( isset($newprice)) {
      $sanitizer = new datasanitizer();
      $newprice  = ($sanitizer->sanitize($newprice));

      $updatepricequery = "UPDATE inventory SET itemprice ='$newprice' WHERE itemname = '$itemselect'";
      $updatepricedo    = mysql_query($updatepricequery);

      if (!$updatepricedo) {
        exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
      } else {
        mysql_close();
      }
    } else {
      $error = TRUE;
    }

  } elseif (isset($_POST['submitremoveitem'] )) {
    $error = FALSE;
    $itemselect = $_POST['itemselect'];
    if ( isset($itemselect)) {
      $removequery   = "DELETE FROM inventory WHERE itemname='$itemselect'";
      $removequerydo = mysql_query($removequery);

      if (!$removequerydo) {
        exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
      } else {
        mysql_close();
      }
    } else {
      $error = TRUE;
    }

  } elseif (isset($_POST['submitchangebalance'] )) {
    $error      = FALSE;
    $userselect = $_POST['userselect'];
    $newbalance = $_POST['newbalance'];
    if ( isset($userselect) && isset($newbalance)) {
      $sanitizer  = new datasanitizer();
      $newbalance = ($sanitizer->sanitize($newbalance));
      $updatequery   = "UPDATE users SET userbalance = '$newbalance' WHERE username = '$userselect'";
      $updatequerydo = mysql_query($updatequery);

      if (!$updatequerydo) {
         exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
       } else {
         mysql_close();
       }
    } else {
      $error = TRUE;
    }

  } elseif (isset($_POST['submitremoveuser'] )) {
    $error      = FALSE;
    $userselect = $_POST['userselect'];
    if ( isset($userselect)) {
      $removequery   = "DELETE FROM users WHERE username='$userselect'";
      $removequerydo = mysql_query($removequery);
      if (!$removequerydo) {
         exit("&lt;p&gt;MySQL Insertion failure.&lt;/p&gt;");
       } else {
         mysql_close();
       }

    } else {
      $error = TRUE;
    }

  } else {
    mysql_close();
  }
?>

<?php if($error === FALSE): ?>
  <!DOCTYPE html>
  <html>
    <head>
      <link rel="stylesheet" type="text/css" href="../style/main.css" />
      <title>Thank you for your submission!</title>
    </head>
    <body>
      <div class="endmessage basicbox">
          Success!
      </div>
      <br>
      <div class="homelink" name="homelink" title="homelink">
        <a class="homebutton" href="../index.html">Home</a>
      </div>
    </body>
  </html>

<?php else: ?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Error! :(</title>
      <p align="center">Data processing failed! You probably didn't fill out
                        all of the required forms!
      <a href="../index.html">Home</a></p>
    </head>
    <body bgcolor="black" text="white".
        link="green" vlink="purple" alink="purple">
    </body>
<?php endif; ?>
