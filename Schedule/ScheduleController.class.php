<?php
require_once('ScheduleModel.class.php');
require_once('ScheduleLane.class.php');
require_once('ScheduleObject.class.php');
require_once('TimeEditAPI/PullFormat.class.php');
require_once('TimeEditAPI/OutputType.class.php');
require_once('TimeEditAPI/ObjectType.class.php');
require_once('TimeEditAPI/ITimeParameter.class.php');

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
        
        $schedule = array();
        
        $iterator = $includedObjects->getIterator();
        foreach ($iterator as $timeObject)
        {
            $include = true;
            $objTitle = '';
            foreach ($timeObject->getCourseCodes() as $codeSet)
            {
                if (is_array($codeSet))
                {
                    foreach ($codeSet as $code =>$title)
                    {
                        if (!in_array($title, $exludedObjects))
                        {
                            $include = true;
                            $objTitle = $title;
                        }
                    }
                }
                else // Demokratitid
                {
                    $include = true;
                    $objTitle = $codeSet;
                }
            }
            
            if ($include)
            {
                $obj = new ScheduleObject($timeObject->getID(), $objTitle, $timeObject->getRoom(), $timeObject->getTimeStart(), $timeObject->getTimeEnd());
                
                $day = $obj->getStart()->format('w');
                $hour = $obj->getStart()->format('G');
        
                if (!isset($schedule[$day][$hour]))
                    $schedule[$day][$hour] = new ScheduleLane();
                
                $schedule[$day][$hour]->insertItem($obj);
            }
            else
            {
                echo 'EXCLUDED<br/>';   
            }
        }
        
        return $schedule;
    }
}

?>