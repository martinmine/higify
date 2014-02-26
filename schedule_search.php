<?php
require_once('Schedule/ScheduleController.class.php');

$json = ScheduleController::searchSchedule(urldecode($_GET['searchText']), intval(urldecode($_GET['searchType'])));

header('Content-Type: application/json');
echo json_encode($json);
?>