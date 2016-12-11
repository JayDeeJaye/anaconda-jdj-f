<?php
require_once('../models/Database.php');

class InvitationModel 
{
	public $invitationId;
	public $fromPlayer;
	public $toPlayer;
	public $status;
	
	private $db;
	
	const INV_ST_PENDING = 'pending';
	const INV_ST_NONE = 'none';
	
	// construct gets the current state of the invitation
	// An invitation model instance has an inviter, an invitee, and a status
	// An instance can be in an optimistic state, so that the instance 
	// can show that a player has not invited anyone yet.
	function __construct($fromPlayer,$toPlayer = null) {
		$this->db = new Database();
		$this->fromPlayer = $fromPlayer;
		$this->toPlayer = $toPlayer;
		$this->status = self::INV_ST_NONE;
		$this->getInvitation();
	}
	
	function invitePlayer() {
		// Insert a new invitation record into the database
		$sql = "INSERT INTO invitations (from_user,to_user,invitation_status) VALUES ('$this->fromPlayer', '$this->toPlayer', '".self::INV_ST_PENDING."')";
		return $this->db->create($sql);
	}
	
	function getInvitation() {
		$sql = "SELECT from_user,to_user,invitation_status ".
			   "FROM invitations ".
			   "WHERE from_user = '$this->fromPlayer' ".
			   "AND to_user LIKE ".(empty($this->toPlayer) ? "'%'" : "'$this->toPlayer'");
		$rows = $this->db->get($sql);
		if (count($rows) > 0) {
			$this->toPlayer = $rows[0]['to_user'];
			$this->status = $rows[0]['invitation_status'];
		} else {
			$this->getInvited();
		}
	}
	
	// Show if the (potential) inviter has a current invitation by any other player
	function isInvited() {
		$sql = "SELECT from_user,to_user,invitation_status FROM invitations WHERE to_user = '$this->fromPlayer'";
		$row = $this->db->get($sql);
		return (count($row) != 0);
	}
	
	function getInvited() {
		$sql = "SELECT from_user,to_user,invitation_status FROM invitations WHERE to_user = '$this->fromPlayer'";
		$rows = $this->db->get($sql);
		if (count($rows) > 0) {
			$this->fromPlayer = $rows[0]['from_user'];
			$this->toPlayer = $rows[0]['to_user'];
			$this->status = $rows[0]['invitation_status'];
		}
	}
	
	
	/**
	 * Cancel all invitations for the inviter (invitedBy)
	 * 
	 * @param void
	 * 
	 * @return void
	 */
	function cancel() {
		$sql = "DELETE FROM invitations WHERE from_user = '$this->fromPlayer'";
		$this->db->delete($sql);
	}
}