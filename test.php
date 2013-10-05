<?php 

//echo strtotime("01/01/1990");

//echo "<br>";

//echo strtotime("05/10/2013");
include 'include/header.php'; 




$connector = new DbConnector();
$query = "SELECT * FROM employeemaster";
$result = $connector->query($query);
     if($connector->getNumRows($result)>0) {
         while ($row = $connector->fetchArray($result)) { 
		 
		 $int= mt_rand(631148400,1368136800);


		$string = date("Y-m-d",$int);
		
		
		$connector->query("UPDATE employeemaster SET DateofJoining = '".$string."' WHERE employeecode = ".$row["employeecode"]);
		 
		 
		 }
	}
	

?>