<!DOCTYPE html>
<html manifest="offline.appcache">
<head>
<meta charset="utf-8" />
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../js/jquery-1.10.1.min.js"> </script>
<script src="../js/d3.v3.min.js"></script>
<script src="../js/charts.js"></script>
<script src="../js/tooltip.js"></script>

<link rel="stylesheet" href="../css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="../css/tooltip.css" type="text/css">
<link rel="stylesheet" href="../css/bootstrap-responsive.css" type="text/css">
<link rel="stylesheet" href="../css/styles.css" type="text/css">

</head>

<body>
	<header class="dashboardheader">
        <div class="navbar">
            <div class="navbar-inner">
                 <div>
                   <!-- <a class="brand logotxt" href="index.html">BonoboXYZ</a>-->
                    
                    <ul class="nav pull-right">
                       <ul class="nav nav-pills">
                                        <li class="active">
											<a href="datamin.php">Data Mining</a>
                                        </li>
                                        
                                        
                                	</ul>
                    </ul>                              
                 </div>
            </div>
        </div>
    </header>
                
	<section>
    	<div class="row-fluid">
        	<div id="leftpane" class="span2">
                <div class="logo"><a class="brand" href="index.html"><img src="../img/Bonobo_logo.png"/></a></div>
            	
         	</div>
            
            <div id="dashContainer" class="span10">
            	
                <form action="index.php" method="post">
		File name: <input type="text" style="position: relative; float: left: margin: 10px;" name="filename">
		<br>
		<input type="submit">
	</form>


<?php 
ini_set("display_errors", 1);

require_once 'CSVParse.class.php';
require_once __DIR__.'/../auth/config.php';

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
	$file = $_POST['filename'];

	$csv = new CSVParse($file,$db);
	$csv->init();
}

?>
                
            </div>
        </div>
    </section>	
    
    
<script src="../js/jquery-1.10.1.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/placeholder.js"></script>
<script>
	$(document).ready(function(){
		var winHeight= $(window).height()
		//alert(winHeight);
		//$('#dashContainer').height(winHeight);
		$('#dashContainer').css('min-height', winHeight);
		$('#leftpane').css('min-height', winHeight);
	});
</script>
<style>

circle {
  fill: rgb(31, 119, 180);
  fill-opacity: .25;
  stroke: rgb(31, 119, 180);
  stroke-width: 1px;
}

.leaf circle {
  fill: #ff7f0e;
  fill-opacity: 1;
}

text {
  font: 10px sans-serif;
}

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

text {
  font: 10px sans-serif;
}

</style>
</body>
</html>





	