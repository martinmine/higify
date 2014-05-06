<?php
require_once('Template/Template.class.php');
require_once('Template/WebPageElement.class.php');
require_once('Template/EscapedHTMLView.class.php'); 
require_once('Note/NoteType.class.php');
require_once('Note/NoteController.class.php');
require_once('Note/VoteStatus.class.php');
require_once('Session/SessionController.class.php');
require_once('User/UserController.class.php');
require_once('NoteAttachmentContainerView.class.php');

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
	private $userRank;
    
	/**
	 * A view of desired notes from a user.
	 * Parameters have to be set for security reasons.
	 *
	 * @param int $noteOwnerID ID of the owner of notes to display.
	 * @param NoteType $noteType desired notes to display.
	 */
	public function __construct($noteOwnerID = NULL, $noteType = NoteType::NONE, $parentNoteID = NULL, $category = NULL, $noteCounter = 0)
	{
        $userID = SessionController::requestLoggedinID();
        $user = UserController::requestUserByID($userID);
        
        
        $this->userRank = $user->getRank();
        
		if ($noteOwnerID !== NULL)
		{		
			if ($noteOwnerID === $userID || ($noteOwnerID !== $userID  &&  $noteType === NoteType::PUBLIC_ONLY))
			{
               $this->notes = NoteController::requestNotesFromUser($noteOwnerID, $noteType, $noteCounter);
            }
              
			else
			{
				header('Location: mainpage.php');
			}
		}
        else if ($parentNoteID != NULL && $noteType === NoteType::REPLY)
        {
            $this->notes = NoteController::requestReplies($parentNoteID, $noteCounter);
        }
        else if ($noteOwnerID === NULL && $noteType === NoteType::NONE && $category === NULL)
        {
            $this->notes = array(NoteController::requestNote($parentNoteID));
        }
        else 
        {
           $this->notes = NoteController::requestNoteByCategory($category, $noteCounter);
        }
	}
	
	/**
	 * Creating a list of all notes.
	 * 
	 * @uses Template.class.php
	 */
	public function generateHTML()
	{
        $userID = SessionController::requestLoggedinID();
	
		foreach($this->notes as $note)
		{
            // If the note is public and the user has a rank
            if ($note->isPublic() || (!$note->isPublic() && ($this->userRank || $note->getOwnerID() == $userID)))
            {
			    $noteOwner = $note->getOwnerID();
                $voteStatus = NoteController::requestVoteStatus($note->getNoteID(), $userID);
                $upvoteImage = 'upvote_unselected';
                $downvoteImage = 'downvote_unselected';
            
                if ($voteStatus == VoteStatus::DOWNVOTED)
                    $downvoteImage = 'downvote_selected';
                if ($voteStatus == VoteStatus::UPVOTED)
                    $upvoteImage = 'upvote_selected';
			    $tpl = new Template();
			    $tpl->appendTemplate('NoteElement');
            
                $tpl->setValue('USER_ID', $note->getOwnerID());
                $tpl->setValue('NOTE_ID', $note->getNoteID());
                $tpl->setValue('USERNAME', $note->getUsername());
                $tpl->setValue('TIME', $note->getTime());
                $tpl->setValue('CONTENT', new EscapedHTMLView($note->getContent()));
            
                $tpl->setValue('VOTE_BALANCE', $note->getVoteBalance());
            
                $tpl->setValue('NOTE_ATTACHMENT_CONTAINER', new NoteAttachmentContainerView($note->getNoteID())); 
                $tpl->setValue('REPLY_COUNT', $note->getReplyCount());
                $tpl->setValue('UPVOTE_IMG', $upvoteImage);
                $tpl->setValue('DOWNVOTE_IMG', $downvoteImage);
            
                $tpl->setValue('CATEGORY', $note->getCategory());
                $tpl->setValue('CATEGORY_LINK', urlencode($note->getCategory()));
            
                $tpl->setValue('OP', $note->getOriginalPoster());
                $tpl->setValue('PARENT_ID', $note->getParentID());
            
                $tpl->setValue('DISPLAY_EDIT', ($noteOwner === $userID));
                $tpl->setValue('DISPLAY_DELETE', ($noteOwner === $userID));
                $tpl->setValue('DISPLAY_REPORT', ($noteOwner !== $userID));
                $tpl->setValue('DISPLAY_IGNORE', false);
			
			    $tpl->display();
            }
		}
	}
}

?>