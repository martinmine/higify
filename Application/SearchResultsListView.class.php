<?php
require_once('Template/Template.class.php');
include_once('Template/WebPageElement.class.php');
require_once('User/User.class.php');
require_once('User/UserController.class.php');

/**
  * The view listing all note-elements
  *
  * @uses Template.class.php
  * @uses WebPageElement.class.php
  * @uses NoteType.class.php
  */
class SearchResultsListView extends WebPageElement
{
	private $results = NULL;
	
	public function __construct($results)
	{
		$this->results = $results;
	}
	
	/**
	 * Creating a list of all notes.
	 * 
	 * @uses Template.class.php
	 */
	public function generateHTML()
	{	
		foreach($this->results as $hit)
		{			
			$tpl = new Template();
			$tpl->appendTemplate('HitElement');
			$tpl->setValue('USER_ID', $hit['userID']);
			$tpl->setValue('USERNAME', $hit['username']);
			$tpl->display();
		}
	}
}

?>