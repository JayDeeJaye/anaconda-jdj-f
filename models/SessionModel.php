<?php
/*
 * Data model for managing sessions
 */
require_once('../models/Database.php');

class SessionModel 
{
	public $userName;
	public $isConnected;
	public $sessionId;
	private $db;

	// When instantiating the session model, see if there is an existing
	// session and set the state of the instance accordingly
	public function __construct($name = null) {
		if (!empty($name)) {
			$this->userName = $name;
		} else {
			$this->userName = "";
		}
		$this->isConnected = false;
		$this->db = new Database();
		$this->getSession();
	}

	private function getSession() {
		$rows = $this->db->get("SELECT id,username FROM sessions WHERE username='$this->userName'");
		if (count($rows) > 0) {
			$this->sessionId = $rows[0]['id'];
			$this->isConnected = true;
		}
	}
	
	// create the session in the database
	private function addSession() {
		$sql = "INSERT INTO sessions (username) VALUES ('".$this->userName."')";
		if ($this->sessionId = $this->db->create($sql)) {
			return true;
		} else {
			return false;
		}
	}

	// Verify the given password, and create a session if it matches what's
	// in the database for the user
	public function login($pwd) {
		$rows = $this->db->get("SELECT username,password FROM users WHERE username='$this->userName'");
		if (count($rows) == 1) {
			if ($pwd == $rows[0]['password']) {
				if (!$this->isConnected) {
					$this->isConnected = $this->addSession();
				}
			} else {
				$this->isConnected = false;
			}
		}
	}

	// remove the session from the database and set the session instance state
	public function logout() {
		$sql = "DELETE FROM sessions WHERE username = '".$this->userName."'";
		if ($this->db->delete($sql)) {
			$this->isConnected = false;
			unset($this->sessionId);
		}
		return !$this->isConnected;
	}
}
