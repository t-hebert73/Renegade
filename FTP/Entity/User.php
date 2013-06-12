<?php
	/**
	* Author : Miguel Mawyin
	* Last Modified : June 11, 2013
	* Description : 
	*/
	namespace Renegade\FTP\Entity;
	
	class User
	{
		public $email;
		public $pass;
		
		public function getEmail(){ return $this->email; }
		public function getPassword(){ return $this->pass; }
		public function setEmail($e){ $this->email = $e; }
		public function setPassword($p){ $this->pass = $p; }
	}