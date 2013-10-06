<!DOCTYPE HTML>
<head></head>
<body>
	<form action="index.php" method="post">
		File name: <input type="text" style="position: relative; float: left: margin: 10px;" name="filename">
		<br>
		<input type="submit">
	</form>
</body>

<?php 
ini_set("display_errors", 1);

require_once 'CSVParse.class.php';
require_once __DIR__.'/../auth/config.php';

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
	$file = $_POST['filename'];

	$csv = new CSVParse($file,$db);
	$csv->init();
}

?>