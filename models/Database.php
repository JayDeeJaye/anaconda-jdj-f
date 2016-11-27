<?php
class Database 
{
	private $dbHost = "localhost";
	private $dbName = "warzone";
	private $dbUser = "warzone";
	private $dbPassword = "";
	private $dbConn;
	
	// Connect to the database on instantiation
	function __construct() {
		$this->dbConn = mysqli_connect($this->dbHost,$this->dbUser,$this->dbPassword,$this->dbName);
	}

	// Execute a query and return all results in an array of associative arrays
	function get($sql) {
		$result = array();
		$res = $this->dbConn->query($sql);
		while ($row = $res->fetch_assoc()) {
			$result[] = $row;
		}
		return $result;
	}
	
	function create($sql) {
		if ($this->dbConn->query($sql)) {
			return $this->dbConn->insert_id;
		} else {
			return false;
		}
	}
	
	function delete($sql) {
		return $this->dbConn->query($sql);
	}
	
	// Close the connection when it's no longer referenced
	function __destruct() {
		$this->dbConn->close();
	}
}