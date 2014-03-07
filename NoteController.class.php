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
		 * Retrieves all notes published by a $user, depending on $status
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
		public static function AddNote($ownerID, $content, $category, $isPublic)
		{
			$isPublic = isset($values['isPublic'])? '1': '0';
		
			$note = new Note(-1, $ownerID, $content, $isPublic, NULL, NULL, $category, 0, 0);

			return NoteModel::addNote($note);	
		}
        
        public static function addNoteReply($parentNoteID, $ownerID, $content, $isPublic, $category)
        {
            $note = new Note(-1, $ownerID, $content, $isPublic, NULL, NULL, $category, 0, 0);
            $newNoteID = NoteModel::addNote($note);
			return NoteModel::addNotereply($parentNoteID, $newNoteID);	
        }
		
		/**
		 * Retrieves a note Object from NoteModel based on noteID.
		 *
		 * @Param ID for the Note object to retrieve.
		 * @return Object Note.
		 */
		public static function requestNote($noteID)
		{
			return NoteModel::getNote($noteID);
		}
		
        public static function requestNoteByCategory($category)
        {
            return NoteModel::getNoteByCategory($category);
        }
        
		/**
		 * Updates a note based on new $values.
		 *
		 * @Param Associated array that's replacing the notes values.
		 */
		public static function requestEditNote($values)
		{
			$isPublic = isset($values['isPublic'])? '1': '0';
			
			$note = new Note($values['noteID'],
							 $values['ownerID'],
							 $values['content'],
							 $isPublic,
							 -1,
							 $values['username'],0);
							 
			NoteModel::editNote($note);
		}
		
		/**
		 * Deleting a note by its noteID.
		 *
		 * @Param ID the Notes object id.
		 */
		public static function requestDeleteNote($noteID)
		{
			NoteModel::deleteNote($noteID);
		}
        
        public static function submitAttatchment($noteID, $file)
        {
           // $fileSize = $file['size'];
            $fileName = $file['name'];
            
            if (is_uploaded_file($file['tmp_name']))  // If file is uploaded 
            {
                NoteModel::submitAttachment($noteID, $file, $fileName);
            }
            else
                return NULL;
        }
        
        public static function requestReplies($parentNode)
        {
           return NoteModel::getReplies($parentNode);
		}

        /**
         * Registers a vote for a note
         * @param integer $ownerID  The ID of the user that votes
         * @param integer $noteID   The ID of the note which the user votes n
         * @param integer $voteType Type of vote (0 = downvote, 1 = upvote)
         * @return integer: 
         *  1 - Vote didn't exist, it has been created
         *  2 - A vote of this type already existed and is now removed
         *  3 - A down of the opposite type already existed and has been converted
         */
        public static function registerVote($noteID, $ownerID, $voteType)
        {
            return NoteModel::saveVote($noteID, $ownerID, $voteType);
        }
        
        /**
         * Gets the vote status for a user for a note
         * @param integer $noteID The ID of the note we need the status on
         * @param integer $userID The ID of the user which wants to see their status
         * @return integer An enum indicating the status, see VoteStatus.class.php
         */
        public static function requestVoteStatus($noteID, $userID)
        {
            return NoteModel::getVoteStatus($noteID, $userID);   
        }
        
        /**
         * Flags a note for review by an administrator
         * @param integer $noteID The ID of the note we are reporting
         * @param integer $userID The ID of the user which reports the note
         */
        public static function reportNote($noteID, $userID)
        {
            NoteModel::reportNote($noteID, $userID);
        }
	}
?>