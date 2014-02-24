<?php
require_once('ScheduleModel.class.php');
require_once('ScheduleLane.class.php');
require_once('ScheduleObject.class.php');
require_once('TimeEditAPI/PullFormat.class.php');
require_once('TimeEditAPI/OutputType.class.php');
require_once('TimeEditAPI/ObjectType.class.php');
require_once('TimeEditAPI/ITimeParameter.class.php');
require_once('ColorFactory.class.php');

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
    
    public static function fetchScheduleForTheDay($userID)
    {
        $from = new DateTime();
        $from->modify('midnight');
        
        $to = new DateTime();
        $to->modify('midnight +1 days');
        
     
        return self::fetchTimeTable($userID, $from, $to);
    }
    
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
        foreach ($schedule as $day => $lane)
        {
            $laneItems = $lane->getLane();
            foreach ($laneItems as $obj)
            {
                $hour = $obj->getStart()->format('G');
                $orderedItems[$day][$hour][] = $obj;
            }
        }
        
        //print_r($orderedItems[1]);
        //die();
        return $orderedItems;
    }
}

?>