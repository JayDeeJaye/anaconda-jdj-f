<?php
class UserModel {
	
	public $userName;
	private $password;
	private $passwordConfirm;
	
	function __construct($username,$password) {
		$this->userName = $username;
		$this->password = $password;
	}
	
	function addUser() {
		
	}
	
	function findUser($username) {
		
	}
}