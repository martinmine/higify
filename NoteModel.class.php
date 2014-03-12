<?php
require_once('databaseManager.class.php');
require_once('NoteType.class.php');
require_once('Note.class.php');
require_once('VoteStatus.class.php');
require_once('ReportedNote.class.php');

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
			$query = 'SELECT Note.noteID, Note.ownerID, Note.content, Note.isPublic, Note.timePublished, User.username,
                        Note.category, Note.points, PosterUser.username AS OP, NoteReply.parentNoteID as parent
                        FROM Note
                        JOIN User ON (User.userID = ownerID)
                        LEFT OUTER JOIN NoteReply ON (Note.noteID = NoteReply.childNoteID)
                        LEFT OUTER JOIN Note AS NoteParent ON (NoteReply.parentNoteID = NoteParent.noteID)
                        LEFT OUTER JOIN User AS PosterUser ON (NoteParent.ownerID = PosterUser.userID)
                        WHERE Note.ownerID = :ownerID';
						
			if ($condition !== NoteType::ALL)
			{
				$query .= ' AND Note.isPublic = ';
				$query .= ($condition === NoteType::PUBLIC_ONLY)? '1': '0';
			}
            
			$query .= ' ORDER BY Note.noteID DESC';
			
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
                        $row['OP'],
                        $row['parent'],
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
		$query = 'INSERT INTO Note '
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
        $query = 'SELECT Note.noteID, Note.ownerID, Note.content, Note.isPublic, Note.timePublished, User.username,
                  Note.category, Note.points, PosterUser.username AS OP, NoteParent.noteID as parent
                  FROM Note
                  JOIN NoteReply AS Reply ON (Note.noteID = Reply.childNoteID)
                  JOIN User ON (User.userID = ownerID)
                  LEFT OUTER JOIN Note AS NoteParent ON (Reply.parentNoteID = NoteParent.noteID)
                  LEFT OUTER JOIN User AS PosterUser ON (NoteParent.ownerID = PosterUser.userID)
                  WHERE Reply.parentNoteID = :parentNote';
        
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
        $query = 'INSERT INTO NoteReply (parentNoteID, childNoteID)
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
		$query = 'SELECT Note.noteID, Note.ownerID, Note.content, Note.isPublic, Note.timePublished, User.username,
                  Note.category, Note.points, PosterUser.username AS OP, NoteReply.parentNoteID as parent
                  FROM Note
                  JOIN User ON (User.userID = ownerID)
                  LEFT OUTER JOIN NoteReply ON (Note.noteID = NoteReply.childNoteID)
                  LEFT OUTER JOIN Note AS NoteParent ON (NoteReply.parentNoteID = NoteParent.noteID)
                  LEFT OUTER JOIN User AS PosterUser ON (NoteParent.ownerID = PosterUser.userID)
                  WHERE Note.noteID = :noteID';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':noteID', $noteID);
		$stmt->execute();
		$obj = $stmt->fetch(PDO::FETCH_ASSOC);

        return self::fetchNote($obj);	
	}
    
    public static function getNoteByCategory($category)
    {
        $res = array();
		$db = DatabaseManager::getDB();
        
		$query = 'SELECT Note.noteID, Note.ownerID, Note.content, Note.isPublic, Note.timePublished, User.username,
                  Note.category, Note.points, PosterUser.username AS OP, NoteReply.parentNoteID as parent
                  FROM Note
                  JOIN User ON (User.userID = ownerID)
                  LEFT OUTER JOIN NoteReply ON (Note.noteID = NoteReply.childNoteID)
                  LEFT OUTER JOIN Note AS NoteParent ON (NoteReply.parentNoteID = NoteParent.noteID)
                  LEFT OUTER JOIN User AS PosterUser ON (NoteParent.ownerID = PosterUser.userID)
                  WHERE Note.category = :cat';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':cat', $category);
		$stmt->execute();
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $res[] = self::fetchNote($row);
        
        return $res;
    }
	
	/**
	 * Updating an existing note in the database.
	 *
	 * @param Object note with the new values to update.
	 */
	public static function editNote($note)
	{
		$db = DatabaseManager::getDB();
		$query = 'UPDATE Note
				  SET Content = :content, isPublic = :isPublic, category = :cat
				  WHERE noteID = :noteID';
		$stmt = $db->prepare($query);
		
		$content  = $note->getContent();
		$isPublic = $note->isPublic();
		$noteID   = $note->getNoteID();
        $category = $note->getCategory();
		
		$stmt->bindParam(':content', $content);
		$stmt->bindParam(':isPublic', $isPublic);
		$stmt->bindParam(':noteID', $noteID);
        $stmt->bindParam(':cat', $category);
		$stmt->execute();
	}
	
	/**
	 * Deleting a note from the database.
     * The first query deletes the actuall note
     * while the second query deletes attachment related to the note
	 *
	 * @Param ID Note objects unique id.
	 */
	public static function deleteNote($noteID)
	{
		$db = DatabaseManager::getDB();
		$query1 = 'DELETE FROM Note
				   WHERE noteID = :noteID';
		$stmt1 = $db->prepare($query1);
		$stmt1->bindParam(':noteID', $noteID);
		$stmt1->execute();
        
        $query2 = 'DELETE FROM NoteAttachment
                   WHERE noteID = :noteID';
        $stmt2 = $db->prepare($query2);
        $stmt2->bindparam(':noteID', $noteID);
        $stmt2->execute();
		
		$query3 = 'DELETE FROM NoteReply
				   WHERE childNoteID = :noteID';
		$stmt3 = $db->prepare($query3);
		$stmt3->bindParam(':noteID', $noteID);
		$stmt3->execute();
	}
    
    public static function submitAttachment($noteID, $file, $fileName)
    {   
        $db = DatabaseManager::getDB();                                         
        
        $query = "INSERT INTO NoteAttachment(noteID, attachment, attachmentName)
                  VALUES(:noteID, :attachment, :attachmentname)";
        
        $theFile = file_get_contents($file['tmp_name']);          
        $stmt = $db->prepare($query);
        $stmt->bindparam(':noteID', $noteID);
        $stmt->bindparam(':attachment', $theFile);
        $stmt->bindparam(':attachmentname', $fileName);
        $stmt->execute();
    }
    
    /**
     * Gets all the attachments which has been added to one note
     * @param integer $noteID The ID of the note to get attachments for
     * @return Associative array: AttachmentID => Name
     */
    public static function getNoteAttachments($noteID)
    {
        $db = DatabaseManager::getDB();                                         
        
        $query = "SELECT attachmentID, attachmentName
                  FROM NoteAttachment
                  WHERE noteID = :noteID";
        $stmt = $db->prepare($query);
        $stmt->bindparam(':noteID', $noteID);
        $stmt->execute();
        
        $attachments = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $attachments[$row['attachmentID']] = $row['attachmentName'];
        
        return $attachments;
    }
    
    /**
     * Gets an note attachment from the database
     * @param integer $attachmentID ID of the attachment
     * @return Array where the first index is name and second is the content of the file
     */
    public static function getNoteAttachment($attachmentID)
    {
        $db = DatabaseManager::getDB();                                         
        
        $query = "SELECT attachment, attachmentName
                  FROM NoteAttachment
                  WHERE attachmentID = :attachmentID";
        $stmt = $db->prepare($query);
        $stmt->bindparam(':attachmentID', $attachmentID);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row === NULL)
            return NULL;
            
        return array($row['attachmentName'], $row['attachment']);
    }
    
    /**
     * Gets the reported notes from database
     * @return Array of ReportedNotes
     */
    public static function getReportedNotes()
    {
        $query = 'SELECT Note.noteID, Note.ownerID, Note.content, Note.isPublic, Note.timePublished, User.username,
                  Note.category, Note.points, PosterUser.username AS OP, NoteReply.parentNoteID as parent, 
                  ReportedNote.userID as reporterID, ReportingUser.username AS reporter
                  FROM ReportedNote
                  JOIN Note ON (ReportedNote.noteID = Note.noteID)
                  JOIN User ON (User.userID = ownerID)
                  LEFT OUTER JOIN NoteReply ON (Note.noteID = NoteReply.childNoteID)
                  LEFT OUTER JOIN Note AS NoteParent ON (NoteReply.parentNoteID = NoteParent.noteID)
                  LEFT OUTER JOIN User AS PosterUser ON (NoteParent.ownerID = PosterUser.userID)
                  JOIN User AS ReportingUser ON (ReportingUser.userID = ReportedNote.userID)';
                  
        $notes = array();
        $db = DatabaseManager::getDB();
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $notes[] = new ReportedNote(self::fetchNote($row), $row['reporter'], $row['reporterID']);
        }
        
        return $notes;
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
        
        $stmt = $db->prepare('SELECT type FROM NoteVote WHERE noteID = :noteID AND userID = :userID');
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
        
        $stmt = $db->prepare('SELECT COUNT(parentNoteID) FROM NoteReply WHERE parentNoteID = :noteID');
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
    
    public static function ignoreReportedNote($noteID, $reporterID)
    {
        $db = DatabaseManager::getDB();
        
        $stmt = $db->prepare('DELETE FROM ReportedNote WHERE noteID = :noteID AND userID = :userID');
        $stmt->bindParam(':noteID', $noteID);
        $stmt->bindParam(':userID', $reporterID);
        $stmt->execute();
    }
}

?>