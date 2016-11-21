<?php
session_start();
require_once('../model/database.php');

class SessionModel {
	public $userName;
	public $sessionId;
	public $isConnected;
	public $status;
	public $infoText;
	
	function __construct($name = null) {
		if (!empty($name)) {
			$this->userName = $name;
		} else {
			$this->userName = "";
		}
		$this->isConnected = false;
	}
	
	function login($pwd) {
		$this->status = "ERROR";
		$this->isConnected = false;
		$db = new Database();
		$rows = $db->queryData("select username,password from users where username='$this->userName'");
		if (count($rows) == 1) {
			if ($pwd == $rows[0]['password']) {
				$this->sessionId = session_id();
				$this->status = "OK";
				$this->isConnected = true;
			}
		} 
	}
}

$username = (empty($_POST['username'])) ? null : $_POST['username'];
$password = (empty($_POST['password'])) ? null : $_POST['password'];

$model = new SessionModel($username);
$model->login($password);

if ($model->isConnected) {
	// TODO: go to launch page
	$_SESSION['infotext'] = "Congratulations, you're logged in!";
} else {
	$_SESSION['infotext'] = "Invalid login, please try again.";
}
header('Location:./');
