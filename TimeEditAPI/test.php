<?php
require_once('TimeEditAPIController.class.php');
require_once('PullFormat.class.php');
require_once('OutputType.class.php');
require_once('ObjectType.class.php');
require_once('ITimeParameter.class.php');
//$response = TimeEditAPIController::search(ObjectType::ROOM, 'K', 10);
//echo count($response);

$xml = TimeEditAPIController::getTimeTable(161569, 182, PullFormat::ICS, OutputType::XML_DOCUMENT, Minutes::now(), new Months(2));
//print_r($table);
header('Content-Type: text/xml; charset=utf-8');
echo $xml;


?>