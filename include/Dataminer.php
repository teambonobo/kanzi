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
	
	function drillDown($tblName, $cardinalArr, $reportId)
	{
		$this->connector = new DbConnector();
		$sql = "select value from flat_table_config where name = '$tblName'";
		$ranksRes = $this->connector->query($sql);
		$ranksResRow = $this->connector->fetchAssocArray($ranksRes);
		$rankArray = json_decode(current($ranksResRow));
		$cardinals = $rankArray->cardinal_array;$pivot = $rankArray->primary_key;
		//$this->ranks = array_keys(get_object_vars($cardinals));
		$this->ranks = $cardinalArr;
		
		$options = array("table"=>$tblName,"field"=>$this->ranks[0],'pivot'=>$pivot,'next'=>1);
		
		$arr = '{"name":"'.$this->ranks[0].'","children":['.$this->getChildren($this->ranks[0],$tblName,$pivot,1,array()).']}';
		$queryUpdate = "UPDATE bonobo_reports SET value = '".$arr."' WHERE id = $reportId";
		$this->connector->query($queryUpdate);   
		
		
	}
	function getChildren($field,$tablename,$pivot,$next,$criteria) {
	
	
		
		//$retArray = "{";
		$retArray = "";
		$next++;
		 $countSql = "select count(".$pivot.") cnt,".$field." field from ".$tablename;
		 $where = "";
		 foreach($criteria as $key=>$value) {
			$where .= $where?" AND ":" WHERE ";
			$where .= $key ."='".$value."'";
		 }
		 
		 $countSql .= $where." Group By $field";
		 $countRes = $this->connector->query($countSql);
		 $i = 0;
		while($countResRow = $this->connector->fetchAssocArray($countRes)) {
			$criteria[$field] = $countResRow['field'];
			if(isset($this->ranks[$next])) {
				if($i > 0)
					$retArray .= ",";
					
				$i++;
				$retArray .= '{"name":"'.$countResRow['field'].'","size":"'.$countResRow['cnt'].'"';
				$childData = $this->getChildren($this->ranks[$next],$tablename,$pivot,$next,$criteria);
				//var_dump($childData != '{}');
				if($childData != '{}') {
					$retArray.= ',"children":['.$childData.']';
				}
				$retArray .="}";
			} else {
				if($i > 0)
					$retArray .= ",";
				$i++;
				$retArray .= '{"name":"'.$countResRow['field'].'","size":"'.$countResRow['cnt'].'"}';
			}

		 }
		 return $retArray;
	
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