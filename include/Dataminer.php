<?php
class Dataminer{

	var $connector;
	var $tmpArr;
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
	
	function drillDown($tblName)
	{
		echo "<pre>";
		$connector = new DbConnector();
		$query = "SELECT * FROM flat_table_config WHERE name = '".$tblName."'";
		$result = $connector->query($query);
		$row = $connector->fetchAssocArray($result);
		if($row){
			$resJson = json_decode($row['value']);
			$query=array();
			$groupBy=array();
			foreach($resJson->cardinal_array as $key => $cardinal){	
				$groupBy[]=$key;
				echo $tmpQuery = 'Select count('.$resJson->primary_key.') AS cnt,'.implode(',',$groupBy).' from '.$tblName.' Group By '.implode(',',$groupBy);
				$query[]= $tmpQuery;
				
				
				//run the query to produce JSON report
				$this->tmpArr = array();
				$tmpResult = $connector->query($tmpQuery);
				while($tmpRow = $connector->fetchAssocArray($tmpResult)){
					//$tmpArr[] = 
					
					$tmpA = $this->recFunc($this->tmpArr,$groupBy, $tmpRow);
					
					//print_r($groupBy);
					/*foreach($groupBy as $val){
						$arrIndexStr = "['$tmpRow[$val]']";
						echo $arrIndexStr;
						$tmpArr = recFunc($tmpRow['cnt'];
					}*/
				}
				print_r($tmpA);
				die();
			}	
		
			
		//print_r($query);
		}
	}
	function recFunc($tar, $groups, $row){
		
		//$retArr = array();
		if(count($groups) == 0)
		{
			return($row['cnt']);
		}
		else
		{
			$firstGrp = array_shift($groups);
			//$this->tmpArr[$row[$firstGrp]] = $this->recFunc($groups, $row);
			//return array($row[$firstGrp] => $this->recFunc($groups, $row)); 
			return $tar[$row[$firstGrp]] = $this->recFunc($tar[$row[$firstGrp]],$groups, $row); 
		}
	
	}

}