<?php
	/**
	* Author : Miguel Mawyin
	* Last Modified : June 11, 2013
	* Description : Main application controller, all request happen through this controller
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\User;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class RenegadeController extends Controller
	{
		// Main action
		public function indexAction( Request $req )
		{
			// TODO 
			// Check if the user is logged in
			// Base on that redict to login on main page
			
			// Redirect to the login controller
			return $this->redirect($this->generateUrl('_login'));
		}
	}