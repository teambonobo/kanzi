<?php 
header('content-type:text/json');
include 'include/header.php'; 
	$dataMineObj = new DataMiner();
	//$arr = $dataMineObj->parse_table('employeemaster');
	//echo "<pre>";print_r(json_decode($arr));
	
	$dataMineObj->drillDown('employeemaster');
	
	
?>