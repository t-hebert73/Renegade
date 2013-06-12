<?php
	/**
	* Author : Miguel Mawyin
	* Last Modified : June 12, 2013
	* Description : Main application controller, all request happen through this controller
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\User;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class RenegadeController extends Controller
	{
		// Main action
		public function indexAction( Request $req )
		{
			// Check if a user has logged in already
			$session = new Session();
			$id = $session->get('id');
			
			if( $id == null ){
				// User not logged in
				// Redirect to the login controller
				return $this->redirect($this->generateUrl('_login'));
			}
			
			// Render the index screen
			return $this->render('FTPBundle::index.html.twig', array(
				'id' => $id,
			));
		}
	}