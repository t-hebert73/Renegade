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
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class LoginController extends Controller
	{
		//	Login action
		//	Called when a GET is requested
		public function loginAction(){
			// Create a new user and build a form
			$user = new User();
			$form = $this->createFormBuilder($user)
				->add('Email','text', array('attr'=>array('placeholder'=>'Email')))
				->add('Password','password', array('attr'=>array('placeholder'=>'Password')))
				->getForm();
			
			$db = new Database();
			$db->query('SELECT * FROM users');
			
			$emails = array();
			$passwords = array();
			$num = 0;
			while($r = $db->fetch()){
				$emails[] = $r['username'];
				$passwords[] = $r['password'];
				$num = $num + 1;
			}
			
			// Render the login form
			return $this->render("FTPBundle::login.html.twig", array(
				'form' => $form->createView(),
				'emails' => $emails,
				'pass' => $passwords,
				'num' => $num,
			));
		}
		
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
				//$db = new Database();
				
				// Query the database, try to find the user entered
				//$db->query("SELECT * FROM users WHERE username='".$form->get('Email')->getData()."' AND password='".$form->get('Password')->getData()."'");
				
				return $this->redirect($this->generateUrl('_login'));
			}
		}
				
		public function successAction(){
			return $this->render('FTPBundle:Default:success.html.twig');
		}
	}