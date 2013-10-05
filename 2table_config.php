<?php include 'include/header.php'; 
	$dataMineObj = new DataMiner();
	$arr = $dataMineObj->parse_2table('employeemaster','attendance');
	echo "<pre>";print_r(json_decode($arr));
	
	
?>