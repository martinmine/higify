<?php
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('Template/IPageController.interface.php');
require_once('NoteListView.class.php');
require_once('NoteType.class.php');

/**
 * Handel the page for viewing other profiles.
 * 
 * @uses UserController.class.php
 */
class ProfilePageController implements IPageController
{
	
	/**
	 * Putting all elements together.
	 *
	 * @uses SessionController.
	 */
	public function onDisplay()
	{	
		$loggedinID = SessionController::requestLoggedinID();	// Requesting the logged in user.
		$vals = array();
		
		/**
		 * Can only view mainpage for logged in users
		 * else a warning message is displayed.
		 */
		if ($loggedinID !== NULL)
		{
			
			$profileID = (isset($_GET['id']))? $_GET['id']: NULL;
			
			if ($profileID !== NULL)
			{				
				$profileUser = UserController::requestUserByID($profileID);
				if ($profileID === NULL) header('Location: mainpage.php');
				
				$vals['USERNAME'] = $profileUser->getUsername();
				$vals['USER_ID'] = $loggedinID;
				$vals['PROFILE_ID']  = $profileID;
				$vals['RESULTS'] = new NoteListView($profileID, NoteType::PUBLIC_ONLY);
			}
			else
			{
				header('Location: mainpage.php');
			}
		}
		else
		{
			//$vals['ERROR_MSG'] = new ErrorMessageView('No user is logged in...');
		}
        return $vals;
	}
}


?>