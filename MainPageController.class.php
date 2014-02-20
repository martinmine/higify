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
	private $user = NULL;
	
	/**
	 * Retrieves the active user object.
	 */
	public function __construct()
	{
		$this->user = SessionController::acquireSession();
	}
	
	/**
	 * Putting main page together.
	 *
	 * @uses UserController.class.php
	 */
	public function onDisplay()
	{
		$vals = array();
		$notes = array();
		
		if ($this->user !== NULL)
		{	
			$vals['TOP'] = 'Top';	// Test;
			
			$vals['USERNAME'] = $this->user->getUsername();
			$vals['PROFILE_PICTURE'] = UserController::requestProfilePicture($this->user->getUserID());
			
			$vals['NOTES'] = new NoteListView();
			$vals['HOURS'] = new DayScheduleView();
			
		}
		else
		{
			$vals['ERROR_MSG'] = new ErrorMessageView('No user is logged in...');
		}
        return $vals;
	}


}


?>