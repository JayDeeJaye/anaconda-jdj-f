<?php
require_once("../config.php");
class Database 
{
	private $dbHost = DBHOST;
	private $dbName = DBNAME;
	private $dbUser = DBUSER;
	private $dbPassword = DBPASS;
	private $dbConn;
	
	// Connect to the database on instantiation
	function __construct() {
		$this->dbConn = mysqli_connect($this->dbHost,$this->dbUser,$this->dbPassword,$this->dbName);
	}

	// Execute a query and return all results in an array of associative arrays
	function get($sql) {
		$result = array();
		if ($res = $this->dbConn->query($sql)) {
			while ($row = $res->fetch_assoc()) {
				$result[] = $row;
			}
		} else {
			throw new Exception(mysqli_error($this->dbConn));
		}
		return $result;
	}
	
	function create($sql) {
		if ($this->dbConn->query($sql)) {
			return $this->dbConn->insert_id;
		} else {
			throw new Exception(mysqli_error($this->dbConn));
		}
	}
	
	// Execute a delete statement against the database
	function delete($sql) {
		if ($this->dbConn->query($sql)) {
			return true;
		} else {
			throw new Exception(mysqli_error($this->dbConn));
		}
	}
	
	// Execute an update statement against the database
	function update($sql) {
		if ($this->dbConn->query($sql)) {
			return true;
		} else {
			throw new Exception(mysqli_error($this->dbConn));
		}
	}
	
	// Close the connection when it's no longer referenced
	function __destruct() {
		$this->dbConn->close();
	}
}