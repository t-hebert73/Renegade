<?php
	namespace Renegade\FTP\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints as Assert;
	
	class File
	{
		private $file;
		private $name;
		
		public function getFile(){ return $this->file; }
		public function getName(){ return $this->name; }
		public function setFile($f){ $this->file = $f; }
		public function setName($n){ $this->name = $n; }
	}