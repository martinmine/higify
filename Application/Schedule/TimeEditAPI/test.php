<?php
require_once('TimeEditAPIController.class.php');
require_once('PullFormat.class.php');
require_once('OutputType.class.php');
require_once('ObjectType.class.php');
require_once('ITimeParameter.class.php');

$response = TimeEditAPIController::search(ObjectType::LECTURER, 'Tom Røise', 10);
print_r($response);

//$table = TimeEditAPIController::getTimeTable(161209, 185, PullFormat::ICS, OutputType::TIME_TABLE, Minutes::now(), new Months(2), true);
//print_r($table);

//header('Content-Type: text/xml; charset=utf-8');
//echo $xml;


?>