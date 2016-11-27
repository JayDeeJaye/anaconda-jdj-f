<?php

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
	
$user = new UserModel($username,$password);
if ($user->exists()) {
	$_SESSION['infotext'] = $username.' exists already. Please pick another username';
	// TODO: generate a full absolute location, such as
	/* Redirect to a different page in the current directory that was requested */
	// 	$host  = $_SERVER['HTTP_HOST'];
	// 	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	// 	$extra = 'mypage.php';
	// 	header("Location: http://$host$uri/$extra");
	// 	exit;
		
	header('Location: ../signup.php');
	exit();
}

if (!$user->passwordMatches($confirmPwd)) {
	$_SESSION['infotext'] = 'Passwords do not match. Please try again';
	header('Location: ../signup.php');
	exit();
}	

if ($user->register()) {
	// Start up the new user's session
	$session = new SessionModel($username);
	$session->login($password);
	
	if ($session->isConnected) {
	// Go into the dashboard
		$_SESSION['userName'] = $username;
		header('Location: ../home.php');
		exit();
	}
}

$_SESSION['infotext'] = 'Oops! Something bad happened. Contact the administrator';
header('Location: ../signup.php');
