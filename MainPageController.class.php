<?php
require_once('UserController.class.php');


class MainPageController implements IPageController
{
	private $user = NULL;
	
	public function __construct()
	{
		$this->user = SessionController::acquireSession();
	}
	
	public function onDisplay()
	{
		$vals = array();
		
		if ($this->user !== NULL)
		{	
			$vals['TOP'] = 'Top';	// Test;
			
			$vals['USERNAME'] = $this->getUsername();
			$vals['PROFILE_PICTURE'] = UserController::requestProfilePicture($this->getUserID());
			
			
			
		}
		else
		{
			$vals['ERROR_MSG'] = new ErrorMessageView('No user is logged in...');
		}
	}


}


?>