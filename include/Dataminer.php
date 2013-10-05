<?php
class Dataminer{

	var $connector;

	function parse_table($tblName)
	{
		$connector = new DbConnector();
		
		$returnArr = array();
		//Get the total count of records
		$query = "SELECT count(*) as tableCount FROM ".$tblName;
		$countResult = $connector->query($query);
		if(!$countResult)
		{
			$returnArr['status'] = 0;
			$returnArr['error_message'] = "Invalid table name";
			return json_encode($returnArr);
		}
		
		//check if table entry exists in flat_table_config
		$query = "SELECT * FROM flat_table_config WHERE name = '".$tblName."'";
		$result = $connector->query($query);
		$row = $connector->fetchAssocArray($result);
		if($row)
		{
			$resJson = $row['value'];
			return $resJson;
		}
		else
		{
			$tableCountRow = $connector->fetchAssocArray($countResult);
			$tableCount=$tableCountRow['tableCount'];
			
			$query = "DESCRIBE ".$tblName;
			$result = $connector->query($query);     
			$primaryKey = '';
			$cardinal = array(); //[Table field name][Distinct Values]
			//Loop through all the table fields 
			while ($row = $connector->fetchAssocArray($result)) { 
				if($row['Key']!='PRI'){ //Get the primary Key
					$query = "SELECT count(distinct(".$row['Field'].")) as cnt FROM ".$tblName;
					$distinctResult = $connector->query($query);
					$distinctRow = $connector->fetchAssocArray($distinctResult);
					if(($tableCount-$distinctRow['cnt'])>0){ //Get the Cardinal Values
						$cardinal[$row['Field']] = $distinctRow['cnt'];			
					}
				 }else{
					$primaryKey=$row['Field'];
				 }
			}
			asort($cardinal);
			$returnArr['status'] = 1;
			$returnArr['primary_key'] = $primaryKey;
			$returnArr['cardinal_array'] = $cardinal;
			$resJson = json_encode($returnArr);
			
			$queryInsert = "INSERT INTO flat_table_config (name, value) VALUES ('".$tblName."', '".$resJson."')";
			$connector->query($queryInsert);   
			return json_encode($resJson);			
		}
		return true;
		
	}
}