<?php
	/**
	* Author : Miguel Mawyin
	* Date Created : June 17, 2013
	* Description :
	*/
	namespace Renegade\FTP\Controller;
	
	use Renegade\FTP\Entity\File;
	use Renegade\FTP\Entity\Database;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class FilesController extends Controller
	{
		public function getUploadAction(){
			$file = new File();
			$form = $this->createFormBuilder($file)
				->add( 'Name', 'text' )
				->add( 'File', 'file' )
				->getForm();
				
			return $this->render("FTPBundle::fupload.html.twig", array(
				'form' => $form->createView(),
			));
		}
		
		public function postUploadAction(Request $req){
			$file = new File();
			$form = $this->createFormBuilder($file)
				->add( 'Name', 'text' )
				->add( 'File', 'file' )
				->getForm();
				
			$form->bind($req);
			
			if( $form['File']->isValid() ){
				$dir = __DIR__.'/../Files';
				$name = $form['Name']->getData().'.'.$form['File']->getData()->getClientOriginalExtension();
				
				$form['File']->getData()->move($dir, $name);
				
				$db = new Database();
				
				$db->query("INSERT INTO files (jobID, fileName, filePath, fileDescription) VALUES (1, '".$name."', '".$dir."', 'test')");
				
				return $this->render('FTPBundle::index.html.twig', array(
					'msg_success' => 'File uploaded!'
				));
			}
			return $this->render('FTPBundle::index.html.twig', array(
				'msg_error' => 'Could not upload the file.'
			));
		}
	}