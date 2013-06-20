<?php
	/**
	*	Author: Miguel Mawyin
	*	Date Created: June 19, 2013
	*	Description: 
	*/
	namespace Renegade\FTPBundle\Controller;
	
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	
	class NotificationContoller extends Controller{
		public function sendError($response, $error, $array = null){
			if( $array ){
				$array['msg_error'] = $error;
			} else {
				$array = array( 'msg_error' => $error );
			}
			
			return $this->render($reponse, $array);
		}
	}