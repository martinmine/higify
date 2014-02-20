<?php
require_once('../TimeEditAPI/TimeEditAPIController.class.php');
require_once('../TimeEditAPI/ObjectType.class.php');
require_once('../TimeEditAPI/SearchResult.class.php');
require_once('../TimeEditAPI/PullFormat.class.php');
require_once('../TimeEditAPI/OutputType.class.php');
require_once('../TimeEditAPI/ITimeParameter.class.php');
require_once('../TimeEditAPI/TimeTable.class.php');
require_once('../TimeEditAPI/TimeTableIterator.class.php');

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
            foreach ($timeObject->getCourseCodes() as $keyValuePair)
            {
                if (is_array($keyValuePair))
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
    }
    
    foreach ($uniqueCourses as $code => $desc)
    {
        $results[] = array('code' => $code, 
                           'desc' => $desc);
    }
}

$info = '';
$desc = '';

if (count($response) > 0)
{
    $info = $response[0]->getInfo();
    $desc = $response[0]->getDescription();
}


$json = array('count' => count($results),
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