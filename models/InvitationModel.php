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
	// An invitation model instance has an inviter, an invitee, and a status
	// An instance can be in an optimistic state, so that the instance 
	// can show that a player has not invited anyone yet.
	function __construct($player,$invited = null) {
		$this->db = new Database();
		$this->invitedBy = $player;
		$this->invitedPlayer = $invited;
		$this->getInvitation();
	}
	
	function invitePlayer() {
		// Insert a new invitation record into the database
		$sql = "INSERT INTO invitations (from_user,to_user,invitation_status) VALUES ('$this->invitedBy', '$this->invitedPlayer', '".self::INV_ST_PENDING."')";
		return $this->db->create($sql);
	}
	
	function getInvitation() {
		$sql = "SELECT from_user,to_user,invitation_status ".
			   "FROM invitations ".
			   "WHERE from_user = '$this->invitedBy' ".
			   "AND to_user LIKE ".(empty($this->invitedPlayer) ? "'%'" : "'$this->invitedPlayer'");
		$rows = $this->db->get($sql);
		if (count($rows) > 0) {
			$this->invitedPlayer = $rows[0]['to_user'];
			$this->status = $rows[0]['invitation_status'];
		}
	}
	
	// Show if the (potential) inviter has a current invitation by any other player
	function isInvited() {
		$sql = "SELECT from_user,to_user,invitation_status FROM invitations WHERE to_user = '$this->invitedBy'";
		$row = $this->db->get($sql);
		return (count($row) != 0);
	}
	
	
	/**
	 * Cancel all invitations for the inviter (invitedBy)
	 * 
	 * @param void
	 * 
	 * @return void
	 */
	function cancel() {
		$sql = "DELETE FROM invitations WHERE from_user = '$this->invitedBy'";
		$this->db->delete($sql);
	}
}