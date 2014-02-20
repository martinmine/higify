<?php
require_once('Template/Template.class.php');
include_once('Template/WebPageElement.class.php');
require_once('NoteType.class.php');
require_once('NoteController.class.php');

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
	
	public function __construct()
	{
		$userID = SessionController::requestLoggedinID();
		$this->notes = NoteController::requestNotesFromUser($userID, NoteType::ALL);
	}
	
	/**
	 * Creating a list of all notes.
	 * 
	 * @uses Template.class.php
	 */
	public function generateHTML()
	{
		
		foreach($this->notes as $note)
		{
			$tpl = new Template();
			$tpl->appendTemplate('NoteElement');
			$tpl->setValue('USERNAME', $note['username']);
			$tpl->setValue('CONTENT', $note['content']);
			$tpl->setValue('TIME', $note['timePublished']);
			$tpl->display();
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//	CODE BELOW  -  KEPT FOR LOOKING AT - DELETE WHEN DONE!
	
	public function generateDocument($noteList, $filter, $cssFile)
	{
		$res = "<html>\n"
			   . $this->generateHead('Notes', $cssFile)
			   . $this->generateBody('Notes', $noteList, $filter)
			   . "</html>\n";
		echo $res;
	}
  
	protected function generateHead($tabTitle, $css)
	{
		$res = "<!DOCTYPE html>\n
				<head>\n
				<meta charset='utf-8'>\n
				<link rel='stylesheet' type='text/css' href='" . $css . "'>\n
				<title>" . $tabTitle . "</title>\n
				</head>\n";
	return $res;
	}
  
	protected function generateBody($title, $noteList, $filter)
	{
		$len = count($noteList);
		$res = "<body>\n" 
			. '<div id="Container">'
			. '<h1>' . $title . "</h1>\n";
		
		if ($len > 0)
		{
			if ($filter != NoteType::NONE)
				$res .= $this->generateNoteList($noteList, $filter);
		}
		
		return $res . "</div></body>\n";
	}
  
	protected function generateNoteList($noteList, $filter)
	{
		$isPublic;
		
		$res = "<div id=\"Notes\"></br>\n";
		
		foreach($noteList as $note)
		{
			$isPublic = $note->IsPublic();
			
			if ($filter == NoteType::ALL  ||
			   (($filter == NoteType::PUBLIC_ONLY  &&  $isPublic)  ||
				($filter == NoteType::PRIVATE_ONLY  &&  !$isPublic)))
			{
				$res .= "<div class=\"Note\">\n"
					 .   "<b>" . $note->getOwnerName() . "</b></br>"
					 .   $note->getTime() . "<a href=\"#\">Edit</a>\t<a href=\"#\">Delete</a>"
					 .   "<div class=\"NoteContent\">\n"
					 .     utf8_encode($note->getContent())
					 .   "</div></br>\n"
					 . "</div>\n";
			}
		}
		return $res . "</div>\n";
	}
}

?>