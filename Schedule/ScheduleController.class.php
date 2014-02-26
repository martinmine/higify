<?php
require_once('ScheduleModel.class.php');
require_once('ScheduleLane.class.php');
require_once('ScheduleObject.class.php');
require_once('TimeEditAPI/PullFormat.class.php');
require_once('TimeEditAPI/OutputType.class.php');
require_once('TimeEditAPI/ObjectType.class.php');
require_once('TimeEditAPI/ITimeParameter.class.php');
require_once('ColorFactory.class.php');

/**
 * Manages integration and formatting of schedules
 */
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
    
    /**
     * Gets the time schedule for one day
     * @param integer $userID The user ID
     * @return Array of all the time objects where the index is the ID of the schedule objects
     */
    public static function fetchScheduleForTheDay($userID)
    {
        $from = new DateTime();
        $from->modify('midnight');
        
        $to = new DateTime();
        $to->modify('midnight +1 days');
        
        $now = new DateTime();
        
        $scheduleLanes = self::fetchTimeTable($userID, $from, $to);
        $schedule = array();
        $currCount = 0;
        $maxCount = 7;
        
        foreach ($scheduleLanes as $dayNumber => $hours)
        {
            foreach ($hours as $index => $cell)
            {
                foreach ($cell as $item)
                {
                    if ($item->getEnd() > $now)
                    {
                        $schedule[] = $item;
                        if (++$currCount >= $maxCount)
                            return $schedule;
                    }
                }
            }
        }
     
        return $schedule;
    }
    
    /**
     * Gets the schedule for a given week, if no week is defined it uses the current week number
     * @param integer $userID 
     * @param integer $weekNo 
     * @return Array of ScheduleLane objects where the index is the day number of the week
     */
    public static function fetchScheduleForWeek($userID, $weekNo = NULL)
    {
        if ($weekNo === NULL)
            $weekNo = date('W');
        
        $from = new DateTime();
        $from->setISODate(date('Y'), $weekNo)->modify('midnight');
        $to = new DateTime();
        $to->setISODate(date('Y'), $weekNo)->modify('midnight +6 days');
        
        return self::fetchTimeTable($userID, $from, $to);
    }
    
    /**
     * Gets the time table between a time range
     * @param integer $userID User's ID
     * @param DateTime $begin Time span begin
     * @param DateTime $end Time span end
     * @return Array of ScheduleLane objects where the index is the day number of the week
     */
    public static function fetchTimeTable($userID, DateTime $begin, DateTime $end)
    {
        $includedObjects = ScheduleModel::getIncludeObjects($userID, $begin, $end);
        $exludedObjects = ScheduleModel::getExcludingTimeObject($userID);
        
        $schedule = array();
        $colorFact = new ColorFactory();
        
        
        $iterator = $includedObjects->getIterator();
        foreach ($iterator as $timeObject)
        {
            $include = false;
            $objTitle = '';
            if (is_string($timeObject->getCourseCodes()))
            {
                $include = true;
                $objTitle = $timeObject->getCourseCodes();
            }
            else
            {
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
            }
            
            if ($include)
            {
                $objColor = $colorFact->produceCode($objTitle);
                $obj = new ScheduleObject($timeObject->getID(), $objTitle, $timeObject->getRoom(), $timeObject->getTimeStart(), $timeObject->getTimeEnd(), $objColor);
                
                $day = $obj->getStart()->format('w');
        
                if (!isset($schedule[$day]))
                    $schedule[$day] = new ScheduleLane();
                
                $schedule[$day]->insertItem($obj);
            }
        }
        
        $orderedItems = array();
        foreach ($schedule as $day => $lane) // Format them and put them into each lane - formats parallel objects
        {
            $laneItems = $lane->getLane();
            foreach ($laneItems as $obj)
            {
                $hour = $obj->getStart()->format('G');
                $orderedItems[$day][$hour][] = $obj;
            }
        }
        
        return $orderedItems;
    }
}

?>