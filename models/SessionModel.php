<?php
require_once('../models/Database.php');

class SessionModel 
{
	public $userName;
	public $isConnected;
	public $sessionId;
	private $db;

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
			$this->status = "OK";
			$this->isConnected = true;
		}
	}
	
	private function addSession() {
		$sql = "INSERT INTO sessions (username) VALUES ('".$this->userName."')";
		if ($this->sessionId = $this->db->create($sql)) {
			return true;
		} else {
			return false;
		}
	}

	public function login($pwd) {
		// TODO: Add password encryption
		$this->isConnected = false;
		$rows = $this->db->get("SELECT username,password FROM users WHERE username='$this->userName'");
		if (count($rows) == 1) {
			if ($pwd == $rows[0]['password']) {
				$this->status = "OK";
				$this->isConnected = $this->addSession();
			}
		}
	}
	
	public function logout() {
		$sql = "DELETE FROM sessions WHERE username = '".$this->userName."'";
		if ($this->db->delete($sql)) {
			$this->isConnected = false;
			unset($this->sessionId);
		}
		return $this->isConnected;
	}
}