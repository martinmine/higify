<?php
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('NoteListView.class.php');
require_once('DayScheduleView.class.php');

/**
 * Retrieves all elements for the main-page.
 * 
 * @uses UserController.class.php
 */
class MainPageController implements IPageController
{
	
	/**
	 * Putting main page together.
	 *
	 * @uses UserController.class.php
	 */
	public function onDisplay()
	{
		$user = SessionController::acquireSession();
		$vals = array();
		$notes = array();
		
		if ($user !== NULL)
		{
			$username = $user->getUsername();
			$userID = $user->getUserID();
			
			if (isset($_POST['submit'])  &&  isset($_POST['content']))
			{
				$_POST['userID']   = $userID;
				$_POST['username'] = $username;
				NoteController::requestAddNote($_POST);		
			}
			
			$vals['TOP'] = 'Top';	// Test;
			
			$vals['USERNAME'] = $username;
			$vals['PROFILE_ID'] = $userID;
			
			$vals['NOTES'] = new NoteListView();
			
			//$vals['HOURS'] = new DayScheduleView();  //  not done...
			
		}
		else
		{
			$vals['ERROR_MSG'] = new ErrorMessageView('No user is logged in...');
		}
        return $vals;
	}


}


?>