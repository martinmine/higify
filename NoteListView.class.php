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
	public function __construct($noteOwnerID = NULL, $noteType = NoteType::NONE)
	{
		//echo $noteType;
		if ($noteOwnerID !== NULL)
		{		
			$userID = SessionController::requestLoggedinID();
			if ($noteOwnerID === $userID || ($noteOwnerID !== $userID  &&  $noteType === NoteType::PUBLIC_ONLY))
			{
				$this->notes = NoteController::requestNotesFromUser($noteOwnerID, $noteType);
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
            
            $tpl->setValue('USER_ID', $note->getOwnerID());
            $tpl->setValue('USERNAME', $note->getUsername());
            $tpl->setValue('TIME', $note->getTime());
            $tpl->setValue('CONTENT', $note->getContent());
            
            $tpl->setValue('VOTE_BALANCE', '12'); // TODO
            
            $tpl->setValue('NOTE_ATTACHMENT_CONTAINER', ''); // TODO
            $tpl->setValue('REPLY_COUNT', 12);
            
            $tpl->setValue('CATEGORY', '');
            $tpl->setValue('CATEGORY_LINK', '');
            
            $tpl->setValue('DISPLAY_EDIT', ($username === $noteOwner));
            $tpl->setValue('DISPLAY_DELETE', ($username === $noteOwner));
            $tpl->setValue('DISPLAY_REPORT', ($username !== $noteOwner));
			
			$tpl->display();
		}
	}
}

?>