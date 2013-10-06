<?php
//DB conncetions
include 'include/header.php'; 


function getPublicReportEntries()
{
//Processing Logic
$connector = new DbConnector();
$query = "SELECT id,report_name FROM kanzi.bonobo_reports WHERE status = 1";
$result = $connector->query($query);
	 if($connector->getNumRows($result)>0) {
		 while ($row = $connector->fetchArray($result)) { 		
				$data[] = $row;
		 }
	}
	
	return $data;
}


function getPrivateReportEntries()
{
//Processing Logic
$connector = new DbConnector();
$query = "SELECT id,report_name FROM kanzi.bonobo_reports WHERE status = 2";
$result = $connector->query($query);
	 if($connector->getNumRows($result)>0) {
		 while ($row = $connector->fetchArray($result)) { 		
				$data[] = $row;
		 }
	}
	
	return $data;
}

?>