<?php
  require '/home/whopper/dev-whopper/zuulboard/lib/prepareData.php';

  $dbConnection          = new prepareData();
  $dbConnection->connectdb();

  // Gather JSONified data from the MySQL Database to ship off to JavaScript
  $pop_data_prep         = $dbConnection->itemPoptoJSON($dbConnection);
  $freq_buyers_data_prep = $dbConnection->freqBuyerstoJSON($dbConnection);
  $total_rev_data        = $dbConnection->getTotalSpent();
?>

<!DOCTYPE HTML>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/main.css" />
    <link rel="stylesheet" type="text/css" href="style/d3.css" />
    <link rel="stylesheet" type="text/css" href="style/itempop.css" />
    <link rel="stylesheet" type="text/css" href="style/freqbuyers.css" />
    <link rel="stylesheet" type="text/css" href="style/totalrevenue.css" />
    <script type="text/javascript" src="js/itempop.js"></script>
    <script type="text/javascript" src="js/freqbuyers.js"></script>
    <script type="text/javascript" src="js/totalrevenue.js"></script>
    <meta charset="utf-8">
    <script type="text/javascript" src="d3/d3.v3.js"></script>
    <title>ZuulBoard</title>
  </head>
  <body>

    <div id='boardHeader'>
      <p id='boardHeaderTitle'>ZuulBoard</p>
      <p id='boardHeaderSubTitle'>(Real-time Data)</p>
      <hr id=boardHeaderBar'>
    </div>

    <div id='mainContainer'>

      <div id='itemPopContainer' class='metricContainer'>
          <!-- title -->
          <p id='itemPopTitle' class='containerTitle'>All Time Item Popularity</p>
          <hr id='itemPopTitleBar' class='containerTitleBar'>
          <!-- Create Item Popularity Histogram -->
          <script type='text/javascript'>
            var pop_item_data = <?php echo $pop_data_prep; ?>;
            //console.log(pop_item_data);
            createItemPopHistogram(pop_item_data)
          </script>

          <!-- Create hover tooltip for bars -->
          <div id='itemPopToolTip' class='hidden tooltip'>
            <p><strong><span id='itemPopToolTipTitle'</span></strong></p>
          </div>
      </div>

      <div id='freqBuyersContainer' class='metricContainer'>
          <!-- title -->
          <p id='freqBuyersTitle' class='containerTitle'>Most Frequent Buyers</p>
          <hr id='freqBuyersTitleBar' class='containerTitleBar'>
          <!-- Create Item Popularity Histogram -->
          <script type='text/javascript'>
            var freqBuyers_data = <?php echo $freq_buyers_data_prep; ?>;
            //console.log(pop_item_data);
            createFreqBuyersHistogram(freqBuyers_data)
          </script>

          <!-- Create hover tooltip for bars -->
          <div id='freqBuyersToolTip' class='hidden tooltip'>
            <p><strong><span id='freqBuyersToolTipTitle'</span></strong></p>
          </div>
      </div>

      <div id='totalRevenueContainer' class='metricContainer'>
        <!-- title -->
        <p id='totalRevTitle' class='containerTitle'>Total Zuul Revenue</p>
        <hr id=totalRevTitleBar' class='containerTitleBar'>
        <!-- Display total revenue number -->
        <p><strong><span id='totalRevNumber'>$<?php echo $total_rev_data ?></span></strong></p>
      </div>
    </div>
  </body>
</html>
