<?php
	/**
	* Author : Miguel Mawyin
	* Last Modified : June 12, 2013
	* Description : Main application controller, all request happen through this controller
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\Database;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class RenegadeController extends Controller
	{
		// Main action
		public function indexAction( Request $req )
		{
			// Check if a user has logged in already
			$session = $this->getRequest()->getSession();
			$session->start();
			$id = $session->get('id');
			
			if( $id == null ){
				// User not logged in
				// Redirect to the login controller
				return $this->redirect($this->generateUrl('_login'));
			}
			
			$db = new Database();
			
			$files = array();
			$db->query('SELECT * FROM files');
			while( $r = $db->fetch() ){
				$files[] = array('id'=>$r['fileID'], 'fileName'=>$r['fileName'], 'filePath'=>$r['filePath']);
			}
			
			// Render the index screen
			return $this->render('FTPBundle::index.html.twig', array(
				'id' => $id,
				'files' => $files,
				'rows' => $db->rows
			));
		}
	}