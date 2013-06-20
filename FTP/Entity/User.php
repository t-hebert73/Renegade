<?php
	/**
	* Author : Miguel Mawyin
	* Last Modified : June 11, 2013
	* Description : This class represents a user.
	*/
	namespace Renegade\FTP\Entity;
	
	// For the doctrine
	use Doctrine\ORM\Mapping as ORM;

	/**
	 * @ORM\Entity
	 * @ORM\Table(name="users")
	 */
	class User
	{
		/**
		 * @ORM\id
		 * @ORM\Column(type="integer")
		 * @ORM\GeneratedValue(strategy="AUTO")
		 */
		protected $userID;
		
		/**
		 * @ORM\Column(type="string", length=50)
		 */
		protected $email;
		
		/**
		 * @ORM\Column(type="string", length=50)
		 */
		protected $password;
		
		/**
		 * @ORM\Column(type="integer")
		 */
		protected $auth;
		
		/**
		 * @ORM\Column(type="datetime")
		 */
		protected $creationDate;
		
		// These functions return the values above
		public function getUserID(){ return $this->userID; }
		public function getEmail(){ return $this->email; }
		public function getPassword(){ return $this->password; }
		public function getAuth(){ return $this->auth; }
		public function getCreationDate(){ return $this->creationDate; }
		
		// These functions set the values above
		public function setUserID($i){ $this->userID = $i; }
		public function setEmail($e){ $this->email = $e; }
		public function setPassword($p){ $this->password = $p; }
		public function setAuth($a){ $this->auth = $a; }
		public function setCreationDate($d){ $this->creationDate = $d; }
	}
	
	
	
	
	
	
	
	
	
	
	