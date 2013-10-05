<?php

class DBManager
{
	private $dbconnection;
	private $dbparams;
	public $isconnected = False;
	
	function __construct($db)
	{
		$this->dbparams = $db;
	}

	public function connect()
	{
		try{
		$this->dbconnection = new PDO($this->dbparams["type"].":host=".$this->dbparams["host"].";dbname=".$this->dbparams["name"].";charset=utf8", $this->dbparams["user"], $this->dbparams["password"]);
		$this->dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->dbconnection->query('select 1;');
		$this->isconnected = True;
	}
	catch (PDOException $e) {
    	//Oops
    	return False;
	}
	return $this->dbconnection;
	}

	public function con()
	{
		return $this->dbconnection;
	}

	public function createTable($name, $cols, $types)
	{
		if(count($cols) != count($types))
			return;

		$sql = "CREATE TABLE IF NOT EXISTS `$name` (";
    	
    	for ($i=0; $i < count($cols); $i++) { $sql.= "`$cols[$i]` $types[$i],"; }
    	$sql = rtrim($sql,',');
    	$sql .= ") CHARACTER SET utf8 COLLATE utf8_general_ci";
		

		$stmt = $this->dbconnection->prepare($sql);
		$stmt->execute();
	}

	public function insertIntoTable($name, $names, $values)
	{
		$cols = "(";
		$vals = "(";

		for ($i=0; $i < count($names); $i++) { 
			$cols .= $names[$i].",";
			$vals .= "\"".$values[$i]."\",";
		}

		$cols = rtrim($cols,',').")";
		$vals = rtrim($vals,',').")";
		
		$sql = "INSERT INTO ".$name." ".$cols." VALUES ".$vals;

		$stmt = $this->dbconnection->prepare($sql);
		$stmt->execute();
	}

}

?>