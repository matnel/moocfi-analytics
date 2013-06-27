<!DOCTYPE html>
<meta charset="utf-8">
<style>

body {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.bar {
  fill: steelblue;
}

.x.axis path {
  display: none;
}

</style>
<body>
<script src="./d3.v3.js"></script>
<script>

var margin = {top: 20, right: 20, bottom: 30, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .rangeRound([height, 0]);

var color = d3.scale.ordinal()
    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickFormat(d3.format(".2s"));

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("../data/points-set<?= $_GET['id']; ?>.json", function(error, data) {

  data = data["<?= $_GET['color']; ?>"];
  sums = [];
  data[0].forEach(function(i){
    sums.push(0);
  });

  data.forEach(function(d) {
    for(var i = 0; i < d.length; i++ ) {
      if( d[i] ){
        sums[i] += 1;
      }
    }
  });

  x.domain([0, data[0].length ] );
  y.domain([0, data.length ] );

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis);

  sums.forEach( function(d,i) {
    svg.append("rect")
      .datum( d )
      .attr("x", 15 * i )
      .attr("width", "10")
      .attr("y", y(d) )
      .attr("height", y(0) - y(d) )
      .style("fill", "blue");
  } );

});

</script>

</body>
</html>
