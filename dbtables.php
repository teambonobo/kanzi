<?php
include 'include/header.php'; 
if(!empty($_POST['data'])){
	
	$connector = new DbConnector();
	$query = "Show Tables IN ".$_POST['data'];
	$result = $connector->query($query);
	while ($row = $connector->fetchArray($result)) { 
		echo "<option value='".$row[0]."'>";
	}
}