<?php
require_once('databaseManager.class.php');
require_once('NoteType.class.php');
require_once('Note.class.php');
require_once('VoteStatus.class.php');

/**
 * 
 * @author  Thomas Mellemseter
 * @version 1.0
 * @uses db
 * @uses note.class
 */
class NoteModel
{	
  
  /**
   * Genereates an array of Note objects - one object for each
   * note defined in the database. 
   * 
   * @return Note[] An array of note-objects for each note defined
   *         in the database with the owners username.
   * @uses Note
   * @throws PDOException
   */
	public static function getNotesFromOwner($ownerID, $condition)
	{
		if ($condition === NoteType::NONE)
		{
			return NULL;
		}
		else
		{
			$db = DatabaseManager::getDB();
			$res = array();
			$query = 'SELECT noteID, ownerID, content, isPublic, timePublished, username, category, points
						FROM note
						JOIN user ON (user.userID = ownerID)
						WHERE ownerID = :ownerID';
						
			if ($condition !== NoteType::ALL)
			{
				$query .= ' AND isPublic = ';
				$query .= ($condition === NoteType::PUBLIC_ONLY)? '1': '0';
			}
            
			$query .= ' ORDER BY noteID DESC';
			
			$stmt = $db->prepare($query);
			$stmt->bindParam(':ownerID', $ownerID);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$res[] = self::fetchNote($row);
			}
            
			return $res;
		}
	}
	
	/**
	 * Get all notes on some condition. limited condition of course
	 * Change comment when done... obviously :
	 */
	public function getAllPublicNotes($condition = NULL)
	{
		
		
		
	}
    
    /**
     * Fetches a note from a database row
     * @param Array $row The associative array from the row
     * @return Note A fetched note object from the row
     */
    private static function fetchNote($row)
    {
        return new Note($row['noteID'],
                        $row['ownerID'],
                        $row['content'],
                        $row['isPublic'],
                        $row['timePublished'],
                        $row['username'],
                        $row['category'],
                        $row['points'], 
                        self::getReplyCount($row['noteID']));
    }
	
	/**
	 * Adds a new Note object with data int the library to the database
	 *
	 * @Param Note $note A Note object holding the data to be added
	 *        to the database.
     * @return The ID of the note which was created
	 */
	public static function addNote($note)
	{
		$db = DatabaseManager::getDB();
		$query = 'INSERT INTO note '
			   . '(ownerID, content, category, isPublic) '
			   . 'VALUES(:ownerID, :content, :category, :isPublic)';
			   
		$ownerID = $note->getOwnerID();
		$content = $note->getContent();
        $category = $note->getCategory();
		$isPublic = $note->IsPublic();
		   
		$stmt = $db->prepare($query);
		$stmt->bindParam(':ownerID',  $ownerID   );
		$stmt->bindParam(':content',  $content   );
		$stmt->bindParam(':isPublic', $isPublic  );
        $stmt->bindParam(':category', $category  );
		$stmt->execute();
        
        return $db->lastInsertId();
	}
    
    
    public static function getReplies($parentNote)
    {
        $query = "SELECT noteID, username, ownerID, content, isPublic, timePublished, category, points
                  FROM note
                  JOIN notereply ON (note.noteID = notereply.childNoteID)
                  JOIN user ON (note.ownerID = user.userID)
                  WHERE notereply.parentNoteID = :parentNote";
        
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':parentNote', $parentNote);
        $stmt->execute();
        $res = array();
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $res[] = self::fetchNote($row);
        }
        
        return $res;
    }
    
    /**
     * Adds a reply to a note
     * @param integer $parentNoteID ID of the parent note which we are posting a comment on
     * @param integer $childNoteID The new reply we are inserting to the database
     */
    public static function addNotereply($parentNoteID, $childNoteID)
	{
		$db = DatabaseManager::getDB();
        $query = 'INSERT INTO notereply(parentNoteID, childNoteID)
                   VALUES(:parentNote, :childNote)';
            
        $stmt = $db->prepare($query);
        $stmt->bindparam(':parentNote', $parentNoteID);
        $stmt->bindparam(':childNote', $childNoteID);
        $stmt->execute();
	}
	
	/**
	 * Retrieves a single note from the database based on the parameter.
	 *
	 * @param ID the notes unique id.
	 * @return returning the requested note Object.
	 */
	public static function getNote($noteID)
	{
		$db = DatabaseManager::getDB();
		$query = 'SELECT noteID, ownerID, content, isPublic, timePublished, username, category, points 
				  FROM note
				  JOIN user ON (user.userID = ownerID)
				  WHERE noteID = :noteID';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':noteID', $noteID);
		$stmt->execute();
		$obj = $stmt->fetch(PDO::FETCH_ASSOC);

        return self::fetchNote($obj);	
	}
	
	/**
	 * Updating an existing note in the database.
	 *
	 * @param Object note with the new values to update.
	 */
	public static function editNote($note)
	{
		$db = DatabaseManager::getDB();
		$query = 'UPDATE note
				  SET content = :content, isPublic = :isPublic, timePublished = NOW()
				  WHERE noteID = :noteID';
		$stmt = $db->prepare($query);
		
		$content  = $note->getContent();
		$isPublic = $note->isPublic();
		$noteID   = $note->getNoteID();
		
		$stmt->bindParam(':content', $content);
		$stmt->bindParam(':isPublic', $isPublic);
		$stmt->bindParam(':noteID', $noteID );
		$stmt->execute();
	}
	
	/**
	 * Deleting a note from the database.
	 *
	 * @Param ID objects unique id.
	 */
	public static function deleteNote($noteID)
	{
		$db = DatabaseManager::getDB();
		$query = 'DELETE FROM note
				   WHERE noteID = :noteID';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':noteID', $noteID);
		$stmt->execute();
	}
    
    public static function submitAttachment($noteID, $file, $fileName)
    {
        
        $db = DatabaseManager::getDB();                                         
        
        $query = "INSERT INTO noteattachment(noteID, attachment, attachmentName)
                  Values(:noteID, :attachment, :attachmentname)";
        
        $stmt = $db->prepare($query);
        $stmt->bindparam(':noteID',$noteID);
        $stmt->bindparam(':attachment',$file['tmp_name']);
        $stmt->bindparam(':attachmentname',$fileName);
        $stmt->execute();
    }
    
    /**
     * Saves one vote
     * @param integer $ownerID The user ID that owns the vote
     * @param integer $noteID  The ID of the note being voted at
     * @param integer $type    Type of vote (0 = downvote, 1 = upvote)
     * @return integer: 
     *  1 - Vote didn't exist, it has been created
     *  2 - A vote of this type already existed and is now removed
     *  3 - A down of the opposite type already existed and has been converted
     */
    public static function saveVote($noteID, $ownerID, $type)
    {
        $db = DatabaseManager::getDB();
        
        if ($type == 0) // downvote
            $stmt = $db->prepare('CALL downvote(:noteid, :userid)');
        else // upvote
            $stmt = $db->prepare('CALL upvote(:noteid, :userid)');
            
        $stmt->bindParam(':noteid', $noteID);
        $stmt->bindParam(':userid', $ownerID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        
        return $result[0];
    }
    
    /**
     * Gets the note status for a note
     * @param integer $noteID The ID of the note to get status from
     * @param integer $userID The ID of the user which shall see his note status
     * @return integer An enum which is defined in VoteStatus.class.php
     */
    public static function getVoteStatus($noteID, $userID)
    {
        $db = DatabaseManager::getDB();
        
        $stmt = $db->prepare('SELECT type FROM notevote WHERE noteID = :noteID AND userID = :userID');
        $stmt->bindParam(':noteID', $noteID);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        
        if ($result[0] === NULL)
            return VoteStatus::NO_VOTE;
        else
            return $result[0];
    }
    
    /**
     * Gets the count of replies for one note
     * @param integer $noteID The note ID to get comments count from
     * @return integer The reply count
     */
    public static function getReplyCount($noteID)
    {
        $db = DatabaseManager::getDB();
        
        $stmt = $db->prepare('SELECT COUNT(parentNoteID) FROM notereply WHERE parentNoteID = :noteID');
        $stmt->bindParam(':noteID', $noteID);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }
    
    /**
     * Stores the note report in the database
     * @param integer $noteID The ID of the note we are reporting
     * @param integer $userID The ID of the user which reports the note
     */
    public static function reportNote($noteID, $userID)
    {
        $db = DatabaseManager::getDB();
        
        $stmt = $db->prepare('REPLACE INTO ReportedNote (noteID, userID) VALUES (:noteID, :userID)');
        $stmt->bindParam(':noteID', $noteID);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
    }
}

?>