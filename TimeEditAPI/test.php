<?php
require_once('TimeEditAPIController.class.php');
require_once('PullFormat.class.php');
require_once('PullFormat.class.php');
require_once('OutputType.class.php');

$table = TimeEditAPIController::getTimeTable(161569, 182, PullFormat::ICS, OutputType::JSON, true);
header('Content-Type: text/json; charset=utf-8');
echo $table;


?>