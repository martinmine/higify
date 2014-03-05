<?php
require_once('Template/Template.class.php');
include_once('Template/WebPageElement.class.php');
require_once('NoteType.class.php');
require_once('NoteController.class.php');
require_once('SessionController.class.php');

 /**
  * The view listing all note-elements
  *
  * @uses Template.class.php
  * @uses WebPageElement.class.php
  * @uses NoteType.class.php
  */
class NoteListView extends WebPageElement
{
	private $notes = NULL;
	
	/**
	 * A view of desired notes from a user.
	 * Parameters have to be set for security reasons.
	 *
	 * @param int $noteOwnerID ID of the owner of notes to display.
	 * @param NoteType $noteType desired notes to display.
	 */
	public function __construct($noteOwnerID = NULL, $noteType = NoteType::NONE, $parentNoteID = NULL)
	{
		//echo $noteType;
		if ($noteOwnerID !== NULL)
		{		
			$userID = SessionController::requestLoggedinID();
			if ($noteOwnerID === $userID || ($noteOwnerID !== $userID  &&  $noteType === NoteType::PUBLIC_ONLY))
			{
				$this->notes = NoteController::requestNotesFromUser($noteOwnerID, $noteType);
			}
            
            else if ($parentNoteID != NULL && $noteType === NoteType::REPLY)
            {
                $this->notes = NoteController::requestReplies($parentNoteID);
            }
            
			else
			{
				echo "Du har ikke tilgang til dette!"; // header('Location: mainpage.php');
			}
		}
		else
		{
			echo "Ops!"; //header('Location: mainpage.php');
		}
	}
	
	/**
	 * Creating a list of all notes.
	 * 
	 * @uses Template.class.php
	 */
	public function generateHTML()
	{
		$user     = SessionController::acquireSession();
		$username = $user->getUsername();
	
		foreach($this->notes as $note)
		{
			$noteOwner = $note->getUsername();
			
			$tpl = new Template();
			$tpl->appendTemplate('NoteElement');
			$tpl->setValue('USERNAME', $note->getUsername());
			$tpl->setValue('CONTENT', $note->getContent());
			$tpl->setValue('TIME', $note->getTime());
			$tpl->setValue('NOTEID', $note->getNoteID());
			$option1 = ($username === $noteOwner)? "edit": NULL;
			$option2 = ($username === $noteOwner)? "delete": NULL;
			$tpl->setValue('OPTION1', $option1);
			$tpl->setValue('OPTION2', $option2);
			$tpl->display();
		}
	}
}

?>