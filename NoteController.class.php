<?php
require_once('db.php');
//require_once('SessionController.class.php');
require_once('NoteType.class.php');
require_once('NoteModel.class.php');

//require_once('UserController.class.php');

	/**
	 *
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
					
					/**
					 * Reflection:
					 * Put whats below in an variabel instead of 'return' and connect it with a view 
					 *
					 * maybe?
					 */
					 
					return NoteModel::getNotesFromOwner($noteOwnerID, $condition);
				}
			}
			return NULL;
		}
	
		/**
		 * Retrieves all public notes by every user except the one logged in.
		 * 
		 * @param string $condition filter only desired notes.
		 * @return array of note-objects.
		 */
		public function requestAllPublicNotes($condition)
		{
			if ($this->user !== NULL)
			{
				
				
				
			}
		}
	
	
	}

?>