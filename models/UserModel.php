<?php
require_once('../models/Database.php');

class UserModel 
{
	public $userId;
	public $userName;
	private $password;
	private $db;

	function __construct($usr,$pwd) {
		$this->userName = $usr;
		$this->password = $pwd;
		$this->db = new Database();
	}

	function exists() {
		$rows = $this->db->get("select username from users where username='$this->userName'");
		return count($rows) > 0;
	}

	function register() {
		// Insert a new user record into the database
		// TODO: encrypt passwords in the database
		$sql = "INSERT INTO users (username,password) VALUES ('".$this->userName."', '".$this->password."')";
		return $this->db->create($sql);
	}

	function passwordMatches($pwd) {
		return ($pwd == $this->password);
	}
}

if (empty($_POST['username']) ||
		empty($_POST['password']) ||
		empty($_POST['passwordAgain'])) {

			$_SESSION['infotext'] = 'All fields are required. Please try again';
			header('Location: ../signup.php');
			exit();
		}
