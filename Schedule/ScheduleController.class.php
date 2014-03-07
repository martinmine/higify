<?php
require_once('ScheduleModel.class.php');
require_once('ScheduleLane.class.php');
require_once('ScheduleObject.class.php');
require_once('TimeEditAPI/PullFormat.class.php');
require_once('TimeEditAPI/OutputType.class.php');
require_once('TimeEditAPI/ObjectType.class.php');
require_once('TimeEditAPI/ITimeParameter.class.php');
require_once('TimeEditAPI/TimeEditAPIController.class.php');
require_once('TimeEditAPI/SearchResult.class.php');
require_once('TimeEditAPI/PullFormat.class.php');
require_once('TimeEditAPI/OutputType.class.php');
require_once('TimeEditAPI/TimeTableIterator.class.php');
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
        $excludes = array();
        $includes = array();
        
        foreach ($schedule as $timeObject)
        {
            $includes[$timeObject->id] = $timeObject->type;
            
            $scheduleElements = $timeObject->results;
            foreach ($scheduleElements as $lecture)
            {
                if (!$lecture->enabled)
                {
                    $excludes[$lecture->code] = 183;
                }
            }
        }
        
        print_r($excludes);
        
        foreach ($excludes as $excludeID => $type)  // This way we avoid DUPLICATE KEY error
            ScheduleModel::addExcludingTimeObject($userID, $excludeID, $type);
            
        foreach ($includes as $includeID => $type)
            ScheduleModel::addIncludedTimeObject($userID, $includeID, $type);
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
        $includedObjects = ScheduleModel::getIncludedScheduleObjects($userID, $begin, $end);
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
                            if (!in_array($code, $exludedObjects))
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
    
    /**
     * Searches in the time schedule and returns the unique objects in the schedule
     * @param string $searchText Search terms
     * @param integer $searchType The search type
     * @return Data serialized as JSON data
     */
    public static function searchSchedule($searchText, $searchType)
    {
        $response = TimeEditAPIController::search($searchType, $searchText, 1);

        $results = array();

        if ($searchType == ObjectType::COURSECODE) // No need to request further data
        {
            foreach ($response as $searchResult)
            {
                $results[] = array('code' => $searchResult->getInfo(), 
                                   'desc' => $searchResult->getDescription());
            }    
        }
        else
        {
            $uniqueCourses = array();
            foreach ($response as $searchResult)
            {
                $courses = self::fetchUniqueCourses($searchResult->getID(), $searchResult->getType());
                foreach ($courses as $code => $desc)
                {
                    $uniqueCourses[$code] = $desc;
                }
            }
            
            foreach ($uniqueCourses as $code => $desc)
            {
                $results[] = array('code' => $code, 
                                   'desc' => $desc);
            }
        }

        $info = '';
        $desc = '';
        $id = 0;

        if (count($response) > 0)
        {
            $info = $response[0]->getInfo();
            $desc = $response[0]->getDescription();
            $id = $response[0]->getID();
        }

        return array('count' => count($results),
                      'id'   => $id,
                      'type' => $searchType,
                      'info' => $info,
                      'desc' => $desc,
                      'results' => $results);   
    }
    
    /**
     * Gets all the classes which appears on a user's schedule
     * @param integer $id The objects ID
     * @param integer $type Type of the object to look for (course, class, etc.)
     * @return Associative array of course ID => course name
     */
    private static function fetchUniqueCourses($id, $type)
    {
        $uniqueCourses = array();
        $timeTable = TimeEditAPIController::getTimeTable($id, $type, PullFormat::ICS, OutputType::TIME_TABLE, Minutes::now(), new Months(2), true);
        
        $timeTableIterator = $timeTable->getIterator();
        
        foreach ($timeTableIterator as $timeObject)
        {
            if (is_array($timeObject->getCourseCodes()))
            {
                foreach ($timeObject->getCourseCodes() as $keyValuePair)
                {
                    foreach ($keyValuePair as $courseCode => $courseDesc)
                    {
                        if (!isset($uniqueCourses[$courseCode]))
                        {
                            $uniqueCourses[$courseCode] = $courseDesc;
                        }
                    }
                }
            }
        }
        
        return $uniqueCourses;
    }
        
    /**
     * Gets all the unique course elements a user attends
     * @param integer $userID 
     * @return Assoviative array ID => description
     */
    public static function getCourseElements($userID)
    {
        $courses = array();
        $includeObjects = ScheduleModel::getIncludeObjects($userID);
        $excludeObjects = ScheduleModel::getExcludingTimeObject($userID);
        
        foreach ($includeObjects as $id => $type)
        {
            $searchResult = self::fetchUniqueCourses($id, $type);
            foreach ($searchResult as $code => $desc)
            {
                if (!in_array($code, $excludeObjects))
                    $courses[$code] = $desc;
            }
        }
        
        return $courses;
    }
    
    /**
     * Gets a presentation of all the courses and objects thats included and that is not included
     * on the user's schedule that can be serialized to JSON data
     * @param integer $userID The user ID to get the schedule data for
     * @return an associative array with the schedule data
     */
    public static function getScheduleWizzardData($userID)
    {
        $resultSet = array();
        $includeObjects = ScheduleModel::getIncludeObjects($userID);
        $excludeObjects = ScheduleModel::getExcludingTimeObject($userID);
        
        foreach ($includeObjects as $id => $type)
        {
            $includeObject = array();
            $includeObject['id'] = $id;
            $includeObject['type'] = $type;
            $includeObject['info'] = '';    // Unable to get this data
            $includeObject['desc'] = '';
            $includeObject['results'] = array();
            
            $searchResult = self::fetchUniqueCourses($id, $type);
            foreach ($searchResult as $code => $desc)
            {
                $includeObject['results'][] = array('code' => $code,
                                                    'desc' => $desc,
                                                    'enabled' => in_array($code, $excludeObjects) ? 'false' : 'true');
            }
            
            $resultSet[] = $includeObject;
        }
        
        return $resultSet;
    }
}
?>