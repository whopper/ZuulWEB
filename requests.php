<?php

  require "/Library/WebServer/Documents/lib/connectdb.php";
  require "/Library/WebServer/Documents/lib/datasanitizer.php";

  $dbconnection = new connectdb();
  $dbconnection->initiate();

  $error           = FALSE;
  $getcommentquery = "SELECT * FROM comments ORDER BY time_stamp DESC";
  $getcommentdo    = mysql_query($getcommentquery);

  if (!$getcommentdo) {
    exit("&lt;p&gt;MySQL search failure.&lt;/p&gt;");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/main.css" />
    <link rel="stylesheet" type="text/css" href="style/requests.css" />
    <title>Zuul Requests</title>
    <div class="header" name="header" title="Header">
      <img id="requestsbanner" src="images/requestsbanner.png" height=90 width=1300
           alt="Requests Banner">
    </div>
    <hr>
  </head>
  <body>
    <!-- Align to left -->
    <div class="commentinput basicbox" name="commentinput" title="Comment Input">
      Comments or Requests<br>
      <form name="comments" action="addcomment.php" method="post">
        <textarea name="comments"></textarea><br><br>
        <input id="submit" type="submit" name="submit" value="Comment">
      </form>
    </div>
    <!-- Align Center -->
    <div class="readcomments basicbox" name="readcomments" title="Read Comments">
      <?php
        if( (mysql_num_rows($getcommentdo) >= 1)) {
          while($row = mysql_fetch_array($getcommentdo))
            {
              echo "<div class='comment_meta basicbox'>";
              if ( $row['username'] != NULL ) {
                $user = $row['username'];
              } else {
                $user = "Anonymous";
              }
              echo "$user";
              echo " at ";
              echo $row['time_stamp'];
              echo "</div>";
              echo "<div class='comment_content basicbox'>";
              $message = nl2br($row["message"]);
              echo $message;
              echo "</div>";
            }
        }  else {
          echo "No comments";
        }
      ?>
    </div>
    <br>
    <div class="homelinkreq" name="homelinkreq" title="homelink">
      <a class="homebutton" href="index.html">Home</a>
    </div>
  </body>
</html>

