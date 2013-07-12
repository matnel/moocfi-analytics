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
<script src="./jquery.js"></script>

<input id='id' value="<?= $_GET['id']; ?>" /> <input id='color' value="<?= $_GET['color']; ?>" />

<script type="text/javascript">
$().ready( function() {
  $('input').change( function() {
    var _id = $('#id').val()
    var _color = $('#color').val();
    var _t = window.location.origin + window.location.pathname;
    _t += '?id=' + _id + '&color=' + _color;
    window.location.href = _t;
  });
});
</script>

<script>

var margin = {top: 20, right: 20, bottom: 30, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var x = d3.scale.linear()
    .rangeRound([5, width]);
    
var y = d3.scale.linear()
    .rangeRound([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickFormat(d3.format(""));

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
      .attr("transform", "translate(0,150)")
      .call(xAxis);

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis);

  sums.forEach( function(d,i) {
    svg.append("rect")
      .datum( d )
      .attr("x", x(i) )
      .attr("width", x(i+1)-x(i) - 7 )
      .attr("y", y(d) )
      .attr("height", y(0) - y(d) )
      .style("fill", "<?= $_GET['color']; ?>");
  } );

});

</script>

</body>
</html>
