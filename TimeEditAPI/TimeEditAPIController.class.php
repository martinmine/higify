<?php
require_once('TimeEditAPIModel.class.php');
require_once('TimeEditAPIView.class.php');
require_once('PullFormat.class.php');
require_once('ObjectType.class.php');

class TimeEditAPIController
{
    /**
     * The base URL used for looking up time tables
     */
    const BASE_TIME_TABLE_URL = 'https://web.timeedit.se/hig_no/db1/open/r.%s?sid=3&h=t&p=%s,%s&objects=%d.%d&ox=0&types=0&fe=0&l=en';

    /**
     * The base URL used for searching objects (courses, lecturer, classes, etc.)
     */
    const BASE_SEARCH_URL = 'https://web.timeedit.se/hig_no/db1/open/objects.%s?max=15&sid=3&partajax=t&l=en&types=%d&search_text=%s';
	
    /**
     * Performs a search on TimeEdit and returns an array of SearchResult with the result data
     * @param integer $objectType Defines what we are searching for (room, lecturer, etc.), defined in ObjectType class
     * @param string  $searchText The input search streng for match, for example 'dev'   
     * @param integer $maxResult  Max amounts of results to be returned from the server
     * @return Array All the SearchResult objects which was found 
     */
    public static function search($objectType, $searchText, $maxResult)
    {
        $queryURL = sprintf(TimeEditAPIController::BASE_SEARCH_URL, '%s', $objectType, $searchText);
        $model = new TimeEditAPIModel($queryURL);
        return $model->parseJSON();
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
							$from->serialize(), $to->serialize(), $objectID, $type);
		die($queryURL);
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
       
		return TimeEditAPIView::render($timeTable, $outputFormat);
    }
}
?>