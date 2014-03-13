<?php
class ReportedNote
{
    /**
     * The note which was reported
     * @var Note
     */
    private $note;
    
    /**
     * The username of the user who reported this note
     * @var string
     */
    private $reporterUsername;
    
    /**
     * The ID of the user who reported this note
     * @var integer
     */
    private $reporterID;
    
    public function __construct($note, $username, $userID)
    {
        $this->note = $note;
        $this->reporterUsername = $username;
        $this->reporterID = $userID;
    }
    
	/**
	 * Retrieves a note from the database.  
	 *
	 * @return a note Object.
	 */
    public function getNote()
    {
        return $this->note;
    }

	/**
	 * Retrieves the username who reported a note. 
	 *
	 * @return varchar the username of a user.
	 */
    public function getReporterUsername()
    {
        return $this->reporterUsername;
    }
    
	/**
	 * Retrieves the id from a user who have reported a note. 
	 *
	 * @return int ID userID.
	 */
    public function getReporterID()
    {
        return $this->reporterID;
    }
}
?>