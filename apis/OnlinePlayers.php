<?php
	require_once('apiHeader.php');
	require_once('../models/OnlinePlayersModel.php');

	$onlinePlayers = new OnlinePlayersModel();
	
	switch($verb) {
	
		case 'GET':
			if (!isset($url_pieces[1])) {
				// GET all
				try {
					$data = $onlinePlayers->findAll();
					if ($data === null) {
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
		default:
			throw new Exception("$verb not implemented","405");
	}
	// send the response
	
	if (isset($data)) {
		echo json_encode($data,JSON_PRETTY_PRINT);
	}
