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
		public static function requestNotesFromUser($noteOwnerID, $condition = NoteType::NONE)
		{
			
			$userID = SessionController::requestLoggedinID();
			$noteOwner = UserController::requestUserByID($noteOwnerID);
			
			if ($noteOwner !== NULL)
			{	
				//	When displaying other users notes - ONLY notes flagged public is allowed:
				if ($userID !== $noteOwner->getUserID()  &&  $condition !== NoteType::PUBLIC_ONLY)
					return NULL;
				
				return NoteModel::getNotesFromOwner($noteOwnerID, $condition);
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
		public static function requestAllPublicNotes($condition, $order)
		{
			if ($this->user !== NULL)
			{
				
				
				return NULL;
			}
			return NULL;
		}
		
		/**
		 * Adding a new note to the database.
		 *
		 * @param Array of values that should be added ($_POST);
		 */
		public static function requestAddNote($values)
		{
			$isPublic = isset($values['isPublic'])? '1': '0';
		
		
			$note = new Note(-1, 
							 $values['userID'], 
							 $values['content'],
							 $isPublic,
							 date('UTC'),
							 $values['username']
							);
							
			NoteModel::addNote($note);	
		}
	}

?>