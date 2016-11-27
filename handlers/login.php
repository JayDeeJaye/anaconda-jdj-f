<?php
session_start();
require_once('../models/SessionModel.php');

$username = (empty($_POST['username'])) ? null : $_POST['username'];
$password = (empty($_POST['password'])) ? null : $_POST['password'];

$user = new SessionModel($username);
$user->login($password);

if ($user->isConnected) {
	// go to the home dashboard
	$_SESSION['userName'] = $username;
	header("Location: ../home.php");
	exit();
} else {
	// Go back to the login page
	$_SESSION['infotext'] = "Invalid login, please try again.";
}
header('Location: ../index.php');
