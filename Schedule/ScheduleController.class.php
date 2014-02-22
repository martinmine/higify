<?php
require_once('ScheduleModel.class.php');
require_once('PullFormat.class.php');
require_once('OutputType.class.php');
require_once('ObjectType.class.php');
require_once('ITimeParameter.class.php');

class ScheduleController
{
    /**
     * Saves the schedule for a user in the database
     * @param string  $scheduleData The POST data from the schedule wizard (JSON)
     * @param integer $userID User's ID
     */
    public static function saveSchedule($scheduleData, $userID)
    {
        $schedule = json_decode($scheduleData);
        
        ScheduleModel::clearSchedule($userID);
        
        foreach ($schedule as $timeObject)
        {
            ScheduleModel::addIncludedTimeObject($userID, $timeObject->id, $timeObject->type);
            
            $scheduleElements = $timeObject->results;
            foreach ($scheduleElements as $lecture)
            {
                if (!$lecture->enabled)
                {
                    ScheduleModel::addExcludingTimeObject($userID, $lecture->code, 183);
                }
            }
        }
    }
    
    public static function fetchTimeTable($userID)
    {
        $includedObjects = ScheduleModel::getIncludeObjects($userID);
        $exludedObjects = ScheduleModel::getExcludingTimeObject($userID);
        

        
        print_r($includedObjects);
        echo '<br/>';
        print_r($exludedObjects);
        
        // Merge and exclude
    }
}

?>