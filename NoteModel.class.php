<?php
require_once('databaseManager.class.php');
require_once('NoteType.class.php');
require_once('Note.class.php');

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
			$query = 'SELECT noteID, ownerID, content, isPublic, timePublished, username
						FROM note
						JOIN user ON (user.userID = ownerID)
						WHERE ownerID = :ownerID';
						
			if ($condition !== NoteType::ALL)
			{
				$query .= ' AND isPublic = ';
				$query .= ($condition === NoteType::PUBLIC_ONLY)? '1': '0';
			}
			
			$stmt = $db->prepare($query);
			$stmt->bindParam(':ownerID', $ownerID);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$res[] = new Note($row['noteID'], $row['ownerID'],
								  $row['content'], $row['isPublic'],
								  $row['timePublished'], $row['username']);
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
			//return $this->db->lastInsertId();
		}
		catch(Exception $e)
		{
			trigger_error($e);
		}
		return $res;
	}
	
	public static function getNote($noteID)
	{
		$db = DatabaseManager::getDB();
		$query = 'SELECT noteID, ownerID, content, isPublic, timePublished, username
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
						 $obj['username']
						);
		return $note;	
	}
	
	public static function editNote($note)
	{
		$db = DatabaseManager::getDB();
		$query = 'UPDATE note
				  SET content = :content, isPublic = :isPublic, timePublished = :time
				  WHERE noteID = :noteID';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':content', $note->getContent() );
		$stmt->bindParam(':isPublic', $note->getContent() );
		$stmt->bindPrarm(':noteID', $note->getNoteID() );
		$stmt->execute();
		echo "</br>YEE?</br>";
	}
}

?>