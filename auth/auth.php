<?php

ini_set("display_errors", 1);

require_once 'DBManager.php';
require_once 'config.php';

$dbcon = (new DBManager($db));
$dbh = $dbcon->connect();
if($dbh != False){
		//echo "Connected!";
}
else {
	echo "Connecton failed";
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$id = $_POST['id'];
	$pass = md5($_POST['password']);
	
	$stmt = $dbh->prepare("SELECT id from Users where name=:name and pass=:password");
	
	$stmt->bindParam(':name', $id, PDO::PARAM_STR);
    $stmt->bindParam(':password', $pass, PDO::PARAM_STR, 40);
	
	$stmt->execute();
	$user_id = $stmt->fetchColumn();
	
	if($user_id == false)
    {
    	//echo 'Login Failed';
    	header("Location: ../index.php?login=failed");
    }
	else
    	//header("Location: ../index.php?login=success");
    	header("Location: ../Dashboard.html");
	
}

?>