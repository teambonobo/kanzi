<?php
$db = new DbConnector(); 

class DbConnector {

  var $theQuery;
  var $link;
  
  function DbConnector(){
  // Get the db settings.
  	$host = '127.0.0.1';
  	$db = 'kanzi';
  	$user = 'root';
  	$pass = '';
  // Connect to the database
  	$this->link = mysql_connect($host, $user, $pass);
  	mysql_select_db($db);
  }
  
  // Execute a query 
  function query($query) {
  	$this->theQuery = $query;
  	return mysql_query($query, $this->link);
  }
  
  // Returns the last database query 
  function getQuery() {
  	return $this->theQuery;
  }
  
  // Return row count 
  function getNumRows($result){
  	return mysql_num_rows($result);
  }
  
  // Get array of query results
  function fetchArray($result) {
  	return mysql_fetch_array($result);
  }
  // Get associat array of query results
  function fetchAssocArray($result) {
  	return mysql_fetch_assoc($result);
  } 
  // Close the connection 
  function close() {
  	mysql_close($this->link);
  }
  
}
?>