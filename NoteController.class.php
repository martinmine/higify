<?php
require_once('NoteType.class.php');
require_once('NoteModel.class.php');
require_once('UserController.class.php');
require_once('SessionController.class.php');

	/**
	 * The controller between NoteModel and note-views (see template)
	 * It also request information from both users and the active user( the one logged in)
	 * for retrieving note-information and checking to allow viewing specific notes (e.g private)
	 *
	 * @uses NoteType.class.php
	 * @uses NoteModel.cass.php
	 * @uses UserController.class.php
	 */
	class NoteController
	{
	
		private $user = NULL;
		
		public function __construct()
		{
			$this->user = SessionController::requestLoggedinID();
		}
		
		/**
		 * Retrieves all notes published by a $user, depending on $status.
		 * (show public or private notes) see NoteModel.class.php for more.
		 * 
		 * @uses NoteModel.class.php
		 * @uses NoteType.class.php
		 * @param $user user-Object  the logged in user.
		 * @param $noteOwnerID integer userID for the owner of the desired notes to display.
		 * @param $condition const (enum) for showing desired notes.
		 * @return Array of note-objects with desired and legal $condition.
		 */
		public function requestNotesFromUser($noteOwnerID, $condition = NoteType::NONE)
		{
			
			//$user = SessionController::requestLoggedinID();
			if ($this->user !== NULL)
			{
				$noteOwner = UserController::requestUserByID($noteOwnerID);
				
				if ($noteOwner !== NULL)
				{	
					//	When displaying other users notes - ONLY notes flagged public is allowed:
					if ($this->user->getUserID() !== $noteOwner->getUserID()  &&  $condition !== NoteType::PUBLIC_ONLY)
						return NULL;
					 
					return NoteModel::getNotesFromOwner($noteOwnerID, $condition);
				}
			}
			return NULL;
		}
	
		/**
		 * EXTRA?
		 * Retrieves all public notes by every user except the one logged in.
		 * 
		 * @param string $condition filter only desired notes.
		 * @Order asc desc...
		 * @return array of note-objects.
		 */
		public function requestAllPublicNotes($condition, $order)
		{
			if ($this->user !== NULL)
			{
				
				
				return NULL;
			}
			return NULL;
		}
	
	
	}

?>