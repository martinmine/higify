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
			
			$vals['RESULTS'] = new SearchResultsListView();
			
		}
		else
		{
			//$vals['ERROR_MSG'] = new ErrorMessageView('No user is logged in...');
		}
        return $vals;
	}
}


?>