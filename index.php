<!DOCTYPE html>
<html manifest="offline.appcache">
<head>
<meta charset="utf-8" />
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="js/jquery-1.10.1.min.js"> </script>
<script src="js/d3.v3.min.js"></script>
<script src="js/charts.js"></script>
<script src="js/tooltip.js"></script>

<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="css/tooltip.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css">
<link rel="stylesheet" href="css/styles.css" type="text/css">
<?php  
include 'DashboardAction.php';
$publicResult = getPublicReportEntries(); 
//$privateResult = getPrivateReportEntries();  ?>
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
                <div class="logo"><a class="brand" href="index.html"><img src="img/Bonobo_logo.png"/></a></div>
            	<ul class="nav nav-list menulinks">
                	<li class="nav-header">Reports List</li>
					<?php foreach($publicResult as $k=>$v) { ?>
						<li><a href="javascript:void(0);" onclick="renderSunChart(<?php echo  $v['id']; ?>,'<?php echo $v['report_name']; ?>');" class="reportsTab"><?php echo $v['report_name']; ?></a></li>
					<?php } ?>
              	</ul>
         	</div>
            
            <div id="dashContainer" class="span10">
            	
                <div class="container-fluid">
                	<div class="row-fluid">
                    	<div class="span12">
                        	<div class="contentHeader">
                                <div class="pull-left"></div>
                                <div class="pull-right">
                                	<ul class="nav nav-pills">
                                        <li class="active" id="sunburst">
											<a href="javascript:getReport(1)">Sun Burst</a>
                                        </li>
                                        <li id="dendrograph"><a href="javascript:getReport(2)">Dendrograph</a></li>
                                        
                                	</ul>
                                </div>
                            </div>
							<h1 id="reportTitle" style="text-align:center;margin-left:176px;"></h1>
                            <div class="visualisation" id="visualisation">
                            	
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>	
    
    
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/placeholder.js"></script>
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
