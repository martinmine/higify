<?php
require_once('TimeEditAPIController.class.php');

$everything = TimeEditAPIController::getTimeTable(161569, 182, 'CSV', 'TimeTable');
print_r($everything);

?>