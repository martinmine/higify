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
			
										// Variables for editing/(adding) a note:
			$noteID         = NULL;			// Check to edit or add new note.
			$displayContent = NULL;			// In edit: Check to display the 'old' content of a note.
			$isPublicCheck  = NULL;			// In edit: Display the 'old' notes isPublic status.

			/**
			 * Changes made by the user both edit and delete is 
			 * registered below:
			 */
			if (isset($_GET['noteID'])  &&  isset($_GET['changeType']))
			{
				$noteID = $_GET['noteID'];
				$changeType = $_GET['changeType'];
				$note = NoteController::requestNote($noteID);
				
				/** 
				 * A check if the user has permission to both delete or edit a note:
				 */
				if ($note->getOwnerID() === $user->getUserID())
				{
					
					switch($changeType)
					{
						case '0':			// Edit a note:
						{
							$edit = true;
							$note = NoteController::requestNote($noteID);
							$displayContent = $note->getContent();
							if ($note->isPublic() === '1')
								$isPublicCheck = "checked";
							
							
						} break;
						case '1':			//	Delete a note:
						{
							NoteController::requestDeleteNote($_GET['noteID']);
						
						} break;
						default: 			//	Error:
						{
							throw new InvalidArgumentException('ChangeType');
						} break;
					}
				}
				else
				{
					echo "</br></br>YOU do not have permission to do this!</br></br>";
				}
			}
			
			/**
			 * When submitted you either change or add a new note:
			 *
			 *
			 */
			if (isset($_POST['submit'])  &&  isset($_POST['content']))
			{
				
				if (isset($_GET['noteID'])  &&  isset($_GET['edit']) &&  $_GET['edit'] === '1')				// Change a note:
				{
					$_POST['noteID']   = $_GET['noteID'];
					$_POST['ownerID']  = $userID;
					$_POST['username'] = $username;
					
					NoteController::requestEditNote($_POST);
					
				} 
				else					// Ass a new note
				{	
					
					$_POST['ownerID']  = $userID;
					$_POST['username'] = $username;
					NoteController::requestAddNote($_POST);
				
				}
			}
			
			$vals['TOP']           = 'Top';	// Test;
			$vals['USERNAME']      = $username;
			$vals['PROFILE_ID']    = $userID;
			$vals['CONTENT']       = ($displayContent)? $displayContent: NULL;
			$vals['CANCEL'] 	   = ($edit)? "cancel": NULL;
			$vals['NOTES']         = ($edit)? NULL: new NoteListView();
			$vals['EDIT']          = ($edit)? "?noteID=" . $noteID . "&edit=1": NULL;
			$vals['ISPUBLIC']      = $isPublicCheck;
			
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