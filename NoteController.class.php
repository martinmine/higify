<?php
//require_once('DatabaseManager.class.php');
require_once('SessionController.class.php');
require_once('NoteType.class.php');
require_once('NoteModel.class.php');

	/**
	 *
	 */
	class NoteController
	{
		/**
		 * Retrieves all notes published by a $user, depending on $status.
		 * (show public notes, private... ) see NoteModel.class.php for more.
		 *
		 * @param $user user-Object  the logged in user.
		 * @param $noteOwnerID integer userID for the owner of the desired notes to display.
		 * @param $condition const (enum) for showing desired notes.
		 */
		function requestNotesFromUser($noteOwnerID, $condition = NoteType::NONE)
		{
			$user = SessionController::requireLoggedinID();
			
			if (($noteOwner = UserController::requestUserByID($noteOwnerID)) !== NULL)
			{
				if ($user->getID() === $noteOwner->getID())
				{
					$condition = NoteType::ALL;
				}
				else
				{
					if ($condition === NoteType::PRIVATE_ONLY  ||  $condition === NoteType::NONE)
						return NULL;
				
					return NoteModel::getNotesFromOwner($noteOwnerID, $condition);
					
				}
			}
			else
				return NULL;
		}
	
	}


?>