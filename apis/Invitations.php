<?php
	require_once('apiHeader.php');
	require_once('../models/InvitationModel.php');

	switch($verb) {
		case 'POST':
			try {
				$invitation = new InvitationModel($params['inviter'],$params['invited']);
				$id = $invitation->invitePlayer();
				$status = "201";
				$url="apis/Invitations.php/1";
				$header="Location: $url; Content-Type: application/json";
				$data['id']=$id;
			} catch (Exception $e) {
				throw new Exception($e->getMessage(),500);
			}
			break;
		default:
			throw new Exception("$verb not implemented","405");
	}
	// send the response
	
	if (isset($data)) {
		echo json_encode($data,JSON_PRETTY_PRINT);
	}
