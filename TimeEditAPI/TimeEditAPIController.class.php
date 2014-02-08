<?php
require_once('TimeEditAPIModel.class.php');
require_once('TimeEditAPIView.class.php');
require_once('PullFormat.class.php');

class TimeEditAPIController
{
    /**
     * The base URL used for looking up time tables
     */
    const BASE_TIME_TABLE_URL = 'https://web.timeedit.se/hig_no/db1/open/r.%s?sid=3&h=t&p=0.minutes,2.months&objects=%d.%d&ox=0&types=0&fe=0&l=en';

    /**
     * The base URL used for searching objects (courses, lecturer, classes, etc.)
     */
    const BASE_SEARCH_URL = 'https://web.timeedit.se/hig_no/db1/open/objects.%s?max=15&partajax=t&l=en&types=%d&search_text=%s';
	
	/**
     * TODO
     * @param  [type] $type       [description]
     * @param  [type] $searchText [description]
     * @return [type]             [description]
     */
    public static function search($type, $searchText)
    {
        $queryURL = sprintf(TimeEditAPIController::BASE_SEARCH_URL, '%s', $type, $searchText);
        $model = new TimeEditAPIModel($queryURL);
        
        return $model->parseJSONSearch();
    }
    
    /**
     * Gets the time table for the assigned parameters
     * @param  integer  $objectID     ID of what to look up
     * @param  integer  $type         What type to look up (lecturer, room, etc.)
     * @param  PullFormat  $format       Which format to get back
     * @param  OutputFormat  $outputFormat Which format the user wants back (JSON,XML,DOMDocument, etc)
     * @param  boolean $getAllData   If the user wants absolutely all data available on the object ID (ID, coursecode/desc)
     */
    public static function getTimeTable($objectID, $type, $format, $outputFormat, $getAllData = false)
    {
        $queryURL = sprintf(TimeEditAPIController::BASE_TIME_TABLE_URL, '%s', $objectID, $type);
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
            default:
                {
                    throw new Exception("The output format $outputFormat is unknown or not supported ");
                }
        }
        
        if ($getAllData)
            $timeTable = $model->fillMissingData($format, $timeTable);
       
		return TimeEditAPIView::render($timeTable, $outputFormat);
    }
}
?>