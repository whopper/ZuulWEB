<?php

  define ('DB_USER', 'webdev');
  define ('DB_PASSWORD', 'pass');
  define ('DB_HOST', 'localhost');
  define ('DB_NAME', 'zuul');
  $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
  mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );


if ( isset($_POST['submitadditem'] )) {
  $error = FALSE;
  $newitemname  = $_POST['newitemname'];
  $newitemprice = $_POST['newitemprice'];

  if ( isset($newitemname) && isset($newitemprice)) {
    $newitemname  = trim($newitemname);
    $newitemname  = strip_tags($newitemname);
    $newitemprice = trim($newitemprice);
    $newitemprice = strip_tags($newitemprice);

    // Make sure the item doesn't already exist
    $checkitemquery = "SELECT * FROM inventory WHERE itemname='$newitemname'";
    $checkitemdo    = mysql_query($checkitemquery);
    if( mysql_num_rows($checkitemdo) === 0) {
      $additemquery = "INSERT INTO inventory VALUES ('','$newitemname','$newitemprice')";
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
    $newprice = trim($newprice);
    $newprice = strip_tags($newprice);

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
    $newbalance    = trim($newbalance);
    $newbalance    = strip_tags($newbalance);
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

  <html>
    <title>
      Thank you for your submission!
    </title>
    <body bgcolor="black" text="white".
        link="green" vlink="purple" alink="purple">


          <p align="center">Thanks!
            Your changes were successful.</p>
          <p align="center"><a href="../index.html">Home</a></p>
      </body>
    </html>

<?php else: ?>
<html>
  <BODY bgcolor="black" text="white".
      link="green" vlink="purple" alink="purple">
      <title>
        Error! :(
      </title>
      <head>
        <p align="center">Data processing failed! You probably didn't fill out all of the required forms!</p>
        <p align="center"><a href="../index.html">Home</a></p>
      </head>

<?php endif; ?>

