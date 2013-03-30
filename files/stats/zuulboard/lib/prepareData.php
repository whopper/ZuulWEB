<!-- prepareData.php
  Flush data from ZuulWeb DB into JSON files for easy parsing by D3
-->

<?php

  class prepareData {
    function connectdb() {
      define ('DB_USER', 'whopper');
      define ('DB_PASSWORD', 'pass');
      define ('DB_HOST', 'localhost');
      define ('DB_NAME', 'zuul');
      $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) or die('Failure: ' . mysql_error() );
      mysql_select_db(DB_NAME) or die ('Could not select database: ' . mysql_error() );
    }

    function prepareJSON($dbResult) {
      $data = array();
      for ($x = 0; $x < mysql_num_rows($dbResult); $x++) {
        $data[] = mysql_fetch_assoc($dbResult);
      }

      return json_encode($data);
      mysql_close($dbc);

    }

    function itemPoptoJSON($self_obj) {
      $extractQuery   = 'SELECT itemname, purchased FROM inventory ORDER BY purchased DESC';
      $extractQuerydo = mysql_query($extractQuery);

      if (! $extractQuery ) {
        echo mysql_error();
        die;
      } else {
        $data = $self_obj->prepareJSON($extractQuerydo);
        return $data;
      }
    }

    function freqBuyerstoJSON($self_obj) {
      $extractQuery   = 'SELECT username, numpurchased FROM users ORDER BY numpurchased DESC LIMIT 7';
      $extractQuerydo = mysql_query($extractQuery);

      if (! $extractQuery ) {
        echo mysql_error();
        die;
      } else {
        $data = $self_obj->prepareJSON($extractQuerydo);
        return $data;
      }
    }

    function getTotalSpent($self_obj) {
      $allitemq    = "SELECT itemprice,purchased from inventory;";
      $allitemdo   = mysql_query($allitemq);
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
      return $total;
    }
  }
?>
