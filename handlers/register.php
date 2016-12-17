<?php
/*
 * Signup handler. Create new user and sign her in
 */

session_start();
require_once('../models/UserModel.php');
require_once('../models/SessionModel.php');

if (empty($_POST['username']) ||
	empty($_POST['password']) ||
	empty($_POST['passwordAgain'])) {

	$_SESSION['infotext'] = 'All fields are required. Please try again';
	header('Location: ../signup.php');
	exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
$confirmPwd = $_POST['passwordAgain'];

// Stay here unless we get a valid registration and login
$url = '../signup.php';

try {
	$userSession = new UserModel($username,$password);
	if ($userSession->exists()) {
		throw new Exception("$username exists already. Please pick another username");
	}
	
	if (!$userSession->passwordMatches($confirmPwd)) {
		throw new Exception("Passwords do not match. Please try again");
	}	
	
	if ($userSession->register()) {
		// Start up the new user's session
		$session = new SessionModel($username);
		$session->login($password);
		
		if ($session->isConnected) {
		// Go into the dashboard
			$_SESSION['userName'] = $username;
			$url = '../home.php';
		}
	}
} catch (Exception $e) {
	$_SESSION['infotext'] = $e->getMessage();
}
header("Location: $url");
