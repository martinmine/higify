<?php

$schedule = json_decode($_POST['scheduleData']);

foreach ($schedule as $timeObject)
{
    $objectID = $timeObject->id;
    $objectType = $timeObject->type;
    $objectInfo = $timeObject->info;
    $objectDesc = $timeObject->desc;
    
    echo "$objectID - $objectType - $objectInfo - $objectDesc:<br/>";
    
    $scheduleElements = $timeObject->results;
    foreach ($scheduleElements as $lecture)
    {
        $code = $lecture->code;
        $desc = $lecture->desc;
        $enabled = $lecture->enabled;
        
        echo "&nbsp;&nbsp;&nbsp;&nbsp;$code - $desc - $enabled<br/>";
    }
    
    echo "<br/>";
}

?>