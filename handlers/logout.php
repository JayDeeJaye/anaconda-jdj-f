<?php
session_start();
require_once('../models/SessionModel.php');
require_once('../models/InvitationModel.php');

$username = $_SESSION['userName'];

try {
	$userSession = new SessionModel($username);

	if ($userSession->isConnected) {
		// Clean up any outstanding invitations by this player
		$invitation = new InvitationModel($username);
		if (!empty($invitation->toPlayer)) {
			$invitation->cancel();
		}
		// Delete all session data and return to the sign-in page
		if ($userSession->logout()) {
			$_SESSION['infotext'] = "See you later, $username. Have a nice day!";
		} else {
			throw new Exception ("Oops! Something bad happened. Contact the administrator");
		}
	}
} catch (Exception $e) {
	$_SESSION['infotext'] = $e->getMessage();
}
header('Location: ../index.php');
