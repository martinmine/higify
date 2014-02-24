<?php
require_once('TimeEditAPI/PullFormat.class.php');
require_once('TimeEditAPI/OutputType.class.php');
require_once('TimeEditAPI/ObjectType.class.php');
require_once('TimeEditAPI/ITimeParameter.class.php');
require_once('TimeEditAPI/TimeEditAPIController.class.php');


//$first = TimeEditAPIController::getTimeTable(160546, 184, PullFormat::CSV, OutputType::TIME_TABLE, Minutes::now(), new Weeks(1), true);

$first = TimeEditAPIController::getTimeTable(160546, 184, PullFormat::ICS, OutputType::TIME_TABLE, Minutes::now(), new Weeks(1), true);
$second = TimeEditAPIController::getTimeTable(161569, 182, PullFormat::ICS, OutputType::TIME_TABLE, Minutes::now(), new Weeks(1), true);

print_r(TimeEditAPIController::merge($first, $second)); 

?>