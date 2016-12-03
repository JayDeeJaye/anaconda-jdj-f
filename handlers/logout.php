<?php
session_start();
require_once('../models/SessionModel.php');

$username = $_SESSION['userName'];

try {
	$user = new SessionModel($username);

	if ($user->isConnected) {
		// Delete all session data and return to the sign-in page
		if ($user->logout()) {
			$_SESSION['infotext'] = "See you later, $username. Have a nice day!";
		} else {
			throw new Exception ("Oops! Something bad happened. Contact the administrator");
		}
	}
} catch (Exception $e) {
	$_SESSION['infotext'] = $e->getMessage();
}
header('Location: ../index.php');
