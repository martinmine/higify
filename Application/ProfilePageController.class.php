<?php
require_once('User/UserController.class.php');
require_once('Session/SessionController.class.php');
require_once('Template/IPageController.interface.php');
require_once('Note/NoteType.class.php');
require_once('NoteListView.class.php');

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

		if (isset($_GET['id']))
		{				
			$profileID = ($_GET['id']);
			$profileUser = UserController::requestUserByID($profileID);
			
			if ($profileID === NULL) 
				header('Location: mainpage.php');
			
			$vals['USERNAME'] = $profileUser->getUsername();
			$vals['USER_ID'] = $loggedinID;
			$vals['PROFILE_ID']  = $profileID;
			$vals['RESULTS'] = new NoteListView($profileID, NoteType::PUBLIC_ONLY);
		}
		else
		{
			header('Location: mainpage.php');
			exit;
		}

        return $vals;
	}
}


?>