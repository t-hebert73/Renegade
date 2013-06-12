<?php
	/**
	* Author : Miguel Mawyin
	* Last Modified : June 11, 2013
	* Description : This controller is split into two sections determined primerly by the HTML request.
	*				If the request is GET, then the controlller will display a login screen.
	*				If the request is a POST, then the controller will validate the user.
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\User;
	use Renegade\FTP\Entity\Database;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class LoginController extends Controller
	{
		//	Login action
		//	Called when a GET is requested
		public function loginAction(){
			// Check if a user is already logged in
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			if( $id == null ){		
				// Create a new user and build a form
				$user = new User();
				$form = $this->createFormBuilder($user)
					->add('Email','text', array('attr'=>array('placeholder'=>'Email')))
					->add('Password','password', array('attr'=>array('placeholder'=>'Password')))
					->getForm();
			
				// Render the login form
				return $this->render("FTPBundle::login.html.twig", array(
					'form' => $form->createView(),
				));
			}
			
			// User logged in
			// Go back to the main controller
			return $this->redirect( $this->generateUrl('_index') );
		}
		
		// Validation action
		// Called when a POST is requested
		public function validateAction(Request $req){
			if($req->isMethod('POST')){
				// Create the user
				$user = new User();
				$form = $this->createFormBuilder($user)
					->add('Email','text', array('attr'=>array('placeholder'=>'Email')))
					->add('Password','password', array('attr'=>array('placeholder'=>'Password')))
					->getForm();
				
				// Bind the user object to the request
				$form->bind($req);
				
				// Connect to the database
				$db = new Database();
				
				// Query the database, try to find the user entered
				$db->query("SELECT * FROM users WHERE username='".$form->get('Email')->getData()."' AND password='".$form->get('Password')->getData()."'");
			
				if( $db->rows == 1 ){
					// User logged in
					// Get the user
					$user = $db->fetch();
					
					// Set the session of the userID
					$session = $this->getRequest()->getSession();
					$session->set('id', $user['userID']);
					
					// Back to the renegade controller
					return $this->redirect($this->generateUrl('_index'));
				}
				
				// The error message
				$error = 'Wrong username or password. Please try again';				
				
				// Render the login form with the error
				return $this->render("FTPBundle::login.html.twig", array(
					'form' => $form->createView(),
					'error' => $error,
				));
			}
		}
		
		public function logoutAction(){
			// Log the user out
			$session = $this->getRequest()->getSession();
			$session->clear();
			
			// Go back to the main controller
			return $this->redirect( $this->generateUrl('_index') );
		}
	}