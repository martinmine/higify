<?php
require_once('TimeEditAPIModel.class.php');
require_once('PullFormat.class.php');
require_once('ObjectType.class.php');
require_once('TimeTableViewFactory.class.php');
require_once('TimeTable.class.php');

/**
 * API Towards TimeEdit, all the calls for getting data from TimeEdit 
 * is managed by this class from outside the API
 */
class TimeEditAPIController
{
    /**
     * The base URL used for looking up time tables
     */
    const BASE_TIME_TABLE_URL = 'https://web.timeedit.se/hig_no/db1/open/r.%s?sid=3&h=t&p=%s,%s&objects=%d.%d&ox=0&types=0&fe=0&l=en';

    /**
     * The base URL used for searching objects (courses, lecturer, classes, etc.)
     */
    const BASE_SEARCH_URL = 'https://web.timeedit.se/hig_no/db1/open/objects.%s?max=%d&sid=3&partajax=t&l=en&types=%d&search_text=%s';
	
    /**
     * Performs a search on TimeEdit and returns an array of SearchResult with the result data
     * @param integer $objectType Defines what we are searching for (room, lecturer, etc.), defined in ObjectType class
     * @param string  $searchText The input search streng for match, for example 'dev'   
     * @param integer $maxResult  Max amounts of results to be returned from the server
     * @return Array All the SearchResult objects which was found 
     */
    public static function search($objectType, $searchText, $maxResult)
    {
        $queryURL = sprintf(TimeEditAPIController::BASE_SEARCH_URL, '%s', intval($maxResult), intval($objectType), self::urlEncode($searchText));
        $model = new TimeEditAPIModel($queryURL);
        return $model->parseJSON();
    }
    
    /**
     * Encodes the input value for URL and adds escape characters for the sprintf method
     * @param string $string Value to URL encode
     */
    private static function urlEncode($string)
    {
        return str_replace('%', '%%', urlencode($string));
    }
    
    /**
     * Gets the time table from TimeEdit according to the parameters specified
     * @param  integer        $objectID     ID of what to look up
     * @param  integer        $type         What type to look up (lecturer, room, etc.)
     * @param  PullFormat     $format       Which format to get back
     * @param  OutputFormat   $outputFormat Which format the user wants back (JSON,XML,DOMDocument, etc)
	 * @param  ITimeParameter $from         What time we want the time table to begin at
	 * @param  ITimeParameter $to           What time we want the time table to end at
     * @param  boolean        $getAllData   Get all data available on the object ID (ID, coursecode/desc)
     */
    public static function getTimeTable($objectID, $type, $format, $outputFormat, ITimeParameter $from, 
										ITimeParameter $to, $getAllData = false)
    {
        $queryURL = sprintf(TimeEditAPIController::BASE_TIME_TABLE_URL, '%s',
							$from->serialize(), $to->serialize(), intval($objectID), intval($type));
        $model = new TimeEditAPIModel($queryURL);
        $timeTable = new TimeTable();
        
        switch ($format)
        {
            case PullFormat::ICS:
                {
                    $model->parseICS($timeTable);
                    break;   
                }
            
            case PullFormat::CSV:
                {
                    $model->parseCSV($timeTable);
                    break;
                }
            default:	// Invalid argument
                {
                    throw new InvalidArgumentException("The format $outputFormat is unknown or not supported ");
                }
        }
        
        if ($getAllData)
            $timeTable = $model->fillMissingData($format, $timeTable);
		
		$view = TimeTableViewFactory::getView($outputFormat);
        return $view->render($timeTable);
    }
    
    /**
     * Merges two data sets into one new TimeTable, identital events are merged while the difference is also added (Union)
     * @param TimeTable $left The first table to merge
     * @param TimeTable $right The second table to merge
     * @return An array of all the TableObjects: The union of the TimeTableObjects in left and right TimeTable
     */
    public static function merge(TimeTable $left, TimeTable $right)
    {
        $merged = array();
        $leftIterator = $left->getIterator();
        $rightIterator = $right->getIterator();
        
        $leftItem = NULL;
        $rightItem = NULL;
        
        do
        {
            if ($leftItem === NULL && $leftIterator->valid())
            {
                $leftItem = $leftIterator->current();
            }
            if ($rightItem === NULL && $rightIterator->valid())
            {
                $rightItem = $rightIterator->current();
            }
            
            if ($leftItem !== NULL && $rightItem !== NULL) // Still items to merge
            {
                // If they equal, just add one of them and continue TO THE LEFT TO THE LEFT
                if ($leftItem->match($rightItem))
                {
                    $merged[] = $leftItem;
                    
                    $leftIterator->next();  // advance the items
                    $leftItem = NULL;
                    $rightIterator->next();
                    $rightItem = NULL;
                    
                }
                  // left items comes before right item (lowest time), then left item's time is LESS than right item's time
                else if ($leftItem->getTimeStart() < $rightItem->getTimeStart()) // LEFT begins first
                {
                    $merged[] = $leftItem;
                    $leftIterator->next();  // advance the items
                    $leftItem = NULL;
                }
                else // Then the right must be the first one
                {
                    $merged[] = $rightItem;
                    $rightIterator->next();
                    $rightItem = NULL;
                }
            }
            else
            {
                if ($leftItem !== NULL) // Push whatever is not null to the array
                {
                    $merged[] = $leftItem;
                    $leftIterator->next();
                    $leftItem = NULL;
                }
                else
                {
                    $merged[] = $rightItem;
                    $rightIterator->next();
                    $rightItem = NULL;
                }
            }
        }
        while ($leftIterator->valid() || $rightIterator->valid()); // While anything left in any of the data sets
        
        return $merged;   
    }
}
?>