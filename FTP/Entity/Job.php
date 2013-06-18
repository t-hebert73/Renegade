<?php
	/**
	* Author : Trevor Hebert
	* Last Modified : June 16, 2013
	* Description : 
	*/
	namespace Renegade\FTP\Entity;
	
	class Job
	{
		public $name;
		public $description;
		
		public function getJobName(){ return $this->name; }
		public function getJobDescription(){ return $this->description; }
		public function setJobName($n){ $this->name = $n; }
		public function setJobDescription($d){ $this->description = $d; }
	}