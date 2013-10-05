<?php

require_once __DIR__."/../auth/DBManager.php";

class CSVParse
{	
	private $dbparams;
	private $cols;
	private $types;

	function __construct($filename, $db, $title = '')
	{
		$this->filename = $filename;
		$this->cols = array();

		//Database params
		$this->dbparams = $db;
	}

	function init()
	{
		$this->file = fopen($this->filename, "r");

		$dbcon = (new DBManager($this->dbparams));
		$dbh = $dbcon->connect();
		if($dbh != False){
			echo "Connected!";
		}

		if($this->file != FALSE)
		{
			$data = fgetcsv($this->file);
			$len = count($data);
			for ($i=0; $i < $len; $i++) { 
				$this->cols[$i] = $data[$i];
				$this->types[$i] = 'BIGINT';
			}
		

		var_dump($this->cols);
		echo "<br>";
		for ($i=0; $i < 10; $i++) { 
			if((($data = fgetcsv($this->file)) != FALSE) || (($data = fgetcsv($this->file)) != NULL))
			{
				for ($j=0; $j < count($data); $j++) { 
					echo $data[$j]."| ";
					if(!is_numeric($data[$j])){
						$this->types[$j] = 'TEXT';
					}
					else
					{
						if((string)(float)$data[$j] != (string)(int)(float)$data[$j])
							$this->types[$j] = 'FLOAT';
					}
				}
				echo "<br>";
			}
			else
				break;
		}

		echo "<br>";
		var_dump($this->types);

		$dbcon->createTable(substr($this->filename,0,-4),$this->cols,$this->types);

		$this->file = fopen($this->filename, "r");
		fgetcsv($this->file);
		for ($i=0;; $i++) { 
			if((($data = fgetcsv($this->file)) != FALSE) || (($data = fgetcsv($this->file)) != NULL))
			{
				$dbcon->insertIntoTable(substr($this->filename,0,-4),$this->cols,$data);
			}
			else
				break;
		}

	}

	}
}

?>