<?php
include 'include/header.php'; 
if(!empty($_REQUEST['list'])){
	$dataMineObj = new DataMiner();
	$dbName = $_REQUEST['database'];
	$dataMineObj->parse_table($dbName.".".$_REQUEST['list']);
	//Insert INto reports table
	$connector = new DbConnector();
	$queryInsert = "INSERT INTO kanzi.bonobo_reports (report_name, description) VALUES ('".$_REQUEST['Name']."', '".$_REQUEST['Description']."')";
	$connector->query($queryInsert);   
	$Id=mysql_insert_id();
	header('Location:drillDown.php?id='.$Id.'&table='.$dbName.'.'.$_REQUEST['list']);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Data Mining</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css">
<link rel="stylesheet" href="css/styles.css" type="text/css">
</head>

<body>
<div class="page-wrap">
	<header class="header">	
    	<div class="navbar navbar-fixed-top">
        	<div class="navbar-inner">
        		<div class="container-fluid txtcenter">
                	<a class="brand fnone" href="#"><img src="img/Bonobo_logo.png"/></a>
                </div>
            </div>
        </div>
   	</header>

   	<section class="container-fluid dataform">
    	<div class="row-fluid">
            	<form name="data" class="form-horizontal" method="post" action="">
                    <div class="control-group">
                        <label class="control-label">Database</label>
                        <div class="controls">
							 <input type="text" placeholder="" autocomplete="on" list="dblist" name="database" id="dbinput">
                             <datalist id="dblist">
							 <?php 	
									$connector = new DbConnector();
									$query = "show databases";
									$result = $connector->query($query);
									while ($row = $connector->fetchArray($result)) { 
										echo "<option value='".$row[0]."'>";
									}
								?>
                            </datalist>
						</div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Dataset</label>
                        <div class="controls">
							 <input type="text" placeholder="" autocomplete="on" list="datalist" name="list">
                             <datalist id="datalist">
							 <?php 	
									/*$connector = new DbConnector();
									$query = "Show Tables IN kanzi";
									$result = $connector->query($query);
									while ($row = $connector->fetchArray($result)) { 
										echo "<option value='".$row[0]."'>";
									}*/
								?>
                            </datalist>
						</div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls">
                        	<input type="text" placeholder="" name="Name">
                        </div>
                   </div>
                    
                   <div class="control-group">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <textarea rows="3" name="Description"></textarea>
                        </div>
                    </div> 
                    
                    <div class="control-group">
                    	<label class="control-label"></label>
                        <div class="controls">
                            <button type="submit" class="btn btn-primary btn-custom">Submit</button>
                        </div>
                    </div>
            </form>
        </div>
    </section>
  
</div>
    
    <footer class="footer">
    	<div class="txtcenter">
    		<div>Designed and Powered by <a href="#">Bonobo</a></div>
        	<div>&copy;2013 Bonobo. All rights reserved. </div>
        </div>
    </footer>
<script src="http://code.jquery.com/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){

$("#dbinput").change( function() {
$("#datalist").html("");
$.ajax({
type: "POST",
data: "data=" + $(this).val(),
url: "dbtables.php",
success: function(msg){
if (msg != ""){
$("#datalist").html(msg);
}
}
});
});
});
</script>
<script src="js/bootstrap.js"></script>
<script src="js/placeholder.js"></script>
</body>
</html>
