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
    
    public function getNote()
    {
        return $this->note;
    }
    
    public function getReporterUsername()
    {
        return $this->reporterUsername;
    }
    
    public function getReporterID()
    {
        return $this->reporterID;
    }
}
?>