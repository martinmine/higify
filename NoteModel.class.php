<?php
require_once('db.php');
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
  protected $db;      // @var PDO The database object.
  
  /**
   * Construct a new noteModel object.
   *
   * @throws PDOExeption
   */
  public function __construct()
  {
    $this->db = openDB();
  }
  
  /**
   * Genereates an array of Note objects - one object for each
   * note defined in the database. 
   * 
   * @return Note[] An array of note-objects for each note defined
   *         int the database
   * @uses Note
   * @throws PDOException
   */
  public function getNoteList()
  {
    $res = array();
    $query = 'SELECT noteID, ownerID, content, isPublic, userID, published, username
                FROM note, user
                WHERE userID = ownerID';
    
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $res[] = new Note($row['noteID'], $row['ownerID'],
                        $row['content'], $row['isPublic'],
                        $row['published'], $row['username']);
    }
    return $res;
  }
  
  /**
   * Adds a new Note object with data int the library to the database
   *
   * @Param Note $note A Note object holding the data to be added
   *        to the database.
   */
  public function addNote($note)
  {
  
    $res = 0;
    $query = 'INSERT INTO Note '
           . '(ownerID, content, isPublic) '
           . 'VALUES(:ownerID, :content, :isPublic)';
           
    $ownerID = $note->getOwnerID();
    $content = $note->getContent();
    $isPublic = $note->IsPublic();
           
    try
    {
      $stmt = $this->db->prepare($query);
      $stmt->bindParam(':ownerID',  $ownerID   );
      $stmt->bindParam(':content',  $content   );
      $stmt->bindParam(':isPublic', $isPublic  );
      $stmt->execute();
      return $this->db->lastInsertId();
      
    }
    catch(Exception $e)
    {
      trigger_error($e);
    }
    return $res;
  }
}

?>