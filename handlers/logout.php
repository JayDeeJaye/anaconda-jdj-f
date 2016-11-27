<?php
session_start();
require_once('../models/SessionModel.php');

$username = $_SESSION['userName'];

$user = new SessionModel($username);

header('Location: ../index.php');

if ($user->isConnected) {
	// Delete all session data and return to the sign-in page
	if (!$user->logout()) {
		exit("Oops! Something bad happened. Contact the administrator");
	}
}
