<?php
require_once('Schedule/ScheduleController.class.php');
require_once('SessionController.class.php');

$userID = SessionController::requestLoggedinID();

$json = ScheduleController::getScheduleWizzardData($userID);

header('Content-Type: application/json');
echo json_encode($json);
?>