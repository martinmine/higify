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
			$query = 'SELECT noteID, ownerID, content, isPublic, timePublished, username, points
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
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$timestamp = date('d M H:i', strtotime($row['timePublished']));
				
				$res[] = new Note($row['noteID'], $row['ownerID'],
								  $row['content'], $row['isPublic'],
								  $timestamp, $row['username'], $row['points']);
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
	 * Adds a new Note object with data int the library to the database
	 *
	 * @Param Note $note A Note object holding the data to be added
	 *        to the database.
	 */
	public static function addNote($note)
	{
		$db = DatabaseManager::getDB();
		$res = 0;
		$query = 'INSERT INTO Note '
			   . '(ownerID, content, isPublic) '
			   . 'VALUES(:ownerID, :content, :isPublic)';
			   
		$ownerID = $note->getOwnerID();
		$content = $note->getContent();
		$isPublic = $note->IsPublic();
		   
		try
		{
			$stmt = $db->prepare($query);
			$stmt->bindParam(':ownerID',  $ownerID   );
			$stmt->bindParam(':content',  $content   );
			$stmt->bindParam(':isPublic', $isPublic  );
			$stmt->execute();
		}
		catch(Exception $e)
		{
			trigger_error($e);
		}
		return $res;
	}
    
    
    public static function getReplies($parentNote)
    {
        $query = "SELECT noteID, ownerID, content, isPublic, timePublished, points
                  FROM note
                  JOIN notereply ON (note.noteID = notereply.childNoteID)
                  WHERE notereply.parentNoteID = :parentNote";
        
        $db = DatabaseManager::getDB();
        $stmt->bindParam(':parentNote', $parentNote);
        $stmt->execute();
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $timestamp = date('d M H:i', strtotime($row['timePublished']));
            
            $res[] = new Note($row['noteID'], $row['ownerID'],
                              $row['content'], $row['isPublic'],
                              $timestamp, $row['username'], $row['points']);
        }
        
        return $res;
    }
    
    /**
     * Adds a reply to a note
     * @param $parentNote ID of orignial note that is being replied to
     * @param $note The reply
     * @return
     */
    public static function addNotereply($parentNote, $note)
	{
		$db = DatabaseManager::getDB();
		$res = 0;
		$query1 = 'INSERT INTO note(ownerID, content, isPublic)
			       VALUES(:ownerID, :content, :isPublic)';
        
		$ownerID = $note->getOwnerID();
		$content = $note->getContent();
		$isPublic = 1;
        
		try
		{
			$stmt1 = $db->prepare($query1);
			$stmt1->bindParam(':ownerID',  $ownerID   );
			$stmt1->bindParam(':content',  $content   );
			$stmt1->bindParam(':isPublic', $isPublic  );
			$stmt1->execute();
            
            $query2 = 'INSERT INTO notereply(parentNoteID, childNoteID)
                      VALUES(:parentNote, :childNote)';
            
            $stmt2 = $db->prepare($query2);
            $stmt2->bindparam(':parentNode', $parentNode);
            $stmt2->bindparam(':childNode', $ownerID);
            $stmt2->execute();
		}
		catch(Exception $e)
		{
			trigger_error($e);
		}
		return $res;
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
		$query = 'SELECT noteID, ownerID, content, isPublic, timePublished, username, points 
				  FROM note
				  JOIN user ON (user.userID = ownerID)
				  WHERE noteID = :noteID';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':noteID', $noteID);
		$stmt->execute();
		$obj = $stmt->fetch(PDO::FETCH_ASSOC);
		$note = new Note($obj['noteID'],
						 $obj['ownerID'],
						 $obj['content'],
						 $obj['isPublic'],
						 $obj['timePublished'],
						 $obj['username'],
                         $obj['points']);

        return $note;	
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
}

?>