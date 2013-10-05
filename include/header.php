<?php 
include 'DbConnector.php';
include 'Dataminer.php';
include 'class.functions.php';

if(!@$_SESSION && empty($_SESSION)){
  session_start();
  $_SESSION['sessionid']=session_id();
}  
?>
