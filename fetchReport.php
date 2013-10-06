<?php
header('content-type: text/json');
//DB conncetions
include 'include/header.php'; 
$connector = new DbConnector();

//Get ajax parameters
$reportId = $_GET["reportId"];

//Processing Logic
$query = "SELECT value FROM kanzi.bonobo_reports WHERE id = ".$reportId." LIMIT 1";
$result = $connector->query($query);
     if($connector->getNumRows($result)>0) {
         while ($row = $connector->fetchArray($result)) { 		
				echo $row[0];
		 }
	}
?>