<?php
require_once('../models/Database.php');
require_once('../models/InvitationModel.php');

class OnlinePlayer implements JsonSerializable
{
	public $name;
	public $status;
	public $invitedBy;
	
	public function jsonSerialize() {
		$result = get_object_vars($this);
		return (object) $result;
	}
}
class OnlinePlayersModel
{
	private $dbConn;
	const ST_AVAIL = 'AVAILABLE';
	const ST_INVTD = 'INVITED';
	const ST_INVTG = 'INVITING';
	
	
	function __construct() {
		$this->dbConn = new Database();
	}

	function findAll () {
		$data = array();
// 		$sql = <<<SQL
// 			SELECT s.username
// 			FROM sessions s
// 			WHERE s.username NOT IN (
// 				SELECT i1.from_user FROM invitations i1 
// 				UNION
// 				SELECT i2.to_user FROM invitations i2
// 			)
// SQL;

		$sql = "SELECT username FROM sessions";
		$rows = $this->dbConn->get($sql);
		if (count($rows) > 0) {
			for ($i = 0; $i < count($rows); $i++) {
				$p = new OnlinePlayer();
				$p->name = $rows[$i]['username'];

				// Is this player involved in an invitation?
				$invitation = new InvitationModel($p->name);
				if ($invitation->status == InvitationModel::INV_ST_NONE) {
					$p->status = self::ST_AVAIL;
				} elseif ($invitation->toPlayer == $p->name) {
					$p->status = self::ST_INVTD;
					$p->invitedBy = $invitation->fromPlayer;
				} elseif (!empty($invitation->toPlayer)) {
					$p->status = self::ST_INVTG;
				}
				array_push($data, $p);
			}
		}
		return $data;
	}
	
}
