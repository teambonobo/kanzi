<?php

/**
* 
*/
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

}

?>