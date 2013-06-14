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
	
	class UsersController extends Controller
	{
		// Account function
		// This action will display the information of the current logged in user.
		public function accountAction(){
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
		public function getCreateAction(){
			// Get the id from the session
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			// Check if the user has logged in
			if( $id == null ){
				// No user found
				// Return to the main controller
				return $this->redirect($this->generateUrl('_index'));
			}
			
			$user = new User();
			$form = $this->createFormBuilder($user)
				->add('Email', 'text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->add('Password', 'password', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->getForm();
			
			return $this->render('FTPBundle::ucreate.html.twig', array(
				'id' => $id,
				'form' => $form->createView(),
			));
		}
		
		public function postCreateAction(Request $req){
			// Get the id from the session
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			// Create the user
			$user = new User();
			$form = $this->createFormBuilder($user)
				->add('Email','text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->add('Password','password', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->getForm();
				
			// Bind the user object to the request
			$form->bind($req);
			
			// Connect to the database
			$db = new Database();
			
			// Check if that email/username is already in use
			$db->query("SELECT * FROM users WHERE username='".$form->get('Email')->getData()."'");
			if( $db->rows > 0 ){
				// Account is already in use
				$error = 'Account already registered. Please try another username.';
				
				// Render the template
				return $this->render('FTPBundle::ucreate.html.twig', array(
					'id' => $id,
					'form' => $form->createView(),
					'error' => $error,
				));
			}
			 // Create the user
			 $db->query("INSERT INTO users (username, password, auth) VALUES ('".$form->get('Email')->getData()."', '".$form->get('Password')->getData()."', 0)");
			 $msg = "User has been created.";
			
			// Render the template
			return $this->render('FTPBundle::ucreate.html.twig', array(
				'id' => $id,
				'form' => $form->createView(),
				'msg' => $msg
			));
		}
		
		public function viewAction(){
			// Get the id from the session
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			// Connect to the database
			$db = new Database();
			
			// The users
			$users = array();
			
			// Get all the users except us
			$db->query("SELECT * FROM users WHERE userID!=".$id);
			while( $r = $db->fetch() ){
				$users[] = $r['username'];
			}
			
			// Render the template
			return $this->render('FTPBundle::uview.html.twig', array(
				'id' => $id,
				'users' => $users,
				'rows' => $db->rows
			));
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	