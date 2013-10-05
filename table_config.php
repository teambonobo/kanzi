<?php include 'include/header.php'; 
	$dataMineObj = new DataMiner();
	$arr = $dataMineObj->parse_table('employeemaster');
	echo "<pre>";print_r(json_decode($arr));
	
	
?>