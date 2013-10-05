<?php 

ini_set("display_errors", 1);

require_once 'CSVParse.class.php';
require_once __DIR__.'/../auth/config.php';

$csv = new CSVParse('emp.csv',$db);
$csv->init();

?>