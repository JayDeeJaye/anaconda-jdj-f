<?php
require_once('../models/Database.php');

class InvitationModel 
{
	public $invitationId;
	public $invitedBy;
	public $invitedPlayer;
	public $status;
	
	private $db;
	
	const INV_ST_PENDING = 'pending';
	
	// construct gets the current state of the invitation
	function __construct($player,$invited = null) {
		$this->db = new Database();
		$this->invitedBy = $player;
		$this->invitedPlayer = $invited;
		$this->getInvitation();
	}
	
	function invitePlayer() {
		// Insert a new invitation record into the database
		$sql = "INSERT INTO invitations (from_user,to_user,status) VALUES ('$this->invitedBy', '$this->invitedPlayer', '".self::INV_ST_PENDING."')";
		return $this->db->create($sql);
	}
	
	function getInvitation() {
		$sql = "SELECT from_user,to_user,status ".
			   "FROM invitations ".
			   "WHERE from_user = '$this->invitedBy' ".
			   "AND to_user LIKE ".(empty($this->invitedPlayer) ? "'%'" : "'$this->invitedPlayer'");
		$row = $this->db->get($sql);
		if (count($row) > 0) {
			$this->invitedPlayer = $rows[0]['to_user'];
			$this->status = $rows[0]['status'];
		}
	}
	
	function isInvited() {
		$sql = "SELECT from_user,to_user,status FROM invitations WHERE to_user = '$this->invitedBy'";
		$row = $this->db->get($sql);
		return (count($row) != 0);
	}
	
	function cancel() {
		// TODO: cancel invitations
	}
}