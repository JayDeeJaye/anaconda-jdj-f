<?php
require_once('../models/Database.php');

/**
 * Invitation domain model
 * 
 * Instantiate with a single player to find an invitation in which she is involved
 * Instantiate with a pair to create an invitation, or find the state of an invitation between these two players
 *
 */
class InvitationModel 
{
	public $invitationId;
	public $fromPlayer;
	public $toPlayer;
	public $status;
	
	private $db;
	
	const INV_ST_PENDING = 'pending';
	const INV_ST_NONE = 'none';
	const INV_ST_ACCEPTED = 'accepted';
	const INV_ST_REJECTED = 'rejected';
	const INV_ST_COMPLETED = 'gameon';
	
	// construct method gets the current state of the invitation
	// An invitation model instance has an inviter, an invitee, and a status
	// An instance can be in an optimistic state, so that the instance 
	// can show that a player has not invited anyone yet.
	function __construct($fromPlayer,$toPlayer = null) {
		$this->db = new Database();
		$this->fromPlayer = $fromPlayer;
		$this->toPlayer = $toPlayer;
		$this->status = self::INV_ST_NONE;
		
		//Check the state of this invitation as is.
		if (!$this->getInvitation()) {
			if (empty($this->toPlayer)) {
				$this->getInvited();
			}
		}
	}
	
	function invitePlayer() {
		// Insert a new invitation record into the database
		$sql = "INSERT INTO invitations (from_user,to_user,invitation_status) VALUES ('$this->fromPlayer', '$this->toPlayer', '".self::INV_ST_PENDING."')";
		return $this->db->create($sql);
	}
	
	function getInvitation() {
		$sql = "SELECT id,from_user,to_user,invitation_status ".
			   "FROM invitations ".
			   "WHERE from_user = '$this->fromPlayer' ".
			   "AND to_user LIKE ".(empty($this->toPlayer) ? "'%'" : "'$this->toPlayer'");
		$rows = $this->db->get($sql);
		if (count($rows) > 0) {
			$this->toPlayer = $rows[0]['to_user'];
			$this->status = $rows[0]['invitation_status'];
			$this->invitationId = $rows[0]['id'];
			return true;
		} else {
			return false;
		}
	}
	
	// Show if the (potential) inviter has a current invitation by any other player
	function isInvited() {
		$sql = "SELECT from_user,to_user,invitation_status FROM invitations WHERE to_user = '$this->fromPlayer'";
		$row = $this->db->get($sql);
		return (count($row) != 0);
	}
	
	function getInvited() {
		$sql = "SELECT id,from_user,to_user,invitation_status FROM invitations WHERE to_user = '$this->fromPlayer'";
		$rows = $this->db->get($sql);
		if (count($rows) > 0) {
			$this->fromPlayer = $rows[0]['from_user'];
			$this->toPlayer = $rows[0]['to_user'];
			$this->status = $rows[0]['invitation_status'];
			$this->invitationId = $rows[0]['id'];
		}
	}
	
	 //Cancel all invitations for the inviter (fromPlayer)
	function cancel() {
		$sql = "DELETE FROM invitations WHERE from_user = '$this->fromPlayer'";
		$this->db->delete($sql);
	}
	
	// update the database with the current model state
	function update() {
		$sql = "UPDATE invitations SET ".
			   "       from_user = '$this->fromPlayer',".
			   "	   to_user = '$this->toPlayer',".
			   "	   invitation_status = '$this->status' ".
			   "WHERE id = $this->invitationId";
		$this->db->update($sql);
	}
}