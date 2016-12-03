<?php
session_start();
require_once('../models/SessionModel.php');

$username = (empty($_POST['username'])) ? null : $_POST['username'];
$password = (empty($_POST['password'])) ? null : $_POST['password'];

$url = '../index.php';
try {
	$user = new SessionModel($username);
	$user->login($password);

	if ($user->isConnected) {
		// go to the home dashboard
		$_SESSION['userName'] = $username;
		$url = '../home.php';
	} else {
		throw new Exception("Invalid login, please try again.");
	}
} catch (Exception $e) {
	$_SESSION['infotext'] = $e->getMessage();
}
header("Location: $url");
