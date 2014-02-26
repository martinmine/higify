<?php
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('NoteListView.class.php');
require_once('Template/IPageController.interface.php');

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
		$text = NULL;									// Default value in the texarea for adding new note.
		$edit = false;									// Setting a default value for checking for editing.
		$user = SessionController::acquireSession();	// Requesting the logged in user.
		$vals = array();								// Array, values that fills the page with requested input.
		$notes = array();								// List of notes to be displayed (if not in edit mode).
		
		/**
		 * Can only view a mainpage for logged in users
		 * else a warning message is displayed.
		 */
		if ($user !== NULL)
		{
			$username = $user->getUsername();
			//$userID = $user->getUserID();
			
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
				$noteID     = $_GET['noteID'];
				$changeType = $_GET['changeType'];
				$note = NoteController::requestNote($noteID);
				
				/** 
				 * A check if the user has permission to both delete or edit the note:
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
			 * When submitting (and content is set) you either change or add a new 
			 * note depending on $_GET input. Both call on NoteController to handle 
			 * both calls.
			 */
			if (isset($_POST['submit'])  &&  isset($_POST['content']))
			{
				if (isset($_GET['noteID'])  &&  isset($_GET['edit']) &&  $_GET['edit'] === '1')
				{
					$_POST['noteID']   = $_GET['noteID'];
					$_POST['ownerID']  = $user->getUserID();
					$_POST['username'] = $username;
					NoteController::requestEditNote($_POST);
				} 
				else
				{	
					$_POST['ownerID']  = $user->getUserID();
					$_POST['username'] = $username;
					NoteController::requestAddNote($_POST);
				}
			}
			
			if (isset($_GET['search'])  &&  isset($_GET['searchterm']))
			{
				if ($_GET['searchterm'] == 'Chuck Norris')
					echo "Watch out! Too late... Chuck destroyed your profile..</br>... Just kidding he higified you to the moon!";
				else	
					echo "Takk for din bestilling, faktura har blitt sendt til din mail adresse";
				
			}
			
			$vals['TOP']           = 'Top';	// Test;
			$vals['USERNAME']      = $username;
			$vals['CONTENT']       = ($displayContent)? $displayContent: NULL;
			$vals['CANCEL'] 	   = ($edit)? "cancel": NULL;
			$vals['NOTES']         = ($edit)? NULL: new NoteListView();
			$vals['EDIT']          = ($edit)? "?noteID=" . $noteID . "&edit=1": NULL;
			$vals['ISPUBLIC']      = $isPublicCheck;
		}
		else
		{
			$vals['ERROR_MSG'] = new ErrorMessageView('No user is logged in...');
		}
        return $vals;
	}
}


?>