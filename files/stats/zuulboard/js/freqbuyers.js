function createFreqBuyersHistogram(freqBuyers_data) {
  console.log(freqBuyers_data);
  var dataset = freqBuyers_data;
  drawFreqBuyersHisto(dataset);
}

function drawFreqBuyersHisto(dataset) {
  var w           = 350;
  var h           = 250;
  var xPadding    = 25;
  var yPadding    = 40;
  var textPadding = 20;

  // Set X and Y scales for dynamic data handling
  var xScale = d3.scale.ordinal()
              .domain(d3.range(dataset.length))
              .rangeRoundBands([0, w - xPadding], 0.05);


  var yScale = d3.scale.linear()
              .domain([0, d3.max(dataset, function(d)
                { return parseInt(d.numpurchased); })])
              .range([h - yPadding, 0]);



  // Create the SVG canvs
  var svg = d3.select('#freqBuyersContainer')
              .append('svg')
              .attr({width: w, height: h });

  // Create the bars
  svg.selectAll('rect')
    .data(dataset)
    .enter()
    .append('rect')
    .attr('class', 'histoBar')
    .sort(function(a, b) {
      return d3.ascending(a.numpurchased, b.numpurchased);
    })
    .attr('x', function(d, i) {
      return xScale(i) + xPadding;
     })
    .attr('y', function(d) {
      return yScale(d.numpurchased);
    } )
    .attr('height', function(d) {
      return h - yScale(d.numpurchased) - yPadding;
    })
    .attr('width', xScale.rangeBand())
    .attr('fill', 'cornflowerblue')
    .attr('fill-opacity', '0.7')
    .on('mouseover', function(d) {
      var tooltipID = '#freqBuyersToolTip';
      var contentID = '#freqBuyersToolTipTitle';
      var xPosition = parseFloat(d3.select(this).attr('x'));
      var yPosition = parseFloat(d3.select(this).attr('y')) + 50;

      displayTooltip(tooltipID, contentID, xPosition, yPosition, d.username, d.numpurchased);

      d3.select(this)
        .transition()
        .duration(250)
        .attr('fill-opacity', '1');

    })
    .on('mouseout', function(d) {
      var tooltipID = '#freqBuyersToolTip';

      hideTooltip(tooltipID);

      d3.select(this)
        .transition()
        .duration(250)
        .attr('fill-opacity', '0.6');
    });

  // Create the labels
  svg.selectAll('text')
      .data(dataset)
      .enter()
      .append('text')
      .sort(function(a, b) {
        return d3.ascending(a.numpurchased, b.numpurchased);
      })
      .text(function(d) {
        return d.username;
      })
      .attr('x', function(d, i) {
        return xScale(i) + xPadding + textPadding;
      })
      .attr('y', function(d) {
        return 225;
      })
      .attr('pointer-events', 'none')
      .attr('text-anchor', 'middle')
      .attr('font-family', 'sans-serif')
      .attr('font-weight', 'bold')
      .attr('font-size', '9px')
      .attr('fill', 'black');

  // Create the Axes
  var xAxis = d3.svg.axis()
                .scale(xScale)
                .orient('bottom');

  svg.append('g')
      .attr('class', 'x axis xhistoAxis invisAxis')
      .attr('transform', 'translate('+ xPadding +','+ (h - yPadding + 2) + ')')
      .call(xAxis)

  var yAxis = d3.svg.axis()
                .scale(yScale)
                .orient('left');

  svg.append('g')
      .attr('class', 'y axis yhistoAxis')
      .attr('transform', 'translate('+ xPadding +', 0)')
      .call(yAxis)

}

function displayTooltip(tooltipID, contentID, xPosition, yPosition, username, numpurchased) {

  d3.select(tooltipID)
    .style('left', xPosition + 'px')
    .style('top', yPosition + 'px')
    .select(contentID)
    .text(username + ': ' + numpurchased + ' total purchases');

  d3.select(tooltipID).classed('hidden', false);
}

function hideTooltip(tooltipID) {

  d3.select(tooltipID).classed('hidden', true);
}

