<?php
require_once('Template/Template.class.php');
require_once('Template/WebPageElement.class.php');
require_once('Template/EscapedHTMLView.class.php'); 
require_once('NoteType.class.php');
require_once('NoteController.class.php');
require_once('SessionController.class.php');
require_once('VoteStatus.class.php');
require_once('NoteAttachmentContainerView.class.php');

 /**
  * The view listing all reported note-elements
  *
  * @uses Template.class.php
  * @uses WebPageElement.class.php
  * @uses NoteType.class.php
  */
class ReportedNoteListView extends WebPageElement
{
	private $notes = NULL;
	
	/**
	 * A view of desired notes from a user.
	 * Parameters have to be set for security reasons.
	 *
	 * @param int $noteOwnerID ID of the owner of notes to display.
	 * @param NoteType $noteType desired notes to display.
	 */
	public function __construct()
	{
		$this->notes = NoteController::requestReportedNotes();
	}
	
	/**
	 * Creating a list of all notes.
	 * 
	 * @uses Template.class.php
	 */
	public function generateHTML()
	{
        $userID = SessionController::requestLoggedinID();
	
		foreach($this->notes as $reportedNote)
		{
            $note = $reportedNote->getNote();
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
            $tpl->setValue('DISPLAY_DELETE', true);
            $tpl->setValue('DISPLAY_REPORT', false);
            $tpl->setValue('DISPLAY_IGNORE', true);
            
            $tpl->setValue('REPORTER', $reportedNote->getReporterUsername());
            $tpl->setValue('REPORTERID', $reportedNote->getReporterID());
			
			$tpl->display();
		}
	}
}

?>