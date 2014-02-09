<?php
require_once('TimeEditAPIController.class.php');
require_once('PullFormat.class.php');
require_once('OutputType.class.php');
require_once('ObjectType.class.php');
//$response = TimeEditAPIController::search(ObjectType::ROOM, 'K', 10);
//echo count($response);

$table = TimeEditAPIController::getTimeTable(161569, 182, PullFormat::ICS, OutputType::TIME_TABLE, true);
print_r($table);

?>