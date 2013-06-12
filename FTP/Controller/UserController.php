<?php
	/**
	* Author : Miguel Mawyin
	* Date Created : June 12, 2013
	* Description : 
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\User;
	use Renegade\FTP\Entity\Database;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class UserController extends Controller
	{
		// View user function
		// This action will display the information of the current logged in user.
		public function viewAction(){
			// Get the id from the session
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			// Check if the user has logged in
			if( $id == null ){
				// No user found
				// Return to the main controller
				return $this->redirect($this->generateUrl('_index'));
			}
			
			// Get the user's account from that ID
			$db = new Database();
			
			// Query the database and get the user
			$db->query('SELECT * FROM users WHERE userID='.$id);
			$row = $db->fetch();
			
			// Create the form
			$user = new User();
			$user->setEmail($row['username']);
			$user->setPassword($row['password']);
			$form = $this->createFormBuilder($user)
				->add('Email','text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->add('Password', 'password', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->getForm();
			
			// Display the information of the user
			return $this->render('FTPBundle::user.html.twig', array(
				'id' => $id,
				'form' => $form->createView(),
			));
		}
	
		// Create user function
		// This action will display a form to create a user
		public function createAction(){
		}
	}