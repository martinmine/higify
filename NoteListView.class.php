<?php
require_once('Template/Template.class.php');
require_once('NoteType.class.php');


class NoteListView
{
	
	public function generateDocument()
	{
		$tpl = new Template();
		$tpl->appendTemplate('');
		$tpl->registerController(new LoginController());
		$tpl->appendTemplate('');
		$tpl->appendTemplate('');
		$tpl->display();
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