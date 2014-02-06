<?php
require_once('TimeEditAPIModel.class.php');
require_once('TimeEditAPIView.class.php');

class TimeEditAPIController
{
    const BASE_TIME_TABLE_URL = 'https://web.timeedit.se/hig_no/db1/open/r.%s?sid=3&h=t&p=0.minutes,2.months&objects=%d.%d&ox=0&types=0&fe=0&l=en';
    const BASE_SEARCH_URL = 'https://web.timeedit.se/hig_no/db1/open/objects.%s?max=15&partajax=t&l=en&types=%d&search_text=%s';

    public function search($type, $searchText)
    {
        $queryURL = sprintf(TimeEditAPIController::BASE_SEARCH_URL, 'JSON', $type, $searchText);
        $model = new TimeEditAPIModel($queryURL);
        
        return $model->parseJSONSearch();
    }
    
    //web.timeedit.se/hig_no/db1/timeedit/p/open/r.html?sid=3&h=t&p=0.minutes,2.months&objects=161569.182&ox=0&types=0&fe=0
    //getTimeTable(161569, 182, 'CSV', 'TimeTable');
    public function getTimeTable($objectID, $type, $format, $outputFormat, $getAllData = false)
    {
        $queryURL = sprintf(TimeEditAPIController::BASE_TIME_TABLE_URL, strtolower($format), $objectID, $type);
        $model = new TimeEditAPIModel($queryURL);
        $timeTable = new TimeTable();
        
        switch ($format)
        {
            case 'ICS':
                {
                    $model->parseICS($timeTable);
                    break;   
                }
            
            case 'CSV':
                {
                    $model->parseCSV($timeTable);
                    break;
                }
            default:
                {
                    throw new Exception('Invalid argument ' . $outputFormat);
                }
        }
        
        if ($getAllData)
            $model->fillMissingData($timeTable, $format);
        
        switch ($outputFormat)
        {
            /*case 'XML': Not yet implemented
                {
                    return TimeEditAPIView::getXML($timeTable);
                }
            case 'JSON':
                {
                    return TimeEditAPIView::getJSON($timeTable);
                }
            case 'DOM':
                {
                    return TimeEditAPIView::getDOMDocument($timeTable);
                }*/
            case 'TimeTable':
                {
                    return $timeTable;
                }
        }
    }
}
?>