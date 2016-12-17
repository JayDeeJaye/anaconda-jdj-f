<?php
	require_once('apiHeader.php');
	require_once('../models/InvitationModel.php');

	switch($verb) {
		case 'GET':
			if (isset($url_pieces[1])) {
				// GET one
				try {
					$data = new InvitationModel($url_pieces[1]); 
					if ($data->status == InvitationModel::INV_ST_NONE) {
						throw new Exception("Not Found",404);
					} else {
						header("Content-Type: application/json",null,"200");
					}
				} catch (Exception $e) {
					if (!$responseCode = $e->getCode()) {
						$responseCode = 500;
					}
					throw new Exception($e->getMessage(),$responseCode);
				}
			}
			break;

		case 'POST':
			try {
				$invitation = new InvitationModel($params['fromPlayer'],$params['toPlayer']);
				$id = $invitation->invitePlayer();
				$status = "201";
				$url="apis/Invitations.php/".$invitation->fromPlayer;
				$header="Location: $url; Content-Type: application/json";
				$data['id']=$id;
			} catch (Exception $e) {
				throw new Exception($e->getMessage(),500);
			}
			break;

		case 'PUT':
			try {
				$invitation = new InvitationModel($params['fromPlayer'],$params['toPlayer']);
				$invitation->status = $params['status'];
				$invitation->update();
				$url="api/Invitations/".$invitation->fromPlayer;
				header("Location: $url",null,"204");
			} catch (Exception $e) {
				throw new Exception($e->getMessage(),500);
			}
			break;
		case 'DELETE':
			if (isset($url_pieces[1])) {
				try {
					$invitation = new InvitationModel($url_pieces[1]);
					$invitation->cancel();
				} catch (Exception $e) {
					throw new Exception($e->getMessage(),500);
				}
				header("Location: apis/Invitations",null,"204");
			} else {
				throw new Exception("Missing target in ".$url_pieces);
			}
			break;
		default:
			throw new Exception("$verb not implemented","405");
	}
	// send the response
	
	if (isset($data)) {
		echo json_encode($data,JSON_PRETTY_PRINT);
	}
