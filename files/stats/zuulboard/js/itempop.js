function createItemPopHistogram(pop_item_data) {

  console.log(pop_item_data);
  var dataset = pop_item_data; // global variable to hold JSON data once loaded
  drawPopHisto(dataset); // Draw the graph

}

function drawPopHisto(dataset) {
  var w           = 350;
  var h           = 250;
  var xPadding    = 40;
  var yPadding    = 25;
  var textPadding = 10;

  // Set X and Y scales for dynamic data handling
  var xScale = d3.scale.linear()
              .domain([0, d3.max(dataset, function(d)
                { return parseInt(d.purchased); })])
              .range([0, w - 10]);

  var yScale = d3.scale.ordinal()
                .domain(d3.range(dataset.length))
                .rangeRoundBands([0, h - yPadding], 0.05);


  // Create the SVG canvs
  var svg = d3.select('#itemPopContainer')
              .append('svg')
              .attr({width: w, height: h });


  // Create the bars
  svg.selectAll('rect')
    .data(dataset)
    .enter()
    .append('rect')
    .attr('class', 'itemPopBar histoBar')
    .attr('x', 5)
    .attr('y', function(d, i) {
      return yScale(i);
    })
    .attr('width', function(d) {
      return xScale(d.purchased)
    })
    .attr('height', yScale.rangeBand())
    .attr('fill', 'cornflowerblue')
    .attr('fill-opacity', '0.7')
    .on('mouseover', function(d) {
      var tooltipID = '#itemPopToolTip';
      var contentID = '#itemPopToolTipTitle';
      var xPosition = parseFloat(d3.select(this).attr('x')) + 60;
      var yPosition = parseFloat(d3.select(this).attr('y'));

      displayTooltip(tooltipID, contentID, xPosition, yPosition, d.itemname, d.purchased);

      d3.select(this)
        .transition()
        .duration(250)
        .attr('fill-opacity', '1');

    })
    .on('mouseout', function(d) {
      var tooltipID = '#itemPopToolTip';

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
      .text(function(d) {
        return d.itemname;
      })
      .attr('x', 6)
      .attr('y', function(d, i) {
        return yScale(i) + textPadding
      })
      .attr('pointer-events', 'none')
      .attr('text-anchor', 'left')
      .attr('font-family', 'sans-serif')
      .attr('font-weight', 'bold')
      .attr('font-size', '9px')
      .attr('fill', 'black');


  // Create the Axes
  var xAxis = d3.svg.axis()
                .scale(xScale)
                .orient('bottom');

  svg.append('g')
      .attr('class', 'x axis xhistoAxis')
      .attr('transform', 'translate(5,'+ (h - 20) + ')')
      .call(xAxis)

  var yAxis = d3.svg.axis()
                .scale(yScale)
                .orient('left');

  svg.append('g')
      .attr('class', 'y axis yhistoAxis')
      .attr('transform', 'translate(0, 5)')
      .call(yAxis)

}

function displayTooltip(tooltipID, contentID, xPosition, yPosition, itemname, purchased) {

  d3.select(tooltipID)
    .style('left', xPosition + 'px')
    .style('top', yPosition + 'px')
    .select(contentID)
    .text(itemname + ': ' + purchased + ' purchased');

  d3.select(tooltipID).classed('hidden', false);
}

function hideTooltip(tooltipID) {

  d3.select(tooltipID).classed('hidden', true);
}

