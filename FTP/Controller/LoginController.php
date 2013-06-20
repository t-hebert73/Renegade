<?php
	/**
	* Author:		Miguel Mawyin
	* Date Created: June 12, 2013
	* Description:	This service controller handles everything related to user authentication
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\User;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class LoginController extends Controller
	{	
		//	Login action
		//	Called when a GET is requested
		public function loginAction(){
			// Create the form
			$form_user = new User();
			$form = $this->createFormBuilder($form_user)
				->add('Email', 'text', array('attr'=>array('placeholder'=>'Email')))
				->add('Password', 'password', array('attr'=>array('placeholder'=>'Password')))
				->getForm();			
			
			// Render the login template
			return $this->render('FTPBundle::login.html.twig', array(
				'form'=>$form->createView(),
			));
		}
		
		// Validation action
		// Called when a POST is requested
		public function validateAction(Request $req){
			// Create the form
			$form_user = new User();
			$form = $this->createFormBuilder($form_user)
				->add('Email', 'text', array('attr'=>array('placeholder'=>'Email')))
				->add('Password', 'password', array('attr'=>array('placeholder'=>'Password')))
				->getForm();
			
			// Bind the request to the form
			$form->bind($req);
			
			// Get the user from the database
			$rep = $this->getDoctrine()->getRepository('FTPBundle:User');
			$user = $rep->findOneBy(array(
				'email' 	=> $form['Email']->getData(),
				'password'	=> $form['Password']->getData(),
			));
			
			// Check if we found that user
			if( !$user ){
				// Render the login template with error
				return $this->render('FTPBundle::login.html.twig', array(
					'form' => $form->createView(),
					'msg_error' => 'Incorrect information. Please try again.',
				));
			}
			
			// Set the session id to the user
			$session = $req->getSession();
			$session->set('id', $user->getUserID());
			
			// Go to the main page
			return $this->redirect($this->generateUrl('_index'));
		}
		
		// Logout action
		// This will delete the user's session id
		public function logoutAction(){
			// Log the user out
			$session = $this->getRequest()->getSession();
			$session->clear();
			
			// Go back to the main controller
			return $this->redirect( $this->generateUrl('_index') );
		}
	}