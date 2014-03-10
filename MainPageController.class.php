<?php
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('NoteListView.class.php');
require_once('Template/IPageController.interface.php');
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
		$text = NULL;									// Default value in the texarea for adding new note.
		$edit = false;									// Setting a default value for checking for editing.
		$user = SessionController::acquireSession();	// Requesting the logged in user.
		$vals = array();								// Array, values that fills the page with requested input.
		
		/**
		 * Can only view a mainpage for logged in users
		 * else a warning message is displayed.
		 */
		if ($user !== NULL)
		{
			$username = $user->getUsername();
			
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
				if ($note->getOwnerID() === $user->getUserID() || $user->getRank())
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
							break;
						} 
						case '1':			//	Delete a note:
						{
							NoteController::requestDeleteNote($_GET['noteID']);
						    break;
						} 
						default: 			//	Error:
						{
							throw new InvalidArgumentException('ChangeType');
						} 
					}
				}
			}
			
			/**
			 * When submitting (and content is set) you either change or add a new 
			 * note depending on $_GET input. Both call on NoteController to handle 
			 * both calls.
			 */
			if (isset($_POST['submit'])  &&  isset($_POST['content']))
			{
				$_POST['ownerID']  = $user->getUserID();
				$_POST['username'] = $username;
				
				if (isset($_GET['noteID'])  &&  isset($_GET['edit']) &&  $_GET['edit'] === '1')
				{
					$_POST['noteID']   = $_GET['noteID'];
					NoteController::requestEditNote($_POST);
				} 
				else
				{	
					NoteController::requestAddNote($_POST);
				}
			}
			
			$userID = $user->getUserID();
			
			$vals['USER_ID']    = $userID;
			$vals['USERNAME']	= $username;
			$vals['CONTENT']	= ($displayContent)? $displayContent: NULL;
			$vals['CANCEL']		= ($edit)? "cancel": NULL;
			$vals['NOTES']		= ($edit)? NULL: new NoteListView($userID, NoteType::ALL);
			$vals['EDIT']		= ($edit)? "?noteID=" . $noteID . "&edit=1": NULL;
			$vals['ISPUBLIC']	= $isPublicCheck;
            $vals['CREATE_NOTE_CATEGORIES'] = new NoteCategoryView();
            
            if ($user->getRank())
            {
                $vals['REPORTED'] = new ReportedNoteView();
            }
		}

        return $vals;
	}
}


?>