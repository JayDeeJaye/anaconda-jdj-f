<?php
require_once('../models/Database.php');

class InvitationModel 
{
	public $invitationId;
	public $invitedPlayer;
	public $invitedBy;
	public $status;
	
	private $db;
	
	const INV_ST_PENDING = 'pending';
	
	function __construct($player,$invited) {
		$this->invitedBy = $player;
		$this->invitedPlayer = $invited;
		$this->db = new Database();
	}
	
	function invitePlayer() {
		// Insert a new invitation record into the database
		$sql = "INSERT INTO invitations (from_user,to_user,status) VALUES ('".$this->invitedBy."', '".$this->invitedPlayer."', '".self::INV_ST_PENDING."')";
		return $this->db->create($sql);
	}	
}