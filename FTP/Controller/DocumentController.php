<?php
	/**
	* Author : Trevor Hebert
	* Date Created : June 16, 2013
	* Description : 
	*/
	namespace Renegade\FTP\Controller;
	
	
	use Renegade\FTP\Entity\Document;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class DocumentController extends Controller
	{
		public function uploadAction(Request $request)
		{
    		$document = new Document();
    		$form = $this->createFormBuilder($document)
        		->add('file', 'file')
        		->getForm();

    		$form->handleRequest($request);

   	 	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
				
				$document->upload();
				
		        $em->persist($document);
        		$em->flush();

        		return $this->redirect($this->generateUrl('_index'));
    		}
			return $this->render('FTPBundle::fupload.html.twig', array(
				'form' => $form->createView(),
			));
		    
		}
	}
