<?php
require_once('../Schedule/TimeEditAPI/TimeEditAPIController.class.php');
require_once('../Schedule/TimeEditAPI/ObjectType.class.php');
require_once('../Schedule/TimeEditAPI/SearchResult.class.php');
require_once('../Schedule/TimeEditAPI/PullFormat.class.php');
require_once('../Schedule/TimeEditAPI/OutputType.class.php');
require_once('../Schedule/TimeEditAPI/ITimeParameter.class.php');
require_once('../Schedule/TimeEditAPI/TimeTable.class.php');
require_once('../Schedule/TimeEditAPI/TimeTableIterator.class.php');

const MAX_RESPONSE = 1;

$searchText = urldecode($_GET['searchText']);
$searchType = intval(urldecode($_GET['searchType']));

$response = TimeEditAPIController::search($searchType, $searchText, MAX_RESPONSE);

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
        $timeTable = TimeEditAPIController::getTimeTable($searchResult->getID(), $searchResult->getType(), PullFormat::ICS, OutputType::TIME_TABLE, Minutes::now(), new Months(2), true);
        
        $timeTableIterator = $timeTable->getIterator();
		
		foreach ($timeTableIterator as $timeObject)
		{
            if (is_array($timeObject->getCourseCodes()))
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

$json = array('count' => count($results),
              'id'   => $id,
              'type' => $searchType,
              'info' => $info,
              'desc' => $desc,
              'results' => $results);

header('Content-Type: application/json');
echo json_encode($json);

/*
{
	"count":3,
	"results": 
	[
		{"id": "1", "type": 213, "name": "IMT2291 - WWW-teknologi"},
		{"id": "2", "type": 213, "name": "IMT2282 - Operativsystemer"},
		{"id": "3", "type": 213, "name": "IMT3681 - IT-ledelse"}
	]
}*/
?>