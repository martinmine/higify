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
		$text = NULL;
		$edit = false;
		$user = SessionController::acquireSession();
		$vals = array();
		$notes = array();
		
		if ($user !== NULL)
		{
			$username = $user->getUsername();
			$userID = $user->getUserID();
			
			/**
			 * Changes made by the user both edit and delete is 
			 * handled below:
			 */
			if (isset($_GET['noteID'])  &&  isset($_GET['changeType']))
			{
				$noteID = $_GET['noteID'];
				$changeType = $_GET['changeType'];
				
				switch($changeType)
				{
					case '0':			// Edit a note:
					{
						$edit = true;
						//$text = NoteController::getNote($noteID);
						
					} break;
					case '1':			//	Delete a note:
					{
						//NoteController::deleteNote($_GET['noteID']);
					
					} break;
					default: 
					{
						echo "WARNING";
					} break;
				}
				
			}
			
			/**
			 * Adding a new note in the database, ready to display.
			 */
			if (isset($_POST['submit'])  &&  isset($_POST['content']))
			{
				$_POST['userID']   = $userID;
				$_POST['username'] = $username;
				NoteController::requestAddNote($_POST);		
			}
			
			$vals['TOP'] = 'Top';	// Test;
			$vals['USERNAME'] = $username;
			$vals['PROFILE_ID'] = $userID;
			$vals['TEXT'] = ($text)? $text: NULL;
			$vals['NOTES'] = ($edit)? NULL: new NoteListView();
			
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