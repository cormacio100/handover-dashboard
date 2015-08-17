<?php

/**
 * Class for creating admin user objects from
 * Admin users can make changes to the product range. 
 * Admin can add/edit/delete products
 */


class User
{
	private $userId;
	private $username; 
	private $authenticated=FALSE;	// users are not authenticated by default
	private $db;					// object var to hold Database Object
	//private $fullName;
	
	// construtor with default values
	public function __construct($username='',$password='',$db)
	{
		// Database Object	
		$this->db=$db;
		
		// authenticate the user
		$this->authenticateUser($username,$password);
	}
	
	// check the user details against the database
	private function authenticateUser($username,$password)
	{
		$authenticate=$this->db->authenticate($username,$password);
		
		if(sizeof($authenticate==2))
		{
			if(isset($authenticate['userId'])&& isset($authenticate['username']))
			{
				$this->userId=$authenticate['userId'];
				$this->username=$authenticate['username'];
				$this->authenticated=TRUE;
			}
		}
	}
	
	/**
	 * GETTER functions
	 */
	 public function getUsername()
	 {
	 	return $this->username;
	 }
	 public function getAuthenticated()
	 {
	 	return $this->authenticated;
	 }
	 	
}