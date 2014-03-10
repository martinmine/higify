<?php
require_once('UserController.class.php');
require_once('SessionController.class.php');
require_once('Template/IPageController.interface.php');
require_once('SearchResultsListView.class.php');

/**
 * Handel the page for viewing the search results.
 * 
 * @uses UserController.class.php
 */
class SearchResultsPageController implements IPageController
{	
	/**
	 * Putting search results together.
	 *
	 * @uses SessionController.
	 */
	public function onDisplay()
	{
		$condition = (isset($_GET['searchterm']))? $_GET['searchterm']: NULL;
		$user = SessionController::acquireSession();	// Requesting the logged in user.
		$vals = array();
		
		/**
		 * Can only view a mainpage for logged in users
		 * else a warning message is displayed.
		 */
		if ($user !== NULL  &&  $condition !== NULL)
		{
			$results = UserController::requestSearchResults($_GET['searchterm']);
			
			if (count($results) > 0)
				$vals['RESULTS'] = new SearchResultsListView($results);
			else
				$vals['RESULTS'] = 'Nothing related to ' . $_GET['searchterm'] . ' was found.';
		}
		else
		{
			$vals['RESULTS'] = 'It looks like you don\'t have permission to do this. Are you logged in?';
		}
        return $vals;
	}
}


?>