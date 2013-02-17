<?php

  class connectdb {
    function initiate() {
      define ('DB_USER', 'webdev');
      define ('DB_PASSWORD', 'pass');
      define ('DB_HOST', 'localhost');
      define ('DB_NAME', 'zuul');
      $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
      mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );
    }
  }
?>
