<?php
	/**
	* Author : Trevor Hebert
	* Date Created : June 16, 2013
	* Description : 
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\Job;
	use Renegade\FTP\Entity\Database;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class JobsController extends Controller
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
			$job = new Job();
			$job->setName($row['jobName']);
			$job->setDescription($row['description']);
			$form = $this->createFormBuilder($job)
				->add('JobName','text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->add('JobDescription', 'text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->getForm();
			
			// Display the information of the user
			return $this->render('FTPBundle::job.html.twig', array(
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
			
			$job = new Job();
			$form = $this->createFormBuilder($job)
				->add('JobName', 'text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->add('JobDescription', 'text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->getForm();
			
			return $this->render('FTPBundle::jcreate.html.twig', array(
				'id' => $id,
				'form' => $form->createView(),
			));
		}
		
		public function postCreateAction(Request $req){
			// Get the id from the session
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			// Create the user
			$job = new Job();
			$form = $this->createFormBuilder($job)
				->add('JobName','text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->add('JobDescription','text', array('attr'=>array('class'=>'input-xxlarge', 'style'=>'margin-bottom:0px')))
				->getForm();
				
			// Bind the user object to the request
			$form->bind($req);
			
			// Connect to the database
			$db = new Database();
			
			// Check if that email/username is already in use
			$db->query("SELECT * FROM jobs WHERE jobName='".$form->get('JobName')->getData()."'");
			if( $db->rows > 0 ){
				// Account is already in use
				// Render the template
				return $this->render('FTPBundle::jcreate.html.twig', array(
					'id' => $id,
					'form' => $form->createView(),
					'msg_error' => 'Job name is already in use. Please try another jobname.'
				));
			}
			
			// Create the user
			
			$db->query("INSERT INTO jobs (jobName, description, userID) VALUES ('".$form->get('JobName')->getData()."', '".$form->get('JobDescription')->getData()."',".$id.")");
			
			// Render the template
			return $this->render('FTPBundle::jcreate.html.twig', array(
				'id' => $id,
				'form' => $form->createView(),
				'msg_success' => 'Job has been created.'
			));
		}
		
		public function viewAction(){
			// Get the id from the session
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			// Connect to the database
			$db = new Database();
			
			// The users
			$jobs = array();
			
			// Get all the users except us
			$db->query("SELECT * FROM jobs WHERE userID=".$id);
			while( $r = $db->fetch() ){
				$jobs[] = array('id'=>$r['jobID'], 'jobName'=>$r['jobName']);
			}
			
			// Render the template
			return $this->render('FTPBundle::jview.html.twig', array(
				'id' => $id,
				'jobs' => $jobs,
				'rows' => $db->rows
			));
		}
		
		public function deleteAction($id){
			// Connect to the database
			$db = new Database();
			
			// Delete the user
			$db->query("DELETE FROM jobs WHERE jobID=".$id);
			
			// Get the id from the session
			$session = $this->getRequest()->getSession();
			$id = $session->get('id');
			
			// The users
			$jobs = array();
			
			// Get all the users except us+
			$db->query("SELECT * FROM jobs WHERE userID=".$id);
			while( $r = $db->fetch() ){
				$jobs[] = array('id'=>$r['jobID'], 'jobName'=>$r['jobName']);
			}
			
			// Render the template
			return $this->render('FTPBundle::jview.html.twig', array(
				'id' => $id,
				'jobs' => $jobs,
				'rows' => $db->rows,
				'msg_error' => 'Job deleted.'
			));
		}
	}
