<?php
require_once('../DatabaseManager.class.php');
class ScheduleModel
{
    /**
     * Clears the schedule for a user
     * @param integer $userID The users ID
     */
    public static function clearSchedule($userID)
    {
        $pdo = DatabaseManager::getDB();
        
        $query = $pdo->prepare('DELETE FROM IncludedTimeObject WHERE userID = :userid');
        $query->bindParam(':userid', $userID);
        $query->execute();
        
        $query = $pdo->prepare('DELETE FROM ExludedTimeObject WHERE userID = :userid');
        $query->bindParam(':userid', $userID);
        $query->execute();
    }
    
    /**
     * Adds one time object to get the schedule for
     * @param integer $userID Users ID
     * @param integer $objectID The object ID
     * @param integer $type Objects type (Room, class, lecturer, etc.)
     */
    public static function addIncludedTimeObject($userID, $objectID, $type)
    {
        $pdo = DatabaseManager::getDB();
        
        $query = $pdo->prepare('INSERT INTO IncludedTimeObject (objectID, userID, type) VALUES (:objID, :usrID, :type)');
        $query->bindParam(':objID', $objectID);
        $query->bindParam(':usrID', $userID);
        $query->bindParam(':type', $type);
        $query->execute();    
    }
    
    /**
     * Adds an item that shall be excluded from the schedule when the user retreives the schedule
     * @param integer $userID  Users ID
     * @param string  $content Gernally used is the course code
     * @param integer $type    Type of the item that shall be excluded
     */
    public static function addExcludingTimeObject($userID, $content, $type)
    {
        $pdo = DatabaseManager::getDB();
        
        $query = $pdo->prepare('INSERT INTO ExludedTimeObject (userID, content, type) VALUES (:usrID, :content, :type)');
        $query->bindParam(':usrID', $userID);
        $query->bindParam(':content', $content);
        $query->bindParam(':type', $type);
        $query->execute();    
    }
    
    /**
     * Gets an object that shall be requested from TimeEdit from the database
     * @param integer $userID The ID of the user to be requested
     * @return Array of object IDs
     */
    public static function getIncludeObjects($userID)
    {
        $objects = array();
        
        $pdo = DatabaseManager::getDB();
        
        $query = $pdo->prepare('SELECT objectID from IncludedTimeObject WHERE userID = :usrID');
        $query->bindParam(':usrID', $userID);
        $query->execute();
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $objects[] = $row['objectID'];   
        }
        
        return $objects;
    }
    
    /**
     * Gets an item of key words that shall be excluded from the time schedule 
     * @param integer $userID Users ID
     * @return Array of key words that shall be excluded from the schedule
     */
    public static function getExcludingTimeObject($userID)
    {
        $contents = array();
        
        $pdo = DatabaseManager::getDB();
        
        $query = $pdo->prepare('SELECT content from ExludedTimeObject WHERE userID = :usrID');
        $query->bindParam(':usrID', $userID);
        $query->execute();
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $contents[] = $row['content'];   
        }
        
        return $contents;
    }   
}
?>