<?php

session_start();
require_once('../model/database.php');

class UserModel {
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
		return true;
	}
	
	function passwordMatches($pwd) {
		return ($pwd == $this->password);
	}
}

if (empty($_POST['username']) || 
	empty($_POST['password']) ||
	empty($_POST['passwordAgain'])) {
		
	$_SESSION['infotext'] = 'All fields are required. Please try again';
	header('Location: /signup.php');
}

$username = $_POST['username'];
$password = $_POST['password'];
$confirmPwd = $_POST['passwordAgain'];
	
$model = new UserModel($username,$password);
if ($model->exists()) {
	$_SESSION['infotext'] = $username.' exists already. Please pick another username';
	// TODO: generate a full absolute location, such as
	/* Redirect to a different page in the current directory that was requested */
	// 	$host  = $_SERVER['HTTP_HOST'];
	// 	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	// 	$extra = 'mypage.php';
	// 	header("Location: http://$host$uri/$extra");
	// 	exit;
		
	header('Location: /signup.php');
}

if (!$model->passwordMatches($confirmPwd)) {
	$_SESSION['infotext'] = 'Passwords do not match. Please try again';
	header('Location: /signup.php');
}	

if ($model->register()) {
	// TODO: redirect to game dashboard
	$_SESSION['infotext'] = 'Congratulations! You\'re a Player';
	header('Location: /signup.php');
} else {
	$_SESSION['infotext'] = 'Oops! Something bad happened. Contact the administrator';
	header('Location: /signup.php');
}
