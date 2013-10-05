<!DOCTYPE html>
<html>
<head>
<script src="js/jquery-1.10.1.min.js"> </script>
<form>
  <label><input type="radio" name="mode" value="size"> Size</label>
  <label><input type="radio" name="mode" value="count" checked> Count</label>
</form>
<script src="js/d3.v3.min.js"></script>
<script>
$(document).ready(function(){
var reportId = 2;
  $("button").click(function(){
		//renderLayout(reportId);
		//renderSunChart(reportId);
		renderTreeChart(reportId);
    
  });
});


function supportsLocalStorage() {
    return ('localStorage' in window) && window['localStorage'] !== null;
}
// function saveIntolocalStorage(reportId , report) {
  // if (!supportsLocalStorage()) { return false; }
    // localStorage[reportId] = report;
	// renderLayout(reportId,report);
    // return true;
// }

// function fetchFromlocalStorage(reportId) { 
    // if (!supportsLocalStorage()) { alert('Local Storage not supported by the browser!'); }
    // report = localStorage[reportId];
  // if (!report) { alert('No report available'); return false; }
    // renderLayout(report);
    // return true;
// }

function renderLayout(reportId)
{

var diameter = 960,
    format = d3.format(",d");

var pack = d3.layout.pack()
    .size([diameter - 4, diameter - 4])
    .value(function(d) { return d.size; });

var svg = d3.select("body").append("svg")
    .attr("width", diameter)
    .attr("height", diameter)
  .append("g")
    .attr("transform", "translate(2,2)");

d3.json("fetchReport.php?reportId="+reportId, function(error, root) {

var localStprageData = JSON.stringify(root);
	 if(error){
		 alert('Report fetching from localstorage');
		 supportsLocalStorage();
		root = JSON.parse(localStorage[reportId]);
	} else {
		localStorage[reportId] = localStprageData;
	} 
	
  var node = svg.datum(root).selectAll(".node")
      .data(pack.nodes)
    .enter().append("g")
      .attr("class", function(d) { return d.children ? "node" : "leaf node"; })
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

  node.append("title")
      .text(function(d) { return d.name + (d.children ? "" : ": " + format(d.size)); });

  node.append("circle")
      .attr("r", function(d) { return d.r; });

  node.filter(function(d) { return !d.children; }).append("text")
      .attr("dy", ".3em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.name.substring(0, d.r / 3); });
});

d3.select(self.frameElement).style("height", diameter + "px");

}


function renderSunChart(reportId)
{
var width = 960,
    height = 700,
    radius = Math.min(width, height) / 2,
    color = d3.scale.category20c();

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height * .52 + ")");

var partition = d3.layout.partition()
    .sort(null)
    .size([2 * Math.PI, radius * radius])
    .value(function(d) { return 1; });

var arc = d3.svg.arc()
    .startAngle(function(d) { return d.x; })
    .endAngle(function(d) { return d.x + d.dx; })
    .innerRadius(function(d) { return Math.sqrt(d.y); })
    .outerRadius(function(d) { return Math.sqrt(d.y + d.dy); });

d3.json("fetchReport.php?reportId="+reportId, function(error, root) {

	var localStprageData = JSON.stringify(root);
	 if(error){
		 alert('Report fetching from localstorage');
		 supportsLocalStorage();
		root = JSON.parse(localStorage[reportId]);
	} else {
		localStorage[reportId] = localStprageData;
	} 
	
  var path = svg.datum(root).selectAll("path")
      .data(partition.nodes)
    .enter().append("path")
      .attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring
      .attr("d", arc)
      .style("stroke", "#fff")
      .style("fill", function(d) { return color((d.children ? d : d.parent).name); })
      .style("fill-rule", "evenodd")
      .each(stash);

  d3.selectAll("input").on("change", function change() {
    var value = this.value === "count"
        ? function() { return 1; }
        : function(d) { return d.size; };

    path
        .data(partition.value(value).nodes)
      .transition()
        .duration(1500)
        .attrTween("d", arcTween);
  });
});

// Stash the old values for transition.
function stash(d) {
  d.x0 = d.x;
  d.dx0 = d.dx;
}

// Interpolate the arcs in data space.
function arcTween(a) {
  var i = d3.interpolate({x: a.x0, dx: a.dx0}, a);
  return function(t) {
    var b = i(t);
    a.x0 = b.x;
    a.dx0 = b.dx;
    return arc(b);
  };
}

d3.select(self.frameElement).style("height", height + "px");

}

function renderTreeChart(reportId)
{
var diameter = 960;

var tree = d3.layout.tree()
    .size([360, diameter / 2 - 120])
    .separation(function(a, b) { return (a.parent == b.parent ? 1 : 2) / a.depth; });

var diagonal = d3.svg.diagonal.radial()
    .projection(function(d) { return [d.y, d.x / 180 * Math.PI]; });

var svg = d3.select("body").append("svg")
    .attr("width", diameter)
    .attr("height", diameter - 150)
  .append("g")
    .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");

d3.json("fetchReport.php?reportId="+reportId, function(error, root) {

var localStprageData = JSON.stringify(root);
	 if(error){
		 alert('Report fetching from localstorage');
		// supportsLocalStorage();
		 if (!supportsLocalStorage()) { alert('Local storage not supported'); }
		root = JSON.parse(localStorage[reportId]);
	} else {
		localStorage[reportId] = localStprageData;
	} 

  var nodes = tree.nodes(root),
      links = tree.links(nodes);

  var link = svg.selectAll(".link")
      .data(links)
    .enter().append("path")
      .attr("class", "link")
      .attr("d", diagonal);

  var node = svg.selectAll(".node")
      .data(nodes)
    .enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")"; })

  node.append("circle")
      .attr("r", 4.5);

  node.append("text")
      .attr("dy", ".31em")
      .attr("text-anchor", function(d) { return d.x < 180 ? "start" : "end"; })
      .attr("transform", function(d) { return d.x < 180 ? "translate(8)" : "rotate(180)translate(-8)"; })
      .text(function(d) { return d.name; });
});

d3.select(self.frameElement).style("height", diameter - 150 + "px");




}

</script>
</head>
<body>



<div id="div1"><h2></h2></div>
<button>Get Content</button>
<!-- For the Sun chart-->
<!-- style>

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  margin: auto;
  position: relative;
  width: 960px;
}

form {
  position: absolute;
  right: 10px;
  top: 10px;
}

</style -->

<!--For the tree chart -->

<style>

.node circle {
  fill: #fff;
  stroke: steelblue;
  stroke-width: 1.5px;
}

.node {
  font: 10px sans-serif;
}

.link {
  fill: none;
  stroke: #ccc;
  stroke-width: 1.5px;
}
</style>

</body>
</html>