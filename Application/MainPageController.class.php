<?php
require_once('Template/IPageController.interface.php');
require_once('User/UserController.class.php');
require_once('Session/SessionController.class.php');
require_once('NoteListView.class.php');
require_once('NoteCategoryView.class.php');
require_once('ReportedNoteView.class.php');

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
		$userID = SessionController::requestLoggedinID(); // Get signed in userID
        $user = UserController::requestUserByID($userID);
		$vals = array();								// Array, values that fills the page with requested input.
		
		$vals['NOTES']	                = new NoteListView($userID, NoteType::ALL);
        $vals['CREATE_NOTE_CATEGORIES'] = new NoteCategoryView();
            
        if ($user->getRank())
            $vals['REPORTED'] = new ReportedNoteView();

        return $vals;
	}
}


?>