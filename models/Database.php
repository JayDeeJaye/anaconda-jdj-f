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
	
	/**
	 * Execute a delete statement against the database
	 * 
	 * @param string $sql The DELETE statement to execute
	 * 
	 * @throws Exception Error thrown by the statement, if any
	 * 
	 * @return boolean If true, the statement succeeded, false otherwise
	 */
	function delete($sql) {
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